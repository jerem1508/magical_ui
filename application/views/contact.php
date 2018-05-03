
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<style type="text/css">
	h3{
		color: #777;
		/*text-transform: uppercase;*/
	}
	h3::first-letter{
		color: #E00612;
		font-size: 1.5em;
		font-weight: bold;
	}
</style>

<div class="container-fluid" id="body">
	<div class="text-justify" style="background-color: #fff;">
		<div class="container-fluid">
			<div class="row" style="padding-top: 20px;">
				<!-- Partie gauche : contact-->
				<div class="col-md-6" style="border-right: 4px dashed #eee;">
					<h2>Contactez-nous :</h2>
					<form class="form-horizontal" role="form" method="post" action="<?php echo base_url('index.php/Home/contact_send_email/');?>">
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Nom *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="name" name="name" placeholder="Nom & Prénom" value="<?php echo @$name;?>">
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Email *</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php echo @$email;?>">
							</div>
						</div>
						<div class="form-group">
							<label for="message" class="col-sm-2 control-label">Message *</label>
							<div class="col-sm-10">
								<textarea class="form-control" rows="4" name="message" id="message"><?php echo @$message;?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">
								<?php
								if(@$err){
								?>
									<div class="alert alert-danger"  style="padding: 6px;">
								<?php
								}
								else{
								?>
									<div class="alert alert-info"  style="padding: 6px;">
									<script type="text/javascript">
									window.setTimeout(function(){
										$(".alert-info").fadeOut("slow");
										// Supppression des données du formulaire
										$("#name").val("");
										$("#email").val("");
										$("#message").html("");
									}, 1000);
									</script>
								<?php
								}
								?>
									<?php
									echo @$message_ret;
									?>
								</div>
							</div>

							<div class="col-sm-12 text-center">
								<input id="submit" name="submit" type="submit" value="Envoyer message" class="btn btn-success">
							</div>
						</div>
					</form>
					<div>
						<i>
							Les données personnelles recueillies dans le cadre de la machine à données sont transmises et conservées selon des protocoles sécurisés ; elles ne sont pas conservées au-delà de la durée nécessaire pour vous répondre.
						</i>
					</div>
				</div>
				<!-- /Partie gauche -->

				<!-- Partie droite : lettre d'information-->
				<div class="col-md-6">
					<h2>S'incrire à la lettre d'informations :</h2>
					<iframe width="100%" height="200px%" src="https://my.sendinblue.com/users/subscribe/js_id/2x5o1/id/21" frameborder="0" scrolling="auto" allowfullscreen style="display: block;margin-left: auto;margin-right: auto;"></iframe>
					<div>
						<i>
						 Vous disposez d'un droit d'accès, de modification, de rectification et de suppression des données qui vous concernent (art. 34 de la loi "Informatique et Libertés" du 6 janvier 1978).
						 <br />
						 Vous pouvez, à tout moment demander que vos coordonnées soient supprimées, soit via l'url présente dans chaque lettre d'information, soit via le formulaire de contact ci-contre
						 </i>
					</div>
				</div>
				<!-- /Partie droite -->
			</div>






			<hr>



		</div><!-- /container -->
    </div><!-- /well -->
</div><!-- /container-fluid -->


<script type="text/javascript">
    $(function(){ // ready
        set_height('body');
    });// /ready
</script>
