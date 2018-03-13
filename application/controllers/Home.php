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


	public function referentials()
	{
		# Affiche la page des référentiels
		// Récupération des referentiels publics
		$this->load->library('Private_functions');
		$data['internal_projects'] = $this->private_functions->get_internal_projects();

		$data['title'] = "Référentiels";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('referentials_'.$_SESSION['language'], $data);
		$this->load->view('footer_'.$_SESSION['language']);
	}// /referentials()


	public function contact()
	{
		# Affiche les conditions générales d'utilisation
		$data['title'] = "Envoyer un message";
		$this->load->view('lib', $data);
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('contact');
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
		$this->load->view('header_'.$_SESSION['language']);
		$this->load->view('password_lost');
		$this->load->view('footer_'.$_SESSION['language']);
	}


	public function send_password()
	{
		# Envoi du nouveau mot de passe par Email


		// Test de l'email

			// KO
			// Affichage de la vue si email inconnu


			// OK
			// Génération d'un nouveau mot de passe

			// Envoi du mot de passe par email



			$this->load->library('email');

			$subject = 'This is a test';
			$message = '<p>This message has been sent for testing purposes.</p>';

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
			' . $message . '
			</body>
			</html>';
			// Also, for getting full html you may use the following internal method:
			//$body = $this->email->full_html($subject, $message);

			$result = $this->email
			    ->from('scanr@recherche.gouv.fr')
			    ->reply_to('scanr@recherche.gouv.fr')
			    ->to('jeremy.peglion@gmail.com')
			    ->subject($subject)
			    ->message($body)
			    ->send();

			var_dump($result);
			echo '<br />';
			echo $this->email->print_debugger();

			exit;
/*
code pour envoyer des emails via PHPMailer :
$mail = new PHPMailer(true); // Passing true enables exceptions
try {
//Server settings
$mail->SMTPDebug = 2; // Enable verbose debug output
$mail->isSMTP(); // Set mailer to use SMTP
$mail->Host = 'email-smtp.eu-west-1.amazonaws.com'; // Specify main and backup SMTP servers
$mail->CharSet = 'UTF-8';
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'AKIAJAHUZE5J4VWHGL5Q'; // SMTP username
$mail->Password = 'AvqgTjAlyN40CO1ofOUMKl3aj0E/io6+Ipfd+/zf4m+k'; // SMTP password
$mail->SMTPSecure = 'ssl'; // Enable TLS encryption, ssl also accepted
$mail->Port = 465; // TCP port to connect to

            //Recipients
            $mail->setFrom('scanr@recherche.gouv.fr', 'scanR');
            $mail->addAddress('scanr@recherche.gouv.fr', 'scanR');     // Add a recipient
            $mail->addReplyTo('scanr@recherche.gouv.fr', 'scanR');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "$Subject";
            $mail->Body    = "$Body";
            $mail->AltBody = "$AltBody";
            if($imp==1)
            {
                $mail->Priority = 1;
                $mail->AddCustomHeader("X-MSMail-Priority: High");
                $mail->AddCustomHeader("Importance: High");
            }

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
*/

	}
}
