<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid background_1" id="main">
	<div class="container">
  		<div class="row">
  			<div class="col-md-6 part_left">
				<h3>Création d'un projet</h3>
				<div class="well">
                    Vous pouvez commencer un nouveau projet de jointure.
				</div><!-- /well -->
                <div class="text-center">
                    <a  href="<?php echo base_url('index.php/Project/link');?>"
						class="btn btn-lg btn-success bt_width">Nouveau projet</a>
                </div>
  			</div><!--/col-md-6-->
  			<div class="col-md-6 part_right">
				<div class="row">
					<div class="col-md-8">
						<h3>Tableau de bord - Synthèse</h3>
					</div>
					<div class="col-md-4 text-right">
						<a class="account" id="bt_tdb_account">Mon compte</a>
					</div>
				</div>
				<div class="well">
					Accéder à vos projets, fichiers et information de compte en cliquant sur le bouton correspondant
				</div><!-- /well -->
                <div class="row text-center">
					<span class="btn btn-default btn-xl btn_2_3" id="bt_tdb_link">
						<h2><?php echo @$nb_projects;?></h2>
						<h4>Projets</h4>
						<i>créés</i>
					</span>
					<span class="btn btn-default btn-xl btn_2_3" id="bt_tdb_normalize" style="margin-left: 100px;">
						<h2><?php echo @$nb_files;?></h2>
						<h4>Fichiers</h4>
						<i>en ligne</i>
					</span>
                </div>
  			</div><!--/col-md-6-->
  		</div><!--/row-->
	</div>


</div><!--/container-->

<script type="text/javascript">

	function save_session_sync(name, value) {
		$.ajax({
			type: 'post',
			url: '<?php echo base_url('index.php/Save_ajax/session');?>',
			data: 'name=' + name + '&val=' + value,
			async: false,
			success: function (result) {
				console.log(result);

				if(!result){
					console.log("sauvegarde en session KO");
					return false;
				}
				else{
					console.log("sauvegarde en session OK");
					return true;
				}
			},
			error: function (result, status, error){
				console.log(result);
				console.log(status);
				console.log(error);
				return false;
			}
		});
	}// /save_session_sync()


	function show_next(tab) {
		// Sauvegarde en session de l'onglet en cours
		save_session_sync("dashboard_tab",tab);

		// Affichage de la page suivante sur le bon onglet
		window.location.href='<?php echo base_url('index.php/User/dashboard');?>';
	}// /show_next()


	function add_buttons() {
		 $("#bt_tdb_link").click(function(){
			 show_next("link");
		 });
		 $("#bt_tdb_normalize").click(function(){
			 show_next("normalize");
		 });
		 $("#bt_tdb_account").click(function(){
			 show_next("account");
		 });

	}// /add_buttons()


	$(function() { // ready
		// Hauteur de la page pour mettre le footer en bas
		var size = set_height('main');

		// Ajout des actions des boutons
		add_buttons();

	}); // /ready
</script>

</body>
</html>
