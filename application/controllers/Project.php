<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Projects_model');

		$this->load->library('Private_functions');
	}

	public function test_project_id()
	{
		if(!isset($_SESSION['project_id'])){
			redirect('/Home');
		}
	}


	public function index()
	{
		$this->load->view('home');
	}


	public function normalize()
	{
		// MAJ du type de projet en session
		$this->session->set_userdata('project_type', 'normalize');
		//echo $this->session->project_type;

		// Chargement de la vue d'initialisation du projet
		$this->load_step1_init();
	}
	

	public function link()
	{
		// MAJ du type de projet en session
		$this->session->set_userdata('project_type', 'link');
		//echo $this->session->project_type;

		// Chargement de la vue d'initialisation du projet
		$this->load_step1_init();
	}

	public function is_done_step($step_name)
	{
		$project_api = $this->private_functions->get_metadata_api($_SESSION['project_type'], $_SESSION['project_id']);
		
		$steps_by_filename = $this->private_functions->set_tab_steps_by_filename($project_api['log']);

		return $this->private_functions->is_completed_step($step_name, $steps_by_filename, $project_api['has_mini']);

	}


	/*
	 Chargement de la vue d'initialisation du projet
	*/
	public function load_step1_init()
	{

		$this->load->view('project_step1_init_fr');
		$this->load->view('footer_fr');
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



}
