<?php

//print_r($_SESSION);

?>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tableau de bord</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery.dataTables.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css');?>">

	<script type="text/javascript" src="<?php echo base_url('assets/jquery-3.2.1.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

	<style type="text/css">
		.progress-bar {
		    border-right: solid 1px #FFF;
		}
		.progress-bar:last-child {
		    border: none; 
		}
		.step{
			cursor: pointer;
		}
		.btn_tdb{
			width: 100px;
		}
	</style>
</head>
<body>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container">


	<div class="row">
		<div class="col-xs-2" style="margin-top: 20px;">
			<img src="<?php echo base_url('assets/img/logo-RF-3@2x.png');?>" class="img-responsive">
		</div>
		<div class="col-xs-8 text-center">
			<h1>Magical_ui</h1>
		</div>
		<div class="col-xs-2 text-right" style="margin-top: 20px;">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="font-size: 22px; color: #000;">
                    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("index.php/Home");?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Accueil</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href='".base_url("index.php/User/logout")."'><span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp;&nbsp;Déconnexion</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>&nbsp;&nbsp;English</a></li>
                </ul>
            </div><!-- /dropdown-->
		</div>
	</div>

	<hr>

	<div class="well">
		<div class="row">
			<div class="col-xs-12">
				<h2 style="display: inline;">Tableau de bord</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<h3 style="display: inline;">Mes projets de normalisation</h3>
				<button class="btn btn-xs btn-success" style="margin-bottom: 8px;" onclick="window.location.href='<?php echo base_url('index.php/Project/normalize');?>';">+&nbsp;Nouveau</button>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<?php
				if(count($normalized_projects) > 0){
				?>
				<table class="table table-responsive table-condensed table-striped" id="normalized_projects">
					<thead>
						<tr>
							<th>Projet</th>
							<th>Date de création</th>
							<th>Statut</th>
							<th>Fichier</th>
							<th>Avancement</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php

						function get_status($status=0)
						{
							switch ($status) {
								case PROJECT_INACTIVE:
									return 'Inactif';
								case PROJECT_USER_PRIVATE:
									return 'Privé';
								case PROJECT_USER_PUBLIC:
									return 'Public demandé';
								case PROJECT_ADMIN_PUBLIC_KO:
									return 'En cours';
								case PROJECT_ADMIN_PUBLIC_OK:
									return 'Public';
							}
						}

						function is_completed_step($step_name, $project_steps, $has_mini)
						{
							$filename = str_replace('MINI__', '', key($project_steps));

						    if($project_steps[$filename]['concat_with_init']==1){
						      	return true;
						    }

							switch ($step_name) {
								case 'INIT':
									return true;
									break;

								case 'add_selected_columns':
								case 'replace_mvs':
								case 'recode_types':
									if($has_mini){
										return $project_steps['MINI__'.$filename][$step_name];
									}
									else{
										return $project_steps[$filename][$step_name];
									}

									break;
								default :
									return false;
							}
						}

						function get_progress_html($bs_color, $ratio, $step, $project_id)
						{

							$html = '<div 
										class="progress-bar progress-bar-'.$bs_color.' step '.$step.'" 
										role="progressbar" 
										aria-valuenow="25" 
										aria-valuemin="0" 
										aria-valuemax="100" 
										data-toggle="tooltip" 
										onclick="load_step(\''.$step.'\', \''.$project_id.'\');" 
										style="width: '.$ratio.'%;">
									</div>';

							return $html;
						}

						function get_lien_html($step_todo, $project_id)
						{

							if($step_todo){
								$lib_todo = "Poursuivre";
															 
								$html = '<button 
											class="btn btn-xs btn-warning btn_tdb" 
											onclick="load_step(\''.$step_todo.'\', \''.$project_id.'\');">
											Poursuivre
										</button>';
							}
							else{
								$html = '<button 
											class="btn btn-xs btn-success3 btn_tdb" 
											onclick="load_step(\'concat_with_init\', \''.$project_id.'\');">
											Rapport
										</button>';
							}

							return $html;
						} // /get_lien_html()
						
						$tab_steps = ['add_selected_columns', 'replace_mvs', 'recode_types', 'concat_with_init'];
						$nb_steps = count($tab_steps);
						$ratio = 100/$nb_steps;
						
						foreach ($normalized_projects as $project) {
							$steps_html = '<div class="progress">';
							$found_step_todo = false;
							$step_todo = "";
							foreach ($tab_steps as $step) {
								$bs_color = (is_completed_step($step, $project['steps_by_filename'], $project['has_mini']))?"success2":"warning";
								$steps_html.= get_progress_html($bs_color, $ratio, $step, $project['project_id']);

								if(!$found_step_todo){
									if(!is_completed_step($step, $project['steps_by_filename'], $project['has_mini'])){
										$step_todo = $step;
										$found_step_todo = true;
									}
								}
							}


							$steps_html.= '</div>';
						
							//$status = get_status($project['public_status']);

							echo '<tr>';
							echo '<td>'.$project['display_name'].'</td>';
							echo '<td>'.$project['created_tmp'].'</td>';
							echo '<td>'.get_status($project['public_status']).'</td>';
							echo '<td>'.$project['file'].'</td>';							
							echo '<td class="text-center">'.$steps_html.'</td>';
							echo '<td class="text-center">'.get_lien_html($step_todo, $project['project_id']).'</td>';
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
				<?php
				}
				else{
					echo "Pas encore de projets";
				}
				?>
			</div><!--/col-xs-6-->

		</div><!--/row-->

		<hr>

		<div class="row">
			<div class="col-xs-6">
				<h3 style="display: inline;">Mes projets de jointure</h3>
				<button class="btn btn-xs btn-success" style="margin-bottom: 8px;" onclick="window.location.href='<?php echo base_url('index.php/Project/link');?>';">+&nbsp;Nouveau</button>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
			</div><!--/col-xs-6-->
			<div class="col-xs-6">
				<?php
				if(count($linked_projects) > 0){
				?>
				<table class="table table-responsive table-condensed table-striped" id="linked_projects">
					<thead>
						<tr>
							<th>Projet</th>
							<th>Statut</th>
							<th>Avancement</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($linked_projects as $project) {
							echo '<tr>';
							echo '<td>'.$project['display_name'].'</td>';
							echo '<td>'.$project['public_status'].'</td>';
							echo '<td></td>';
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
				<?php
				}
				else{
					echo "Pas encore de projets";
				}
				?>
			</div><!--/col-xs-6-->

		</div><!--/row-->
	</div><!--/well-->
	
</div><!--/container-->


<script type="text/javascript">


	$(function() {


		<?php
		if(count($normalized_projects) > 0){
		?>
		$("#normalized_projects").DataTable({
							    "language": {
							       "paginate": {
								        "first":      "Premier",
								        "last":       "Dernier",
								        "next":       "Suivant",
								        "previous":   "Précédent"
									},
									"search":         "Rechercher:",
									"lengthMenu":     "Voir _MENU_ enregistrements par page"
							    },
							    "lengthMenu": [5],
							    "responsive": true
							});
		<?php
		}

		if(count($linked_projects) > 0){
		?>
		$("#linked_projects").DataTable({
							    "language": {
							       "paginate": {
								        "first":      "Premier",
								        "last":       "Dernier",
								        "next":       "Suivant",
								        "previous":   "Précédent"
									},
									"search":         "Rechercher:",
									"lengthMenu":     "Voir _MENU_ enregistrements par page"
							    },
							    "lengthMenu": [5],
							    "responsive": true
							});
		<?php
		}
		?>

		$(".dataTables_info").css('display', 'none');
		$(".dataTables_length").css('display', 'none');




		// Tooltip des étapes
		$(".add_selected_columns").attr('title','Etape de sélection des colonnes à traiter.');
		$(".replace_mvs").attr('title','Etape de traitement des valeurs manquantes.');
		$(".recode_types").attr('title','Etape de traitement des types.');
		$(".concat_with_init").attr('title','Etape finale d\'enrichissement et de téléchargement du fichier normalisé.');

		$('[data-toggle="tooltip"]').tooltip(); 




	}); // / ready

	function load_step(step, project_id)
	{
		window.location.href = <?php echo '"'.base_url('index.php/Project/"');?> + step + "/" + project_id;
	}


</script>

</body>
</html>