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
	}


	public function index()
	{
		$this->load->view('home');
	}


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
	}

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
	}

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
	}


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
	}


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
	}

	public function get_actual_step_linker($project_id='')
	{
		if($project_id == ''){
			return '';
		}

		// Récupération des métadata
		$project_api = $this->private_functions->get_metadata_api('link', $project_id);
		
		$file_name = $project_api['files']['source']['file_name'];
		$steps = $project_api['log'][$file_name];

	
		if($steps['add_selected_columns']['completed']){
			return 'add_selected_columns';
		}
		elseif($steps['es_train']['completed']){
			return 'es_train';
		}
		elseif($steps['upload_es_train']['completed']){
			return 'upload_es_train';
		}
		elseif($steps['es_linker']['completed']){
			return 'es_linker';
		}
		elseif($steps['link_results_analyzer']['completed']){
			return 'link_results_analyzer';
		}

		return 'INIT'; // Si project_id mais aucune étape de validée
	}


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
				$this->es_linker($project_id);
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
	}

	public function selected_columns($id='')
	{
		# Mise en relation des colonnes du fichier source avec celles du fichier referentiel

		$data['title'] = "Jointure";
		$this->load->view('lib', $data);
		$this->load->view('project_link_select_columns_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_select_columns_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}

	public function es_train($id='')
	{
		# Apprentissage dedupe
/*
voir /merge_machine/templates/dedupe_training.html
*/
		$data['title'] = "Jointure";
		$this->load->view('lib', $data);
		$this->load->view('project_link_es_train_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_es_train_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}

	public function es_linker($id='')
	{
		# Restriction du referentiel suite à apprentissage
/*
ne pas faire tout de suite - passer l'étape
*/

		$this->load->view('project_link_restrict_'.$_SESSION['language']);
		$this->load->view('footer_fr');
	}

	public function link_results_analyzer($id='')
	{
		# traitement final
/*
scheduler linker avec project_id
*/

		$this->load->view('project_link_results_'.$_SESSION['language']);
		$this->load->view('footer_fr');
	}




	public function test_project_id()
	{
		if(!isset($_SESSION['project_id'])){
			redirect('/Home');
		}
	}


	public function is_done_step($step_name)
	{
		$project_api = $this->private_functions->get_metadata_api($_SESSION['project_type'], $_SESSION['project_id']);
		$steps_by_filename = $this->private_functions->set_tab_steps_by_filename($project_api['log']);

		return $this->private_functions->is_completed_step($step_name, $steps_by_filename, $project_api['has_mini']);
	}

	
	public function load_link_step1_init()
	{
		# Chargement de la vue d'initialisation du projet

		// Recherche des projets de normalisation si user connecté
		$data = [];

		if(isset($_SESSION['user'])){
			$this-> split_projects($_SESSION['user']['id']);

			$data['normalized_projects'] = $this->normalized_projects;
			$data['linked_projects'] = $this->linked_projects;
		}

		// Chargement des vues
		$data['title'] = "Jointure";
		$this->load->view('lib', $data);
		$this->load->view('project_link_step1_init_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_link_step1_init_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}

	/*
	 Sauvegarde de l'initialisation du projet
	*/
	public function save_step1_init($project_id)
	{
		// MAJ du nom du projet en session
		// $this->session->set_userdata('project_name', $_POST['project_name']);
		// $this->session->set_userdata('project_description', $_POST['project_description']);

		// Sauvegarde bdd
		// TODO

		// Etape 2
		//redirect('/Project/load_step2_select_columns/'.$project_id);
		redirect('/Project/add_selected_columns/'.$project_id);
	}


	public function load_step1_init()
	{
		# Chargement de la vue d'initialisation du projet

		// Chargement des vues
		$data['title'] = "Normalisation";
		$this->load->view('lib', $data);
		$this->load->view('project_step1_init_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('project_step1_init_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}


	//public function load_step2_select_columns($id="")
	public function add_selected_columns($id="")
	{
		if(isset($id)){
			$this->session->set_userdata('project_id', $id);
			$this->session->set_userdata('project_type', 'normalize');
		}

		$this->test_project_id();

		// Est ce que cette étape a déjà été lancée ?
		if($this->is_done_step('add_selected_columns')){
			$this->load->view('project_step2_select_columns_report_fr');
		}
		else{
			$this->load->view('project_step2_select_columns_fr');
		}
		
		$this->load->view('footer_fr');
	}

	/*
	 Chargement de la vue de recherche des valeurs manquantes
	*/
	//public function load_step3_missing_values()
	public function replace_mvs($id="")
	{
		if(isset($id)){
			$this->session->set_userdata('project_id', $id);
			$this->session->set_userdata('project_type', 'normalize');
		}
		
		$this->test_project_id();
		
		// Est ce que cette étape a déjà été lancée ?
		if($this->is_done_step('replace_mvs')){
			$this->load->view('project_step3_missing_values_report_fr');
		}
		else{
			$this->load->view('project_step3_missing_values_fr');
		}

		$this->load->view('footer_fr');
	}

	/*
	 Chargement de la vue de recherche des types
	*/
	//public function load_step4_infer_types($id="")
	public function recode_types($id="")
	{
		if(isset($id)){
			$this->session->set_userdata('project_id', $id);
			$this->session->set_userdata('project_type', 'normalize');
		}

		$this->test_project_id();

		// Est ce que cette étape a déjà été lancée ?
		if($this->is_done_step('recode_types')){
			$this->load->view('project_step4_infer_types_report_fr');
		}
		else{
			$this->load->view('project_step4_infer_types_fr');
		}

		$this->load->view('footer_fr');
	}

	/*
	 Chargement de la vue finale
	*/
	public function concat_with_init($id="")
	{
		if(isset($id)){
			$this->session->set_userdata('project_id', $id);
			$this->session->set_userdata('project_type', 'normalize');
		}
		$this->test_project_id();

		// Est ce que cette étape a déjà été lancée ?
		if($this->is_done_step('concat_with_init')){
			$this->load->view('project_step5_concat_with_init_report_fr');
		}
		else{
			$this->load->view('project_step5_concat_with_init_fr');
		}

		$this->load->view('footer_fr');
	}


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
			}
		}
	}

}
