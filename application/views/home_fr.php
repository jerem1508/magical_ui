
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">
<style type="text/css">
	.intro .title{
		color: #25368c;
		font-size: 1.1em;
		font-weight: bold;
		text-transform: uppercase;
	}
	.intro{
		background-color: rgba(255,255,255,0.5); 
	}
</style>
<!-- /Intro -->
<div class="container-fluid intro" style="color: #262626">
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<h1 style="padding-top: 100px;padding-bottom: 100px;">
				Application web permettant la 
				<br>
				<span class="title">normalisation</span> et le <span class="title">rapprochement</span>
				<br>
				générique de fichiers <span style="color: #DF1A25">CSV</span>
			</h1>
		</div>
		<div class="col-md-1"></div>
	</div>
</div><!-- /Intro -->

<!-- Types de projets possibles -->
<?php
if(isset($_SESSION['user'])){
?>
<div class="container-fluid" style="background-color: #262626;color: #eee;padding-bottom: 25px;border-bottom: 4px dotted #333;">
	<div class="row">
		<div class="col-md-offset-2 col-md-3">
			<h3>Normalisation d'un fichier</h3>
			<p class="text-justify">
				La normalisation prend un unique fichier tabulaire (csv, excel) et le nettoie automatiquement en fonction des types de données rencontrées.
			</p>
			<button class="btn btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/normalize');?>';">Commencer un projet de normalisation</button>
		</div>
		<div class="col-md-offset-2 col-md-3">
			<h3>Jointure magique de deux fichiers</h3>
			<p class="text-justify">
				La jointure magique permet d'apparier automatiquement les fichiers sales (fautes d'ortographe, données sur ou sous renseignées) avec un fichier de référence propre. <a onclick="$('#myModal').modal('show');" style="color: #DF1A25;cursor: pointer">Plus...</a>
			</p>
			<button class="btn btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/link');?>';">Commencer un projet de jointure</button>
		</div>
	</div>
</div><!-- /Types de projets possibles -->
<?php
}
//<!-- Compte -->
if(!isset($_SESSION['user'])){
?>
<div class="container-fluid" style="background-color: #fff;padding-bottom: 25px">
	<div class="row">
		<div class="col-xs-offset-2 col-xs-10">
			<h2>Créer un compte</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-offset-2 col-xs-3">
			<h3>Pourquoi s'inscrire ?</h3>
			<p>
				En vous inscrivant, vous pourrez stocker vos différents projets et fichiers et vous en reservir pour dans différents projets de jointure. Par ailleurs, vos données seront conservées plus longtemps que pour les utilisateurs non inscrits.

				L'inscription est totalement gratuite!
			</p>

			<!--<a href='<?php echo base_url("index.php/User/login");?>' class="btn btn-success">Déjà inscrit</a>-->
		</div><!--/col-xs-6-->
		<div class="col-xs-offset-1 col-xs-4">
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
</div><!-- / Compte -->
<?php
}
?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Jointure magique de deux fichiers</h4>
      </div>
      <div class="modal-body">
		La jointure magique permet d'apparier automatiquement les fichier sale (fautes d'ortographe, données sur ou sous renseignées) avec un fichier de référence propore. Notre methode va au delà de la jointure par clé ou d'un simple fuzzy match et utilise des faisceaux d'indices pour proposer des matchs pertinents. La jointure s'appuie en partie sur la Normalisation.
		<br>
		<br>
		Actuellement, ce service de jointure se limite à la jointure entre un fichier sale et un fichier de référence, ce dernier ne devant pas contenir de doublons.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
