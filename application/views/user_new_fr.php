<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Enregistrement</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css');?>">

	<script type="text/javascript" src="<?php echo base_url('assets/jquery-3.2.1.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js');?>"></script>
</head>
<body>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container">


	<div class="row">
		<div class="col-xs-2" style="margin-top: 20px;">
			<img src="<?php echo base_url('assets/img/logo-RF-3@2x.png');?>" class="img-responsive">
		</div>
		<div class="col-xs-8 text-center">
			<h1>Magical_ui</h1>
		</div>
		<div class="col-xs-2 text-right" style="margin-top: 20px;">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="font-size: 22px; color: #000;">
                    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("index.php/Home");?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Accueil</a></li>
                    <li role="separator" class="divider"></li>
                    <?php
                    if(isset($_SESSION['user'])){
                        echo "<li><a href='".base_url("index.php/User/dashboard")."'><span class='glyphicon glyphicon-th' aria-hidden='true'></span>&nbsp;&nbsp;Tableau de bord</a></li>";
                        echo "<li><a href='".base_url("index.php/User/logout")."'><span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp;&nbsp;Déconnexion</a></li>";
                    }
                    else{
                        echo "<li><a href='".base_url("index.php/User/login/normalize")."'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span>&nbsp;&nbsp;S'identifier</a></li>";
                    }
                    ?>
                    <li role="separator" class="divider"></li>
                    <li><a href="#"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>&nbsp;&nbsp;English</a></li>
                </ul>
            </div><!-- /dropdown-->
		</div>
	</div>

	<hr>

	<div class="well">
		<h2>Créer un compte</h2>
		
		<div class="row">
			<div class="col-xs-6">
				<h3>Pourquoi s'inscrire</h3>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
				<a href='<?php echo base_url("index.php/User/login");?>' class="btn btn-success">Déjà inscrit</a>
			</div><!--/col-xs-6-->
			<div class="col-xs-6">
				<?php 
				if($msg){
					echo "<div class='alert alert-danger'>".$msg."</div>";
				}
				?>
				<form name="my_form" method="post" action="<?php echo base_url("index.php/User/new_save");?>">
				  <div class="form-group">
				    <label for="email">Adresse email</label>
				    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
				  </div>
				  <div class="form-group">
				    <label for="pwd">Mot de passe</label>
				    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe">
				    <label for="pwd_àconf">Confirmation</label>
				    <input type="password" class="form-control" id="pwd_conf" placeholder="Mot de passe">
				  </div>
				  <div class="text-right">
				  	<button type="submit" class="btn btn-success">S'inscrire</button>
				  </div>
				</form>
			</div><!--/col-xs-6-->

		</div><!--/row-->
	</div><!--/well-->
	

</div><!--/container-->

</body>
</html>