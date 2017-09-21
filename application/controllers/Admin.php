<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public $normalized_projects = [];
	public $linked_projects = [];

	public function __construct()
	{
		parent::__construct();

		//$this->load->helper('captcha');
		$this->load->model('User_model');
		$this->load->model('Projects_model');

		$this->load->library('Private_functions');
	}


	public function index()
	{
		//$this->load->view('home_'.$_SESSION['language']);
		echo "Pas de visualisation";
	}


	public function deleteProjects()
	{
		# Suppression de tous les projets

		// Récupération de tous les projets (bdd)


		// Suppression de tous les projets 
			// Boucle
				// (API)


				// (bdd)

	}

	public function deleteUser($id_user)
	{
		# code...
	}







}