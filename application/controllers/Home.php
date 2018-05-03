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
		$data['title'] = "";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('home_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}


	public function error()
	{
		# Affiche la page d'erreur
		$data['title'] = "";
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


	public function faq()
	{
		# Affiche les conditions générales d'utilisation
		$data['title'] = "F.A.Q.";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('faq_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}


	public function referentials()
	{
		# Affiche la page des référentiels
		// Récupération des referentiels publics
		$this->load->library('Private_functions');
		$data['internal_projects'] = $this->private_functions->get_internal_projects();

		$data['title'] = "Liste des référentiels";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('referentials_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /referentials()


	public function contact()
	{
		# Affiche les conditions générales d'utilisation
		$data['title'] = "Contact & Lettre d'informations";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('contact');
		$this->load->view('footer_'.$_SESSION['language']);
	}

	public function about()
	{
		# Affiche les conditions générales d'utilisation
		$data['title'] = "A propos";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('about_'.$_SESSION['language']);
		$this->load->view('footer_'.$_SESSION['language']);
	}


	public function contact_send_email()
	{
		# Envoi d'un email à l'admin
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$message = trim($_POST['message']);

		$err = [];
		$data["err"] = false;

		if(!empty($name)){
			$name = $_POST['name'];
			$data["name"] = $name;
		}
		else{
			$err[] = "Vous devez renseigner votre nom";
		}
		if(!empty($email)){
			$email = $_POST['email'];
			$data["email"] = $email;
		}
		else{
			$err[] = "Vous devez renseigner votre email";
		}
		if(!empty($message)){
			$message = $_POST['message'];
			$data["message"] = $message;
		}
		else{
			$err[] = "Vous devez renseigner un message";
		}

		if(count($err) > 0){
			$data["err"] = true;
			$data["message_ret"] = "Tous les champs doivent être renseignés :";
			foreach ($err as $key => $value) {
				$data["message_ret"] = $data["message_ret"]."<br>".$value;
			}
		}
		else{
			$this->send_email_contact($name, $email, $message);
			$data["message_ret"] = "Votre email à été envoyé";
		}

		$data['title'] = "Envoyer un message";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('contact', $data);
		$this->load->view('footer_'.$_SESSION['language']);

	}// /contact_send_email()


	public function send_email_contact($name, $email, $message)
	{
		# envoi un email via le formulaire de contact

		// Chargement de la bibliothèque
		$this->load->library('email');

		$subject = '[Machine à données] - Formulaire de contact';

		// Get full html:
		$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
			<title>' . html_escape($subject) . '</title>
			<style type="text/css">
				body {
					font-family: Arial, Verdana, Helvetica, sans-serif;
					font-size: 16px;
				}
			</style>
		</head>
		<body>
		<div>
		<b>De : </b>' . $name . '
		</div>
		<div>
		<b>Email : </b>' . $email . '
		</div>
		<div>
		<b>Message :</b>
		</div>
		<div>
		<i>' . $message . '</i>
		</div>

		</body>
		</html>';

		$result = $this->email
			->from(EMAIL_FROM)
			->reply_to(EMAIL_REPLY_TO)
			->to(EMAIL_FROM)
			->subject($subject)
			->message($body)
			->send();
	}// /send_email_contact()


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


	public function undefined()
	{
		# Affiche la page 404 personnalisée
		$data['title'] = "";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('undefined_404');
		$this->load->view('footer_'.$_SESSION['language']);
	}


	public function password_lost()
	{
		# Affichage de la vue de perte du mot de passe
		$data['title'] = "Mot de passe perdu ?";
		$this->load->view('lib', $data);
		$this->load->view('password_lost_specifics');
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('password_lost');
		$this->load->view('footer_'.$_SESSION['language']);
	}



}
