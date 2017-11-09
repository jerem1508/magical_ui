<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		// test de la langue
		// Francais par defaut
		if(!isset($_SESSION['language'])){
			$this->session->set_userdata('language', 'fr');
		}
	}

	public function index()
	{
		# Chargement par défaut
		$data['title'] = "Accueil";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('home_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}


	public function error()
	{
		# Affiche la page d'erreur
		$data['title'] = "Accueil";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('error_'.$_SESSION['language']);		
		$this->load->view('footer_'.$_SESSION['language']);
	}


	public function cgu()
	{
		# Affiche les conditions générales d'utilisation
		$data['title'] = "CGU";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('cgu');
		$this->load->view('footer_'.$_SESSION['language']);
	}


	public function fr()
	{
		# Passe l'interface en français

		$this->session->set_userdata('language', 'fr');
		redirect("/Home");
	}

	public function en()
	{
		# Passe l'interface en français

		$this->session->set_userdata('language', 'en');
		redirect("/Home");
	}
}