<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid background_1" id="main">
	<div class="row" style="margin-top: 20px;">
		<div class="col-md-offset-3 col-md-6">
			<div class="well">
				Si vous possédez déjà un compte, veuillez saisir vos identifiants pour accéder à l'application.
				<BR>
				Sinon, veuillez vous inscrire ici <a href='<?php echo base_url("index.php/User/new");?>' class="btn btn-xs btn-success">S'inscrire</a>
			</div><!-- /well -->

			<form
				class="form-horizontal"
				name="my_form"
				method="post"
				action="<?php echo base_url("index.php/User/login_validation");?>"
				style="margin-top: 20px;">

				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Adresse email</label>
					<div class="col-sm-9">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email">
					</div>
				</div>

				<div class="form-group">
					<label for="pwd" class="col-sm-3 control-label">Mot de passe</label>
					<div class="col-sm-9">
			    		<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-offset-3 col-sm-4 text-left">
						<div
							class="alert alert-danger error_box"
							role="alert"
							style="display: inline; padding-bottom: 9px; padding-top: 7px;	margin-right: 20px;">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span id="error_msg">
								<?php
								if($msg){
									echo $msg;
								}
								?>
							</span>
						</div>
					</div>
					<div class="col-sm-5 text-right">
						<input type="hidden" name="next" value="<?php if(isset($next)){echo $next;}?>">
						<a href="<?php echo base_url("index.php/Home/password_lost");?>">
							Mot de passe perdu ?
						</a>
						<button type="submit" class="btn btn-success">S'identifier</button>
					</div>
				</div>

			</form>

		</div>
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
