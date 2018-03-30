<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Save_ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Projects_model');
		$this->load->model('Comments_model');
		$this->load->model('User_model');

		$this->load->library('Private_functions');
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


	public function unsession()
	{
		# Suppression d'une variable de session
		if(isset($_POST['name'])){
			$this->session->unset_userdata($_POST['name']);
		}

		if(isset($_POST['name'])){
			return false;
		}
		else{
			return true;
		}
	}// / unsession()


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
	}// /delete_project()


	public function delete_all()
	{
		# Suppression de toutes les infos de l'utilisateur

		// Récupération des projets
		$projects = $this->Projects_model->get_projects($_POST["user_id"]);

		// Suppression des projets API
		foreach ($projects as $project) {
			$response = $this->private_functions->delete_project_API($project['project_type'], $project['project_id']);
		}

		// // Suppression des projets en base
		$this->Projects_model->delete_projects($_POST["user_id"]);

		// // Suppression de l'utilisateur en base
		$this->User_model->delete_user($_POST["user_id"]);

		// // Redirection vers accueil
		return true;
	}// /delete_all()


	public function comment()
	{
		# Insertion du commentaire
		$name = "name";
		$email = "email";
		$message = "message";
		$url = "url";
		$project_id = "id";
		$project_type = "type";

		if(isset($_POST['name'])){
			$name = $_POST['name'];
		}
		if(isset($_POST['email'])){
			$email = $_POST['email'];
		}
		if(isset($_POST['message'])){
			$message = $_POST['message'];
		}
		if(isset($_POST['url'])){
			$url = $_POST['url'];
		}
		if(isset($_POST['project_id'])){
			$project_id = $_POST['project_id'];
		}
		if(isset($_POST['project_type'])){
			$project_type = $_POST['project_type'];
		}
		// Ajout en bdd
		$ret =  $this->Comments_model->insert_comment(
										$name,
										$email,
										$message,
										$url,
										$project_id,
										$project_type);
	}// /comment()


	public function modify_password()
	{
		# Modification du mot de passe utilsateur
		if(isset($_POST['email'])){
			$email = $_POST['email'];
		}
		if(isset($_POST['password_old'])){
			$password_old = $_POST['password_old'];
		}
		if(isset($_POST['password_new'])){
			$password_new = $_POST['password_new'];
		}

		// L'ancien mot de passe est il ok ?
		$pwd_ok =  $this->User_model->pwd_ok($email, $password_old);

		if($pwd_ok){
			$ret =  $this->User_model->update_pwd($email, $password_new);
		}

		return $ret;
	}// /modify_password()


	public function get_new_password($length=12)
	{
	    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $string = '';
	    for($i=0; $i<$length; $i++){
	        $string .= $chars[rand(0, strlen($chars)-1)];
	    }
	    return $string;
	}// /get_new_password


	public function send_password()
	{
		# Envoi du nouveau mot de passe par Email

		// Chargement de la bibliothèque
		$this->load->library('email');


		// Test de l'email
		$user =  $this->User_model->exist_user($_POST['email']);

		if($user){
			// Génération du nouveau mot de passe
			$password_new = $this->get_new_password();

			// Moification du mot de passe dans la base de données
			$pwd_is_set =  $this->User_model->update_pwd($_POST['email'], $password_new);
		}
		else{
			// KO
			// Affichage de la vue si email inconnu
			echo ("email_ko");
			exit;
		}

		// Envoi du mot de passe par email
		$subject = '[Machine à données] - Initialisation du mot de passe';
		$message = "Voici votre nouveau mot de passe : ".$password_new;

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
		<div>
		<a href="http://127.0.0.1/projets/magical_ui/index.php/User/new">Se connecter</a>
		</div>
		</body>
		</html>';

		$result = $this->email
		    ->from('scanr@recherche.gouv.fr')
		    ->reply_to('scanr@recherche.gouv.fr')
		    ->to($_POST['email'])
		    ->subject($subject)
		    ->message($body)
		    ->send();

		echo "ok";
}// /send_password()

}
