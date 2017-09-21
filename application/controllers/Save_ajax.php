<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Save_ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Projects_model');
	}

	public function session()
	{
		$name = "";
		$value = "";

		if(isset($_POST['name'])){
			$name = $_POST['name'];
		}
		if(isset($_POST['val'])){
			$value = $_POST['val'];
		}

		// Sauvegarde si valeurs
		if($name != "" && $value != ""){
			$this->session->set_userdata($name, $value);

			echo true;
		}
		else{
			print_r($_POST);
			echo false;	
		}
	}// /session()


	public function project()
	{
		$project_id = "";
		$public_status = PROJECT_USER_PRIVATE;
		$err = false;

		if(isset($_POST['project_id'])){
			$project_id = $_POST['project_id'];
		}
		else{
			echo "\nNo id project";
			$err = true;
		}

		if(isset($_POST['project_type'])){
			$project_type = $_POST['project_type'];
		}
		else{
			$project_type = "unknown";
			$err = true;
		}

		if(isset($_POST['public_status'])){
			$public_status = $_POST['public_status'];
		}

		if(!isset($_SESSION['user'])){
			echo "\nNo identified user";
			$err = true;
		}

		if(!$err){
			// insertion du projet
			$ret =  $this->Projects_model->insert_project(	$project_id,
															$_SESSION['user']['id'], 
															$public_status, 
															$project_type);
		}
	}// /project()


	public function delete_project($project_id)
	{
		# Suppression d'un projet en base

		$ret =  $this->Projects_model->delete_project($project_id);
		echo $ret;
	}
}