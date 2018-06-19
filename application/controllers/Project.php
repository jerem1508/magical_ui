<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

	public $normalized_projects = [];
	public $linked_projects = [];
	//public $secret_key = "";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Projects_model');

		$this->load->library('Private_functions');

		// test de la session user
		// Francais par defaut
		if(!isset($_SESSION['user'])){
			redirect('/User/new');
		}

		// test de la langue
		// Francais par defaut
		if(!isset($_SESSION['language'])){
			$this->session->set_userdata('language', 'fr');
		}

		//$this->secret_key = $this->config->item('secret_key');
	}// /__construct()


	public function index()
	{
		$this->load->view('home');
	}// /index()


	public function normalize($project_id='', $step='')
	{
		// Sauvegarde en session du type de projet
		$this->session->set_userdata('project_type', 'normalize');

		if(isset($project_id)){
			$this->session->set_userdata('project_id', $project_id);
			//$this->session->set_userdata('custom_key', md5($project_id.$this->secret_key));
		}

		// Si normalisation, on efface l'éventuel lien vers un projet de link
		//$this->session->unset_userdata('link_project_id');

		// Recherche de l'étape en cours si non passée dans l'URL
		if(!$step){
			$step = $this->get_actual_step_normalization($_SESSION['project_id']);
		}

		// Chargement de l'étape
		$this->load_step_normalization($step, $project_id);
	}// /normalize()


	public function get_step_normalization($steps)
	{
		if($steps['concat_with_init']['completed'] || $steps['concat_with_init']['skipped']){
			return 'concat_with_init';
		}
		elseif($steps['recode_types']['completed'] || $steps['recode_types']['skipped']){
			return 'recode_types';
		}
		elseif($steps['infer_types']['completed'] || $steps['infer_types']['skipped']){
			return 'recode_types';
		}
		elseif($steps['replace_mvs']['completed'] || $steps['replace_mvs']['skipped']){
			return 'replace_mvs';
		}
		elseif($steps['infer_mvs']['completed'] || $steps['infer_mvs']['skipped']){
			return 'replace_mvs';
		}
		elseif($steps['add_selected_columns']['completed'] || $steps['add_selected_columns']['skipped']){
			return 'add_selected_columns';
		}
		return false;
	}// /get_step_normalization()


	public function get_step_normalization_order($step='')
	{
		switch ($step) {
			case 'concat_with_init':
				return 5;
				break;
			case 'recode_types':
				return 4;
				break;
			case 'replace_mvs':
				return 3;
				break;
			case 'add_selected_columns':
				return 2;
				break;
			case 'INIT':
				return 1;
				break;
			default:
				return 0;
		}
	}// /get_step_normalization_order()


	public function get_actual_step_normalization($project_id='')
	{
		if($project_id==''){
			return 'INIT';
		}

		$project_api = $this->private_functions->get_metadata_api('normalize', $project_id);
		$file_name = key($project_api['files']);

		$steps = $project_api['log'][$file_name];


		$actual_step = $this->get_step_normalization($steps);
		$actual_step_order = $this->get_step_normalization_order($actual_step);

		// // Si toutes les étapes du fichier non MINI sont vides, on vérifie le MINI
		if($project_api['has_mini']){
			$file_name = 'MINI__'.$file_name;

			$steps = $project_api['log'][$file_name];

			$actual_step_mini = $this->get_step_normalization($steps);
			$actual_step_mini_order = $this->get_step_normalization_order($actual_step_mini);

			if($actual_step_mini_order > $actual_step_order){
				$actual_step = $actual_step_mini;
			}
		}
		if($actual_step){
			return $actual_step;
		}
		else{
			return 'INIT';
		}
	}// /get_actual_step_normalization()


	public function load_step_normalization($step, $project_id='')
	{
		if($project_id==''){
			$this->load_step1_init();
			return;
		}

		switch ($step) {
			case 'INIT':
				$this->add_selected_columns($project_id);
				break;

			case 'add_selected_columns':
				$this->replace_mvs($project_id);
				// TODO : Faire un skip
				break;

			case 'replace_mvs':
				$this->recode_types($project_id);
				break;

			case 'recode_types':
				$this->concat_with_init($project_id);
				break;

			case 'concat_with_init':
				$this->concat_with_init($project_id);
				break;

			default:
				$this->load_step1_init();
		}
	}// /load_step_normalization()


	public function get_normalization_projects($project_id)
	{
		# Récupère les projets de normalisation compris dans un projet de link
		$tab = [];

		// Récupération des metadata du projet de link
		$tab_metadata_link_project = $this->private_functions->get_metadata_api('link', $project_id);

		// Récupération des 2 ids des projets de normalisation
		$src_project_id = $tab_metadata_link_project['files']['source']['project_id'];
		$ref_project_id = $tab_metadata_link_project['files']['ref']['project_id'];

		// Récupération des métadata des projets de normalisation
		$tab['source'] = $this->private_functions->get_metadata_api('normalize', $src_project_id);
		$tab['ref'] = $this->private_functions->get_metadata_api('normalize', $ref_project_id);

		// Renvoi d'un tableau contenant les métadata par projet de normalisation
		return $tab;
	}// /get_normalization_projects()


	public function link($link_project_id='')
	{
		// MAJ du type de projet en session
		$this->session->set_userdata('project_type', 'link');

		if(isset($link_project_id)){
			$this->session->set_userdata('link_project_id', $link_project_id);
			//$this->session->set_userdata('custom_key', md5($link_project_id.$this->secret_key));
		}

		// Recherche de l'étape en cours
		$link_step = $this->get_actual_step_linker($link_project_id);

		// project_id inconnu
		if(!$link_step && $link_project_id != ''){
			redirect('/Home/undefined');
		}

		if($link_project_id && $link_step == 'INIT'){
			// tests de complétude des projets de normalisation
			$normalized_projects = $this->get_normalization_projects($link_project_id);

			foreach ($normalized_projects as $normalized_project) {
				// Rechercher l'étape du projet
				$step = $this->get_actual_step_normalization($normalized_project['project_id']);

				// Sauvegarde du project_id afin de pouvoir revenir au projet de link apres la normalisation
				$this->session->set_userdata('link_project_id', $link_project_id);

				//si pas fini, redirection vers la normalisation
				if($step != 'concat_with_init'){
					$this->session->set_userdata('project_id', $normalized_project['project_id']);
					redirect('/Project/load_step_normalization/'.$step.'/'.$normalized_project['project_id']);
				}
			}
		}
		$this->load_step_linker($link_step, $link_project_id);
	}// /link()


	public function get_actual_step_linker($project_id='')
	{
		if($project_id == ''){
			return '';
		}

		// Récupération des métadata
		$project_api = $this->private_functions->get_metadata_api('link', $project_id);

		// project_id inconnu
		if(empty($project_api)){
			return false;
		}

		$file_name = $project_api['files']['source']['file_name'];
		$steps = $project_api['log'][$file_name];

		if($steps['link_results_analyzer']['completed'] || $steps['link_results_analyzer']['skipped']){
			return 'link_results_analyzer';
		}
		if($steps['es_linker']['completed'] || $steps['es_linker']['skipped']){
			return 'es_linker';
		}
		elseif($steps['upload_es_train']['completed'] || $steps['upload_es_train']['skipped']){
			return 'upload_es_train';
		}
		elseif($steps['add_selected_columns']['completed'] || $steps['add_selected_columns']['skipped']){
			return 'add_selected_columns';
		}

		return 'INIT'; // Si project_id mais aucune étape de validée
	}// /get_actual_step_linker()


	public function load_step_linker($step, $project_id='')
	{
		switch ($step) {
			case 'INIT':
				$this->selected_columns($project_id);
				break;

			case 'add_selected_columns':
				$this->es_train($project_id);
				break;

			case 'es_train':
				$this->es_train($project_id);
				//$this->es_linker($project_id);
				break;

			case 'upload_es_train':
				$this->es_linker($project_id);
				break;

			case 'es_linker':
				//$this->link_results_analyzer($project_id);
				$this->es_linker($project_id);
				break;

			case 'link_results_analyzer':
				//$this->link_results_analyzer($project_id);
				$this->es_linker($project_id);
				break;

			default:
				$this->load_link_step1_init();
		}
	}// /load_step_linker()


	public function selected_columns($id='')
	{
		# Mise en relation des colonnes du fichier source avec celles du fichier referentiel

		$data['title'] = "Association des colonnes";
		$this->load->view('lib', $data);
		$this->load->view('project_link_select_columns_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_select_columns_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /selected_columns()


	public function es_train($id='')
	{
		# Apprentissage

		$data['title'] = "Apprentissage";
		$this->load->view('lib', $data);
		$this->load->view('project_link_es_train_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_es_train_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /es_train()


	public function es_linker($id='')
	{
		# Traitement final
		$data['title'] = "Téléchargement";
		$this->load->view('lib', $data);
		$this->load->view('project_link_es_linker_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_es_linker_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /es_linker()


	public function link_results_analyzer($id='')
	{
		# Analyse des resultats

		$this->load->view('project_link_results_'.$_SESSION['language']);
		$this->load->view('footer_fr');
	}// /link_results_analyzer()


	public function test_project_id()
	{
		if(!isset($_SESSION['project_id'])){
			redirect('/Home');
		}
	}// /test_project_id()


	public function is_done_step($step_name)
	{
		$project_api = $this->private_functions->get_metadata_api($_SESSION['project_type'], $_SESSION['project_id']);
		$steps_by_filename = $this->private_functions->set_tab_steps_by_filename($project_api['log']);

		return $this->private_functions->is_completed_step($step_name, $steps_by_filename, $project_api['has_mini']);
	}// /is_done_step()


	public function load_link_step1_init()
	{
		# Chargement de la vue d'initialisation du projet

		$data = [];
		$error = '';

		// Recherche des projets de normalisation si user connecté
		if(isset($_SESSION['user'])){
			try{
				$this-> split_projects($_SESSION['user']['id']);
			}
			catch(Exception $e){
				$error = $e->getMessage();
				$this->log_error($error);
			}

			$data['normalized_projects'] = $this->normalized_projects;
			$data['linked_projects'] = $this->linked_projects;
		}

		$data['server_error'] = $error;

		// Recherche des projets internes proposés
		$data['internal_projects'] = $this->private_functions->get_internal_projects();

		// Chargement des vues
		$data['title'] = "Création d'un projet de jointure";
		$this->load->view('lib', $data);
		$this->load->view('project_link_step1_init_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_step1_init_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /load_link_step1_init()


	public function save_step1_init($project_id)
	{
		# Sauvegarde de l'initialisation du projet
		// MAJ du nom du projet en session
		// $this->session->set_userdata('project_name', $_POST['project_name']);
		// $this->session->set_userdata('project_description', $_POST['project_description']);

		// Sauvegarde bdd
		// TODO

		// Etape 2
		//redirect('/Project/load_step2_select_columns/'.$project_id);
		redirect('/Project/add_selected_columns/'.$project_id);
	}// /save_step1_init()


	public function load_step1_init()
	{
		# Chargement de la vue d'initialisation du projet

		// Chargement des vues
		$data['title'] = "Normalisation";
		$this->load->view('lib', $data);
		$this->load->view('project_normalize_init_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_normalize_init_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /load_step1_init()


	public function add_selected_columns($id="")
	{
		if(isset($id)){
			$this->session->set_userdata('project_id', $id);
			$this->session->set_userdata('project_type', 'normalize');
		}

		$this->test_project_id();

		// Chargement des vues
		$data['title'] = "Sélection des colonnes";
		$this->load->view('lib', $data);
		$this->load->view('project_normalize_select_columns_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		// Est ce que cette étape a déjà été lancée ?
		// if($this->is_done_step('add_selected_columns')){
			//$this->load->view('project_normalize_select_columns_report_'.$_SESSION['language'], $data);
		// }
		// else{
			$this->load->view('project_normalize_select_columns_'.$_SESSION['language'], $data);
		// }
		$this->load->view('footer_'.$_SESSION['language']);
	}// /add_selected_columns()


	public function replace_mvs($project_id="")
	{
		if(isset($project_id)){
			$this->session->set_userdata('project_id', $project_id);
			$this->session->set_userdata('project_type', 'normalize');
		}

		$this->test_project_id();

					// // Chargement des vues
					// $data['title'] = "Normalisation";
					// $this->load->view('lib', $data);
					// $this->load->view('project_normalize_replace_mvs_specifics');
					// $this->load->view('header_'.$_SESSION['language']);
					// if($this->is_done_step('replace_mvs')){// Est ce que cette étape a déjà été lancée ?
					// 	$this->load->view('project_normalize_replace_mvs_report_'.$_SESSION['language'], $data);
					// }
					// else{
					// 	$this->load->view('project_normalize_replace_mvs_'.$_SESSION['language'], $data);
					// }
					// $this->load->view('footer_'.$_SESSION['language']);

		//  Récupération des métatdata
		$metadata = $this->private_functions->get_metadata_api("normalize", $project_id);
		$file_name = key($metadata["files"]);

		// Cette étape n'est plus nécessaire, on skipped
		$this->private_functions->skip_step_api("normalize", $project_id, $file_name, "infer_mvs");
		$this->private_functions->skip_step_api("normalize", $project_id, $file_name, "replace_mvs");

		// Etape suivante
		redirect('/Project/link/'.$_SESSION['link_project_id']);

	}// /replace_mvs()


	public function recode_types($project_id="")
	{
		if(isset($project_id)){
			$this->session->set_userdata('project_id', $project_id);
			$this->session->set_userdata('project_type', 'normalize');
		}

		$this->test_project_id();

		if($this->is_done_step('infer_types')){
			//  Récupération des métatdata
			$metadata = $this->private_functions->get_metadata_api("normalize", $project_id);
			$file_name = key($metadata["files"]);

			// Cette étape n'est plus nécessaire, on skipped
			$this->private_functions->skip_step_api("normalize", $project_id, $file_name, "recode_types");
			$this->private_functions->skip_step_api("normalize", $project_id, $file_name, "concat_with_init");

			// Etape suivante
			redirect('/Project/link/'.$_SESSION['link_project_id']);
		}

		// Chargement des vues
		$data['title'] = "Détection des types";
		$this->load->view('lib', $data);
		$this->load->view('project_normalize_infer_types_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_normalize_infer_types_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /recode_types()


	public function concat_with_init($project_id="")
	{

		if(isset($project_id)){
			$this->session->set_userdata('project_id', $project_id);
			$this->session->set_userdata('project_type', 'normalize');
		}
		$this->test_project_id();

		// // Chargement des vues
		// $data['title'] = "Normalisation";
		// $this->load->view('lib', $data);
		// $this->load->view('project_normalize_concat_with_init_specifics');
		// $this->load->view('header_'.$_SESSION['language']);
		// if($this->is_done_step('concat_with_init')){// Est ce que cette étape a déjà été lancée ?
		// 	$this->load->view('project_normalize_concat_with_init_report_'.$_SESSION['language'], $data);
		// }
		// else{
		// 	$this->load->view('project_normalize_concat_with_init_'.$_SESSION['language'], $data);
		// }
		// $this->load->view('footer_'.$_SESSION['language']);

		//  Récupération des métatdata
		$metadata = $this->private_functions->get_metadata_api("normalize", $project_id);
		$file_name = key($metadata["files"]);

		// Cette étape n'est plus nécessaire, on skipped
		$this->private_functions->skip_step_api("normalize", $project_id, $file_name, "concat_with_init");

		// Etape suivante
		redirect('/Project/link/'.$_SESSION['link_project_id']);
	}// /concat_with_init()


	// public function split_projects($user_id) // Répartition des projets selon leur type
	// {
	// 	$projects_list = $this->Projects_model->get_projects($user_id);
	//
	// 	foreach ($projects_list as $project) {
	// 		// Appel de l'API pour récupérer les infos de chaque projet
	// 		$project_api = $this->private_functions->get_metadata_api($project['project_type'], $project['project_id']);
	//
	//
	//
	//
	//
	// 		if(!$project_api){
	// 			$this->log_error('Projet non trouvé dans API :'.$project['project_id']);
	// 			continue;
	// 		}
	//
	// 		$project['project_id'] = $project_api["project_id"];
	// 		$project['display_name'] = $project_api['display_name'];
	// 		$project['description'] = $project_api['description'];
	// 		$project['public'] = (isset($project_api['public'])) ? $project_api['public'] : false;
	//
	// 		$project['steps_by_filename'] = $this->private_functions->set_tab_steps_by_filename($project_api['log']);
	//
	// 		switch ($project['project_type']) {
	// 			case 'normalize':
	// 				$project['has_mini'] = $project_api['has_mini'];
	// 				$project['file'] = key($project_api['files']);
	//
	// 				$this->normalized_projects[] = $project;
	//
	// 				break;
	// 			case 'link':
	// 				$this->linked_projects[] = $project;
	//
	// 				break;
	// 		}// /switch
	// 	}// /foreach
	// }// /split_projects()

	public function split_projects($user_id) // Répartition des projets selon leur type
	{
		$projects_list = $this->Projects_model->get_projects($user_id);

		foreach ($projects_list as $project) {
			// Appel de l'API pour récupérer les infos de chaque projet
			$project_api = $this->private_functions->get_metadata_api($project['project_type'], $project['project_id']);

			if($project_api == 404){
				continue;
			}

			if(!$project_api){
				$this->log_error('Projet non trouvé dans API :'.$project['project_id']);
				continue;
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
				$src_id = $project_api['files']['source']['project_id'];
				$ref_id = $project_api['files']['ref']['project_id'];

				// test des projets de normalisation - erreur 404 si non trouvé (suppression par exemple)
				$test_src = $this->private_functions->get_metadata_api('normalize', $src_id);
				$test_ref = $this->private_functions->get_metadata_api('normalize', $ref_id);

				if($test_src == 404){
					$project['file_src'] = 404;
				}
				else{
					$project['file_src'] = $project_api['files']['source']['file_name'];
				}

				if($test_ref == 404){
					$project['file_ref'] = 404;
				}
				else{
					$project['file_ref'] = $project_api['files']['ref']['file_name'];
				}

				$this->linked_projects[] = $project;
			}
		}// /foreach
	}// /split_projects()


	public function log_error($comment)
	{
		# Enregistrement des erreurs en base
		$data_to_write['comment'] = $comment;
		$data_to_write['user_id'] = "0";

		// Chargement du modèle
		$this->load->model('Comments_model');

		// Insertion
		//$this->Comments_model->insert_comment($data_to_write);
		$this->Comments_model->insert_log($data_to_write);
	}// /log_error()

}// /Class
