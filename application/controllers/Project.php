<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

	public $normalized_projects = [];
	public $linked_projects = [];

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Projects_model');

		$this->load->library('Private_functions');

		// test de la langue
		// Francais par defaut
		if(!isset($_SESSION['language'])){
			$this->session->set_userdata('language', 'fr');
		}
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
		}

		// Si normalisation, on efface l'éventuel lien vers un projet de link
		$this->session->unset_userdata('link_project_id');


		// REcherche de l'étape en cours si non passée dans l'URL
		if(!$step){
			$step = $this->get_actual_step_normalization($_SESSION['project_id']);
		}

		// Chargement de l'étape
		$this->load_step_normalization($step, $project_id);
	}// /normalize()


	public function get_actual_step_normalization($project_id='')
	{
		if($project_id==''){
			return 'INIT';
		}

		$project_api = $this->private_functions->get_metadata_api('normalize', $project_id);

		$file_name = key($project_api['files']);
		$steps = $project_api['log'][$file_name];

		if($steps['concat_with_init']['completed']){
			return 'concat_with_init';
		}
		elseif($steps['recode_types']['completed']){
			return 'recode_types';
		}
		elseif($steps['replace_mvs']['completed']){
			return 'replace_mvs';
		}
		elseif($steps['add_selected_columns']['completed']){
			return 'add_selected_columns';
		}

		return 'INIT';
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


	public function link($project_id='', $type_file='')
	{

		// MAJ du type de projet en session
		$this->session->set_userdata('project_type', 'link');

		if(isset($project_id)){
			$this->session->set_userdata('link_project_id', $project_id);
		}
		// REcherche de l'étape en cours
		$link_step = $this->get_actual_step_linker($project_id);

		if($project_id && $link_step == 'INIT'){
			// tests de complétude des projets de normalisation
			$normalized_projects = $this->get_normalization_projects($project_id);

			foreach ($normalized_projects as $normalized_project) {
				// Rechercher l'étape du projet
				$step = $this->get_actual_step_normalization($normalized_project['project_id']);

				// Sauvegarde du project_id afin de pouvoir revenir au projet de link apres la normalisation
				$this->session->set_userdata('link_project_id', $project_id);
				
				// si pas fini, redirection vers la normalisation
				if($step != 'concat_with_init'){
					//$this->load_step_normalization($step, $normalized_project['project_id']);
					$this->session->set_userdata('project_id', $normalized_project['project_id']);
					redirect('/Project/load_step_normalization/'.$step.'/'.$normalized_project['project_id']);
				}
			}
		}

		$this->load_step_linker($link_step, $project_id);
	}// /link()


	public function get_actual_step_linker($project_id='')
	{
		if($project_id == ''){
			return '';
		}

		// Récupération des métadata
		$project_api = $this->private_functions->get_metadata_api('link', $project_id);
		
		$file_name = $project_api['files']['source']['file_name'];
		$steps = $project_api['log'][$file_name];

	
		if($steps['link_results_analyzer']['completed']){
			return 'link_results_analyzer';
		}
		elseif($steps['es_linker']['completed']){
			return 'es_linker';
		}
		elseif($steps['upload_es_train']['completed']){
			return 'upload_es_train';
		}
		// elseif($steps['es_train']['completed']){
		// 	return 'es_train';
		// }
		elseif($steps['add_selected_columns']['completed']){
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
				$this->link_results_analyzer($project_id);
				break;

			case 'link_results_analyzer':
				$this->link_results_analyzer($project_id);
				break;
			
			default:
				$this->load_link_step1_init();
		}
	}// /load_step_linker()


	public function selected_columns($id='')
	{
		# Mise en relation des colonnes du fichier source avec celles du fichier referentiel

		$data['title'] = "Jointure";
		$this->load->view('lib', $data);
		$this->load->view('project_link_select_columns_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_select_columns_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /selected_columns()


	public function es_train($id='')
	{
		# Apprentissage

		$data['title'] = "Jointure";
		$this->load->view('lib', $data);
		$this->load->view('project_link_es_train_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_es_train_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /es_train()


	public function es_linker($id='')
	{
		# Traitement final

		$data['title'] = "Jointure";
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

		// Recherche des projets de normalisation si user connecté
		if(isset($_SESSION['user'])){
			$this-> split_projects($_SESSION['user']['id']);

			$data['normalized_projects'] = $this->normalized_projects;
			$data['linked_projects'] = $this->linked_projects;
		}

		// Recherche des projets internes proposés
		$data['internal_projects'] = $this->private_functions->get_internal_projects();

		// Chargement des vues
		$data['title'] = "Jointure";
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
		$data['title'] = "Normalisation";
		$this->load->view('lib', $data);
		$this->load->view('project_normalize_select_columns_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		// Est ce que cette étape a déjà été lancée ?
		if($this->is_done_step('add_selected_columns')){
			$this->load->view('project_normalize_select_columns_report_'.$_SESSION['language'], $data);
		}
		else{
			$this->load->view('project_normalize_select_columns_'.$_SESSION['language'], $data);
		}
		$this->load->view('footer_'.$_SESSION['language']);
	}// /add_selected_columns()


	public function replace_mvs($id="")
	{
		if(isset($id)){
			$this->session->set_userdata('project_id', $id);
			$this->session->set_userdata('project_type', 'normalize');
		}
		
		$this->test_project_id();
				
		// Chargement des vues
		$data['title'] = "Normalisation";
		$this->load->view('lib', $data);
		$this->load->view('project_normalize_replace_mvs_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		if($this->is_done_step('replace_mvs')){// Est ce que cette étape a déjà été lancée ?
			$this->load->view('project_normalize_replace_mvs_report_'.$_SESSION['language'], $data);
		}
		else{
			$this->load->view('project_normalize_replace_mvs_'.$_SESSION['language'], $data);
		}
		$this->load->view('footer_'.$_SESSION['language']);
	}// /replace_mvs()


	public function recode_types($id="")
	{
		if(isset($id)){
			$this->session->set_userdata('project_id', $id);
			$this->session->set_userdata('project_type', 'normalize');
		}

		$this->test_project_id();

		// Chargement des vues
		$data['title'] = "Normalisation";
		$this->load->view('lib', $data);
		$this->load->view('project_normalize_infer_types_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		if($this->is_done_step('infer_types')){// Est ce que cette étape a déjà été lancée ?
			$this->load->view('project_normalize_infer_types_report_'.$_SESSION['language'], $data);
		}
		else{
			$this->load->view('project_normalize_infer_types_'.$_SESSION['language'], $data);
		}
		$this->load->view('footer_'.$_SESSION['language']);
	}// /recode_types()


	public function concat_with_init($id="")
	{
		if(isset($id)){
			$this->session->set_userdata('project_id', $id);
			$this->session->set_userdata('project_type', 'normalize');
		}
		$this->test_project_id();


		// Chargement des vues
		$data['title'] = "Normalisation";
		$this->load->view('lib', $data);
		$this->load->view('project_normalize_concat_with_init_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		if($this->is_done_step('concat_with_init')){// Est ce que cette étape a déjà été lancée ?
			$this->load->view('project_normalize_concat_with_init_report_'.$_SESSION['language'], $data);
		}
		else{
			$this->load->view('project_normalize_concat_with_init_'.$_SESSION['language'], $data);
		}
		$this->load->view('footer_'.$_SESSION['language']);
	}// /concat_with_init()


	public function split_projects($user_id) // Répartition des projets selon leur type
	{
		$projects_list = $this->Projects_model->get_projects($user_id);

		foreach ($projects_list as $project) {
			// Appel de l'API pour récupérer les infos de chaque projet
			$project_api = $this->private_functions->get_metadata_api($project['project_type'], $project['project_id']);

			// $last_written = $this->last_written($project['project_type'], $project['project_id']);
			$project['project_id'] = $project_api["project_id"];
			$project['display_name'] = $project_api['display_name'];
			$project['description'] = $project_api['description'];
			$project['public'] = (isset($project_api['public'])) ? $project_api['public'] : false;

			$project['steps_by_filename'] = $this->private_functions->set_tab_steps_by_filename($project_api['log']);

			switch ($project['project_type']) {
				case 'normalize':
					$project['has_mini'] = $project_api['has_mini'];
					$project['file'] = key($project_api['files']);
					$this->normalized_projects[] = $project;
					
					break;
				case 'link':
					$this->linked_projects[] = $project;
					
					break;
			}// /switch
		}// /foreach
	}// /split_projects()

}// /Class