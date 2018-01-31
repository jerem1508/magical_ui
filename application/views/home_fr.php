
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">
<style type="text/css">
	.intro .title{
		color: #25368c;
		color: #DF1A25;
		font-size: 1.1em;
		font-weight: bold;
		text-transform: uppercase;
	}
	.intro{
		background-color: rgba(255,255,255,0);
	}
	.intro H1{
		padding: 50px;
		background-color: rgba(0,0,0,0.7);
		color: #fff;
		margin-top:20px;
		margin-bottom:30px;
		border-radius: 5px;
	}
</style>
<!-- /Intro -->
<div class="container-fluid intro" id="intro">
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<h1>
				Application web permettant le
				<span class="title">rapprochement</span>
				<br>
				générique de fichiers
				<span>CSV</span>
				<!--<img src="<?php echo base_url('assets/img/csv.png');?>" style="width:100px;">-->

				<div class="row">
					<div class="col-md-12 text-center">
						<br>
						<button class="btn btn-lg btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/link');?>';">
						<?php
						if(!isset($_SESSION['user'])){
							echo "S'enregistrer & ";
						}
						?>
						Commencer un projet</button>
					</div>
				</div>

			</h1>
		</div>
		<div class="col-md-1"></div>
	</div>
</div><!-- /Intro -->

<div class="row referentials" style="background-color: #fff; padding-top: 20px; padding-bottom: 20px; color: #333">
	<div class="col-md-12 text-center">
		<h2 style="font-size: 2.7em;">Référentiels disponibles</h2>
		<h4>Afin de faciliter vos mises en correspondance, un ensemble de référentiels est disponible et mis à jour régulièrement</h4>
		<a class="btn btn-xs btn-success2" href="<?php echo base_url("index.php/Home/referentials");?>" target="_blank">En savoir plus</a>
		<br><br>
		<div class="col-md-3">
			<img src="<?php echo base_url('assets/img/rnsr.png');?>" class="" style="width:200px;">
		</div>
		<div class="col-md-3">
			<img src="<?php echo base_url('assets/img/sirene.png');?>" class="" style="width:200px;">
		</div>
		<div class="col-md-3">
			<img src="<?php echo base_url('assets/img/grid.png');?>" class="" style="width:200px;">
		</div>
	</div>
</div>

<div class="row git" style="background-color: #121212; padding-top: 20px; padding-bottom: 20px; color: #fff">
	<div class="col-md-12 text-center">
		<img src="<?php echo base_url('assets/img/github-ffffff.png');?>" class="" style="width:200px;">
		<br />
		<h2>Merge-Machine</h2>
		<div  class="text" style="width: 400px; margin-right: auto; margin-left: auto;font-size: 1.1em;">
			Le projet se trouve sur <a href="https://github.com/entrepreneur-interet-general/the-magical-csv-merge-machine" target="_blank" style="color:#aaa;font-weight:bold;">Github</a> sous licence MIT.
			<br>
			Vous pouvez l'utiliser et/ou participer à son amélioration.
		</div>
	</div>
</div>


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


<script type="text/javascript">
	$(function(){// ready
		//set_height('intro');
	});// /ready
</script>
</body>
</html>
