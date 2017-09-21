
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px">
	<div class="jumbotron" style="margin-bottom: 10px;">
		<h1>The Magical Laundry</h1> 
		<p>The Magical Laundry est une application web permettant de normaliser et de rapprocher génériquement des fichiers CSV</p>
		<div style="width: 100%" class="text-center">
			<a href="#" onclick="javascript:introJs().setOption('showBullets', false).start();" class="btn btn-success2">Didacticiel</a>
		</div>
	</div>

	<div class="well" style="margin-bottom: 10px;">
		<h2>Créer un nouveau projet</h2>
		<div class="row">
			<div class="col-xs-6" style="padding-right: 10px;" data-intro="Ici pour nettoyer un fichier" data-position='right'>
				<h3>Normalisation d'un fichier</h3>
				<p>
					La normalisation prend un unique fichier tabulaire (csv, excel) et le nettoie automatiquement en fonction des types de données rencontrées.
				</p>
				<button class="btn btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/normalize');?>';">Commencer un projet de normalisation</button>
			</div><!--/col-xs-6-->
			<div class="col-xs-6" style="padding-left: 10px;border-left: 1px solid #999;" data-intro="Pour apparier deux fichiers"  data-position='left'>
				<h3>Jointure magique de deux fichiers</h3>
				<p>
					La jointure magique permet d'apparier automatiquement les fichier sale (fautes d'ortographe, données sur ou sous renseignées) avec un fichier de référence propore. Notre methode va au delà de la jointure par clé ou d'un simple fuzzy match et utilise des faisceaux d'indices pour proposer des matchs pertinents. La jointure s'appuie en partie sur la Normalisation.
					
					Actuellement, ce service de jointure se limite à la jointure entre un fichier sale et un fichier de référence, ce dernier ne devant pas contenir de doublons.
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
					En vous inscrivant, vous pourrez stocker vos différents projets et fichiers et vous en reservir pour dans différents projets de jointure. Par ailleurs, vos données seront conservées plus longtemps que pour les utilisateurs non inscrits.

					L'inscription est totalement gratuite!
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
