<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px;">
	<div class="well">
		<h2>S'identifier</h2>
		<div class="row">
			<div class="col-xs-6">
				<h3>Pourquoi s'inscrire ?</h3>
				<p>
					En vous inscrivant, vous pourrez retrouver vos projets de normalisation et de jointure, les reprendre, et les réutiliser pour de nouvelles jointures.
				</p>
				<a href='<?php echo base_url("index.php/User/new");?>' class="btn btn-success">S'inscrire</a>
			</div><!--/col-xs-6-->
			<div class="col-xs-6">
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
			</div><!--/col-xs-6-->

		</div><!--/row-->
	</div><!--/well-->
</div><!--/container-->

<script type="text/javascript">
	$("body").css("height", $(window).height()) ;
</script>

</body>
</html>
