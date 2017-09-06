<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px">
	<div class="jumbotron">
	<h1>The Magical Laundry</h1> 
	<p>The Magical Laundry est une application web permettant de normaliser et de rapprocher génériquement des fichiers CSV</p> 
	</div>

	<div class="well">
		<h2>Créer un nouveau projet</h2>
		<div class="row">
			<div class="col-xs-6" style="padding-right: 10px;">
				<h3>Normalisation d'un fichier</h3>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Nullam cursus, lorem tincidunt cursus gravida, magna lacus egestas nulla, at aliquet nunc mi non est. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
				<button class="btn btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/normalize');?>';">Commencer un projet de normalisation</button>
			</div><!--/col-xs-6-->
			<div class="col-xs-6" style="padding-left: 10px;border-left: 1px solid #999;">
				<h3>Jointure de fichiers</h3>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Nullam cursus, lorem tincidunt cursus gravida, magna lacus egestas nulla, at aliquet nunc mi non est. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Nunc eleifend est ut erat cursus pellentesque. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
				<button class="btn btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/link');?>';">Commencer un projet de jointure</button>
			</div><!--/col-xs-6-->
		</div><!--/row-->
	</div><!--/well-->

	<?php
	if(!isset($_SESSION['user'])){
	?>
	<div class="well">
		<h2>Créer un compte</h2>
		
		<div class="row">
			<div class="col-xs-6">
				<h3>Pourquoi s'inscrire ?</h3>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>

				<a href='<?php echo base_url("index.php/User/login");?>' class="btn btn-success">Déjà inscrit</a>
			</div><!--/col-xs-6-->
			<div class="col-xs-6">
				<form>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Adresse email</label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Mot de passe</label>
				    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
				    <label for="exampleInputPassword1">Confirmation</label>
				    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
				  </div>
				  <div class="text-right">
				  	<button type="submit" class="btn btn-success">S'inscrire</button>
				  </div>
				</form>
			</div><!--/col-xs-6-->

		</div><!--/row-->
	</div><!--/well-->
	<?php
	}
	?>

</div><!--/container-->

</body>
</html>