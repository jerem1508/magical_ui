<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Private_functions {

	public function __construct()
	{
	    $this->CI =& get_instance();
	}

	public function test_server_API($value='')
	{
		# Test du serveur API
		# S'il ne répond pas, affichage de la vue d'erreur
		$ch = curl_init(BASE_API_URL.'/api/ping');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if(curl_exec($ch) === FALSE){
		    //echo 'Erreur Curl : ' . curl_error($ch);
			curl_close($ch);
		    return FALSE;
		}
		else{
			curl_close($ch);
			return TRUE;
		}
	}// /test_server_api()


	public function get_metadata_api($project_type, $project_id)
	{
		# Récupération des métadata d'un projet
		$curl = curl_init();

		$url = BASE_API_URL.'/api/metadata/'.$project_type.'/'.$project_id;

		$opts = [
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		];

		curl_setopt_array($curl, $opts);

		$response = json_decode(curl_exec($curl), true);

		return $response['metadata'];
	}// /get_metadata_api()


	public function set_tab_steps_by_filename($log)
	{
		$tab = [];
		foreach ($log as $filename => $steps) {
			$t_steps = [];
			foreach ($steps as $step => $values) {
				$t_steps[$step] = ($values['completed'] || $values['skipped']);
			}
			$tab[$filename] = $t_steps;
		}

		return $tab;
	}// /set_tab_steps_by_filename()


	public function get_status($status=0)
	{
		switch ($status) {
			case PROJECT_INACTIVE:
				return 'Inactif';
			case PROJECT_USER_PRIVATE:
				return 'Privé';
			case PROJECT_USER_PUBLIC:
				return 'Public demandé';
			case PROJECT_ADMIN_PUBLIC_KO:
				return 'En cours';
			case PROJECT_ADMIN_PUBLIC_OK:
				return 'Public';
		}
	}// /get_status()


	public function is_completed_step($step_name, $project_steps, $has_mini)
	{
		$filename = str_replace('MINI__', '', key($project_steps));

	    if($project_steps[$filename]['concat_with_init']==1){
	      	return true;
	    }

		switch ($step_name) {
			case 'INIT':
				return true;
				break;

			case 'add_selected_columns':
			case 'replace_mvs':
			case 'recode_types':
				if($has_mini){
					return $project_steps['MINI__'.$filename][$step_name];
				}
				else{
					return $project_steps[$filename][$step_name];
				}

				break;
			default :
				return false;
		}
	} // /is_completed_step()


	public function get_internal_projects()
	{
		# Récupération des projets internes

		$curl = curl_init();

		$url = BASE_API_URL.'/api/public_projects/normalize';

		$opts = [
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		];

		curl_setopt_array($curl, $opts);

		$response = json_decode(curl_exec($curl), true);

		return $response;
	}// /get_internal_projects()


	public function delete_project_API($project_type = '', $project_id = '')
	{
		# Suppression d'un projet

		if($project_type == '' || $project_id == ''){
			return false;
		}

		$curl = curl_init();

		$url = BASE_API_URL.'/api/delete/'.$project_type.'/'.$project_id;

		$opts = [
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		];

		curl_setopt_array($curl, $opts);

		$response = json_decode(curl_exec($curl), true);

		return $response;

	}// /delete_project_API()


	public function send_comment_to_admin_email($message='')
	{
		# Prévient l'admin d'un nouveau commentaire

		$ci = &get_instance();
		$ci->load->library('email');

		$config_email = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'smtp-relay.sendinblue.com',
		    'smtp_port' => 587,
		    'smtp_user' => 'yann.caradec@recherche.gouv.fr',
		    'smtp_pass' => '',
		    'mailtype'  => 'html',
		    'charset'   => 'utf-8'
		);

		$ci->email->initialize($config_email);
		$ci->email->set_newline("\r\n");

		// Set to, from, message, etc.
		$ci->email->from('YOUREMAILHERE@gmail.com', 'YOUREMAILHERE@gmail.com');
		$ci->email->to('jeremy.peglion@gmail.com');
		$ci->email->subject('Test email from CI and Gmail');
		$ci->email->message('This is a test.');

		$result = $ci->email->send();

		// $ci = get_instance();
		// $ci->load->library('email');
		// $config['protocol'] = 'smtp';
		// //$config['smtp_host'] = "ssl://smtp.gmail.com";
		// $config['smtp_host'] = 'smtp-relay.sendinblue.com';
		// //$config['smtp_port'] = "465";
		// $config['smtp_port'] = '587';
		// $config['smtp_user'] = 'yann.caradec@recherche.gouv.fr';
		// $config['smtp_pass'] = 'zxk3Tr5WpYqMELfU';
		// $config['charset'] = 'utf-8';
		// $config['mailtype'] = 'html';
		// $config['newline'] = "\r\n";
        //
		// $ci->email->initialize($config);
        //
		// $ci->email->from('admin@la-machine-a-donnees.com', 'Admin');
		// $list = ADMIN_EMAIL;
		// $ci->email->to($list);
		// //$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
		// $ci->email->subject('MAD - Nouveau commentaire');
		// $ci->email->message($message);
		// $ci->email->send();

	}// /send_comment_to_admin_email()


	public function send_email_to_user($email='', $subject='', $message='')
	{
		# code...
	}// /send_email_to_user()
}// /Class
