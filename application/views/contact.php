
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
	<div class="well text-justify">

		<div class="container">
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
					<div class="col-sm-8 col-sm-offset-2">
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
							}, 2000);
							</script>
						<?php
						}
						?>
							<?php
							echo @$message_ret;
							?>
						</div>
					</div>
					<div class="col-sm-2 text-right">
						<input id="submit" name="submit" type="submit" value="Envoyer message" class="btn btn-success">
					</div>
				</div>
			</form>
		</div><!-- /container -->
    </div><!-- /well -->
</div><!-- /container-fluid -->


<script type="text/javascript">
    $(function(){ // ready
        set_height('body');
    });// /ready
</script>
