<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid background_1" id="main">
	<div class="container" style="padding-top: 20px;">
  		<div class="row">
  			<div class="col-md-6 account_left">
				<h3>Création du compte</h3>
				<div class="well">
					La création de votre compte est obligatoire. Elle ne prend que quelques secondes et vous permettra de retrouver tous vos projets. 
					<br>
					<br>
					Vous pourrez à tout moment supprimer toutes vos informations.
				</div><!-- /well -->
				<?php 
				if($msg){
					echo "<div class='alert alert-danger'>".$msg."</div>";
				}
				?>
				<form name="my_form" method="post" action="<?php echo base_url("index.php/User/new_save");?>">
				  <div class="form-group">
				    <label for="email">Adresse email</label>
				    <input type="email" class="form-control" id="email" name="usr_email" placeholder="Email">
				  </div>
				  <div class="form-group">
				    <label for="pwd">Mot de passe</label>
				    <input type="password" class="form-control" id="pwd" name="usr_pwd" placeholder="Mot de passe">
				    <label for="pwd_conf">Confirmation</label>
				    <input type="password" class="form-control" id="pwd_conf" placeholder="Mot de passe">
				  </div>
				  <div class="text-right">
				  	<button type="submit" class="btn btn-success">S'inscrire</button>
				  </div>
				</form>
  			</div><!--/col-md-6-->
  			<div class="col-md-6 account_right">
				<h3>Déjà inscrit</h3>
				<div class="well">
					Si vous possédez déjà un compte, veuillez saisir vos identifiants pour accéder à l'application.
				</div><!-- /well -->
				<?php 
				if($msg){
					echo "<div class='alert alert-danger'>".$msg."</div>";
				}
				?>
				<form name="my_form" method="post" action="<?php echo base_url("index.php/User/login_validation");?>">
				  <div class="form-group">
				    <label for="email">Adresse email</label>
				    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
				  </div>
				  <div class="form-group">
				    <label for="pwd">Mot de passe</label>
				    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe">
				  </div>
				  <div class="text-right">
				  	<input type="hidden" name="next" value="<?php if(isset($next)){echo $next;}?>">
				  	<button type="submit" class="btn btn-success">S'identifier</button>
				  </div>
				</form>
  			</div><!--/col-md-6-->
  		</div><!--/row-->
	</div>


</div><!--/container-->

<script type="text/javascript">
	$(function() { // ready
		// Hauteur de la page pour mettre le footer en bas
		var size = set_height('main');
	}); // /ready
</script>

</body>
</html>