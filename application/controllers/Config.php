<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		// test de la langue
		// Francais par defaut
		if(!isset($_SESSION['language'])){
			$this->session->set_userdata('language', 'fr');
		}

		//$this->load->helper('captcha');
	}

	public function index()
	{
		$this->load->view('home_'.$_SESSION['language']);
	}

	public function change_language($lang='fr', $next='Home')
	{
		$this->session->set_userdata('language', $lang);

		// Redirection
		redirect('/'.$next);
	}
}