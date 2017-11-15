<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public $normalized_projects = [];
	public $linked_projects = [];

	public function __construct()
	{
		parent::__construct();

		//$this->load->helper('captcha');
		$this->load->model('User_model');
		$this->load->model('Projects_model');

		$this->load->library('Private_functions');

		// test de la langue
		// Francais par defaut
		if(!isset($_SESSION['language'])){
			$this->session->set_userdata('language', 'fr');
		}

		// test du serveur API - Affiche une vue d'erreur
		if($this->private_functions->test_server_API() == false){
			// TODO : Sauvegarde de l'erreur en BDD

			redirect('/Home/error');
		}

	}// /__construct()

	public function index()
	{
		//$this->load->view('home_'.$_SESSION['language']);
		redirect('/Home');
	}// /index()


	public function new($msg='')
	{
		if(isset($_SESSION['user'])){
			redirect('/Home');
		}

		$data['msg'] = $msg;
		$data['title'] = "Identification";

		$this->load->view('lib', $data);
		$this->load->view('user_signin_signup_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		// $this->load->view('user_new_'.$_SESSION['language'], $data);
		$this->load->view('user_signin_signup_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /new()


	public function new_save()
	{
		try{
			$email = $this->input->post('usr_email');
			$pwd = $this->input->post('usr_pwd');

			// test user existant
			$ret = $this->User_model->exist_user($email);

			if($ret->result_id->num_rows > 0){
				// email deja existant
				$this->new("Cet email existe déjà !");
			}
			else{
				// insertion du user
				$ret = $this->User_model->insert_user($email, $pwd);
			}
			$error = '';
		}
		catch(Exception $e){
			switch ($_SESSION['language']) {
				case 'en':
					$error = INTERNAL_ERROR_EN;
					break;
				case 'fr':
					$error = INTERNAL_ERROR_FR;
					break;
				default:
					$error = INTERNAL_ERROR_EN;
					break;
			}
		}

		// Enregistrement en session
		$user = array('id' => $ret['id'], 'email' => $email, 'status' => $ret['status']);
		$this->session->set_userdata('user', $user);

		redirect('/Home');

		// // Chargement du tableau de bord
		// $this->dashboard($error);
	}// /new_save()


	public function login($next='', $msg='')
	{
		if(isset($_SESSION['user'])){
			redirect('/Home');
		}

		$data['msg'] = $msg;
		$data['next'] = $next;
		$data['title'] = "Identification";

		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('user_login_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /login()


	public function login_validation($msg='')
	{
		$email = $this->input->post('email');
		$pwd = $this->input->post('pwd');
		$next = $this->input->post('next');

		// test user existant
		$ret = $this->User_model->get_user($email);

		// si email trouvé, on compare les mdp
		if($ret['id'] != 0){
			$pwd = md5($pwd.$ret['salt']);
			if ($pwd == $ret['pwd']) {
				// Sauvegarde en session
				$user = array('id' => $ret['id'], 'email' => $email, 'status' => $ret['status']);
				$this->session->set_userdata('user', $user);

				// log
				$ret = $this->User_model->set_log_users($ret['id']);

				switch ($next) {
					case 'normalize':
						// Chargement du tableau de bord
						redirect('/Project/normalize');
						break;
					case 'link':
						// Chargement du tableau de bord
						redirect('/Project/link');
						break;
					
					default:
						// Chargement du tableau de bord
						redirect('/User/dashboard');
						break;
				}

			}
			else{
				$this->login("","Mot de passe erroné !");	
			}
		}
		else{
			$this->login("","Email erroné !");
		}
	}// /login_validation()


	public function logout()
	{
		$this->session->unset_userdata('user');

		redirect('/Home');
	}// /logout()


	public function dashboard($error='')
	{
		if(!isset($_SESSION['user'])){
			redirect('/Home');
		}

		try{
			// Récupération des projets
			$this-> split_projects($_SESSION['user']['id']);
		}
		catch(Exception $e){
			$error = $e->getMessage();
			$this->log_error($error);
		}

		$data['server_error'] = $error;
		$data['normalized_projects'] = $this->normalized_projects;
		$data['linked_projects'] = $this->linked_projects;
		$data['title'] = "Tableau de bord";

		// Chargement des vue
		$this->load->view('lib', $data);
		$this->load->view('user_dashboard_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('user_dashboard_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /dashboard()


	public function split_projects($user_id) // Répartition des projets selon leur type
	{
		$projects_list = $this->Projects_model->get_projects($user_id);
		foreach ($projects_list as $project) {
			// Appel de l'API pour récupérer les infos de chaque projet
			$project_api = $this->private_functions->get_metadata_api($project['project_type'], $project['project_id']);

			if(!$project_api){
				// Suppression du projet en base car il n'exise pas sur le serveur data
				$this->load->model('Projects_model');
				$this->Comments_model->delete_project($project['project_id']);
				//throw new Exception("An internal synchronization error occurred on our server", 1);
			}

			$project['project_id'] = $project_api['project_id'];
			$project['display_name'] = $project_api['display_name'];
			$project['description'] = $project_api['description'];
			$project['project_type'] = $project_api['project_type'];

			$project['steps_by_filename'] = $this->private_functions->set_tab_steps_by_filename($project_api['log']);

			if($project_api['project_type'] == 'normalize'){
				$project['has_mini'] = @$project_api['has_mini'];
				$project['file'] = @key($project_api['files']);
				$project['public'] = (isset($project_api['public'])) ? $project_api['public'] : false;

				$this->normalized_projects[] = $project;
			}
			else{
				$project['file_src'] = $project_api['files']['source']['file_name'];
				$project['file_ref'] = $project_api['files']['ref']['file_name'];

				$this->linked_projects[] = $project;
			}
		}// /foreach
	}// /split_projects()


	public function last_written($project_type, $project_id)
	{	
		$params=['before_module'=>'recode_types'];

		$curl = curl_init();
		 
		$url = BASE_API_URL.'/api/last_written/'.$project_type.'/'.$project_id;

		$opts = [
		    CURLOPT_URL => $url,
		    CURLOPT_HTTPHEADER => array( 'Content-Type: application/json'),
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => json_encode($params)
		];


		curl_setopt_array($curl, $opts);
		 
		$response = json_decode(curl_exec($curl), true);

		return $response;
	}// /last_written()


	public function log_error($comment)
	{
		# Enregistrement des erreurs en base
		$data_to_write['comment'] = $comment;
		$data_to_write['user_id'] = "0";

		// Chargement du modèle
		$this->load->model('Comments_model');

		// Insertion
		$this->Comments_model->insert_comment($data_to_write);
	}// /log_error()

}