<?php
function get_status($public=0)
{
	if($public){
		return '<i class="fa fa-unlock"></i>';
	}
	else{
		return '<i class="fa fa-lock"></i>';
	}
}// /get_status()


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
}// /is_completed_step()


function is_completed_link_step($step_name, $project_steps)
{
	$filename = str_replace('MINI__', '', key($project_steps));

    if($project_steps[$filename]['link_results_analyzer']==1){
      	return true;
    }

	switch ($step_name) {
		case 'INIT':
			return true;
			break;

		case 'add_selected_columns':
		case 'upload_es_train':
		case 'es_linker':
			return $project_steps[$filename][$step_name];

			break;
		default :
			return false;
	}
}// /is_completed_link_step()


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
}// /get_progress_html()


function get_lien_html($step_todo, $project_id, $project_type)
{

	if($step_todo){
		$lib_todo = "Poursuivre";
									 
		$html = '<button 
					class="btn btn-xs btn-warning btn_tdb" 
					onclick="load_step(\''.$step_todo.'\', \''.$project_id.'\', \''.$project_type.'\');">
					Poursuivre
				</button>';
	}
	else{
		$html = '<button 
					class="btn btn-xs btn-success3 btn_tdb" 
					onclick="load_step(\'concat_with_init\', \''.$project_id.'\', \''.$project_type.'\');">
					Rapport
				</button>';
	}


	return $html;
} // /get_lien_html()


function get_lien_supp_html($project_type, $project_id)
{
	# Retour un lien html pour suppression du projet

	$html = '<a href="#"
				onclick="delete_project(\''.$project_type.'\', \''.$project_id.'\');">
				<span class="glyphicon glyphicon-trash"></span>
			</a>';
	return $html;
}// /get_lien_supp_html()
?>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px;">
	<div class="well">
		<div class="row">
			<div class="col-xs-12">
				<h3 style="display: inline;">Mes projets de normalisation</h3>
				<button class="btn btn-xs btn-success" style="margin-bottom: 8px;" onclick="window.location.href='<?php echo base_url('index.php/Project/normalize');?>';">+&nbsp;Nouveau</button>
				<p>
					Ci-dessous la liste de vos projets de normalisation. Vous pouvez reprendre la où vous vous êtes arrêté sur chaque projet. Si un projet est terminé, vous pouvez afficher son rapport.
					L'îcone <span class="glyphicon glyphicon-trash"></span> vous permet de supprimer le projet.
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
							<th class="text-center">Statut</th>
							<th>Fichier</th>
							<th>Avancement</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
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
							}// /foreach tab_steps
							$steps_html.= '</div>';
						
							echo '<tr>';
							echo '<td>'.$project['display_name'].'</td>';
							echo '<td>'.$project['created_tmp'].'</td>';
							echo '<td class="text-center">'.get_status($project['public']).'</td>';
							echo '<td>'.$project['file'].'</td>';
							echo '<td class="text-center">'.$steps_html.'</td>';
							echo '<td class="text-center">'.get_lien_html($step_todo, $project['project_id'], 'normalize').'</td>';
							echo '<td class="text-center">'.get_lien_supp_html('normalize', $project['project_id']).'</td>';
							echo '</tr>';

						} // /foreach $normalized_projects
						?>
					</tbody>
				</table>
				<?php
				}
				else{
					echo "Pas encore de projets";
				}
				?>
			</div><!--/col-xs-12-->

		</div><!--/row-->
	</div>
</div>

<div class="container" style="margin-top: 20px;">
	<div class="well">
		<div class="row">
			<div class="col-xs-12">
				<h3 style="display: inline;">Mes projets de jointure</h3>
				<button class="btn btn-xs btn-success" style="margin-bottom: 8px;" onclick="window.location.href='<?php echo base_url('index.php/Project/link');?>';">+&nbsp;Nouveau</button>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
			</div><!--/col-xs-12-->
		</div>
		<div class="row">
			<div class="col-xs-12">
				<?php
				if(count($linked_projects) > 0){
				?>
				<table class="table table-responsive table-condensed table-striped" id="linked_projects">
					<thead>
						<tr>
							<th>Projet</th>
							<th>Date de création</th>
							<th>Source</th>
							<th>Référentiel</th>
							<th>Avancement</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tab_steps = ['add_selected_columns', 'upload_es_train', 'es_linker', 'link_results_analyzer'];
						$tab_steps = ['add_selected_columns', 'upload_es_train', 'es_linker'];
						$nb_steps = count($tab_steps);
						$ratio = 100/$nb_steps;
						foreach ($linked_projects as $project) {

							$steps_html = '<div class="progress">';
							
							$found_step_todo = false;
							$step_todo = "";
							foreach ($tab_steps as $step) {
								$bs_color = (is_completed_link_step($step, $project['steps_by_filename']))?"success2":"warning";
								$steps_html.= get_progress_html($bs_color, $ratio, $step, $project['project_id']);

								if(!$found_step_todo){
									if(!is_completed_link_step($step, $project['steps_by_filename'])){
										$step_todo = $step;
										$found_step_todo = true;
									}
								}
							}// /foreach tab_steps

							
							$steps_html.= '</div>';
						
							echo '<tr>';
							echo '<td>'.$project['display_name'].'</td>';
							echo '<td>'.$project['created_tmp'].'</td>';
							echo '<td>'.$project['file_src'].'</td>';
							echo '<td>'.$project['file_ref'].'</td>';
							echo '<td class="text-center">'.$steps_html.'</td>';
							echo '<td class="text-center">'.get_lien_html($step_todo, $project['project_id'],'link').'</td>';
							echo '<td class="text-center">'.get_lien_supp_html('normalize', $project['project_id']).'</td>';
							echo '</tr>';

						} // /foreach $normalized_projects
						?>
					</tbody>
				</table>
				<?php
				}
				else{
					echo "Pas encore de projets";
				}
				?>
			</div><!--/col-xs-12-->

		</div><!--/row-->
	</div><!--/well-->
	
</div><!--/container-->


<script type="text/javascript">

	function delete_project_API(project_type, project_id) {
	    // Suppression d'un projet

	    var ret = false;

	    $.ajax({
	        type: 'get',
	        async: false,
	        url: '<?php echo BASE_API_URL;?>' + '/api/delete/' + project_type + '/' + project_id,
	        success: function (result) {
	            if(result.error){
	                console.log("API error - delete");console.log(result.error);
	            }
	            else{
	                console.log("success - delete api");console.dir(result);
	                ret = result;
	            }
	        },
	        error: function (result, status, error){
	            console.log(result);
	            console.log(status);
	            console.log(error);
	        }
	    });// /ajax metadata

	    return ret;
	}// / delete_project_API()


	function delete_project_bdd(project_id) {
		// Suppression en base
		var ret = false;

		// Suppression en base
		$.ajax({    
            type: 'get',
            url: '<?php echo base_url('index.php/Save_ajax/delete_project/');?>' + project_id,
            async: false,
            success: function (result) {
                if(result){
                	console.log("Suppression en base OK");
                	ret = result;
                }
                else{
                	console.log("ret : " + result);
                }
            },
            error: function (result, status, error){
                console.log("Suppression en base KO");
            }
        });
        return ret;
	}// /delete_project_bdd()


	function delete_project(project_type, project_id) {
		// Suppression du projet en base
		var ret = delete_project_bdd(project_id);

		// Suppression su repertoire API
		if(ret){
			delete_project_API(project_type, project_id)			
		}

		// Refresh
		window.location.reload();

	}// /delete_project()


	$(function() { // ready
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

		$(".upload_es_train").attr('title','Labellisation - Apprentissage.');
		$(".es_linker").attr('title','Lancement du traitement final.');
		$(".link_results_analyzer").attr('title','Etape finale - Analyse');

		$('[data-toggle="tooltip"]').tooltip(); 




	}); // / ready

	function load_step(step, project_id, project_type)
	{
		if(project_type == 'normalize'){
			window.location.href = <?php echo '"'.base_url('index.php/Project/"');?> + step + "/" + project_id;
		}
		else{// link
			window.location.href = <?php echo '"'.base_url('index.php/Project/"');?> + project_type + "/" + project_id;
		}
	}


</script>

</body>
</html>