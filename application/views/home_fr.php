
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

<div class="container-fluid" style="background-color: #262626;color: #eee;padding-bottom: 25px;border-bottom: 4px dotted #333;">
	<div class="row">
		<div class="col-md-offset-2 col-md-3">
			<h3>Normalisation d'un fichier</h3>
			<p class="text-justify">
				La normalisation prend un unique fichier tabulaire (csv, excel) et le nettoie automatiquement en fonction des types de données rencontrées.
			</p>
			<button class="btn btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/normalize');?>';">
<?php
if(!isset($_SESSION['user'])){
	echo "S'enregistrer & ";
}
?>


			Commencer un projet de normalisation</button>
		</div>
		<div class="col-md-offset-2 col-md-3">
			<h3>Jointure magique de deux fichiers</h3>
			<p class="text-justify">
				La jointure magique permet d'apparier automatiquement les fichiers sales (fautes d'ortographe, données sur ou sous renseignées) avec un fichier de référence propre. <a onclick="$('#myModal').modal('show');" style="color: #DF1A25;cursor: pointer">Plus...</a>
			</p>
			<button class="btn btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/link');?>';">
<?php
if(!isset($_SESSION['user'])){
	echo "S'enregistrer & ";
}
?>
			Commencer un projet de jointure</button>
		</div>
	</div>
</div><!-- /Types de projets possibles -->


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
