<?php
	function get_status($public=0){
		if($public){
			return '<i class="fa fa-unlock" data-toggle="tooltip" data-placement="right" title="Fichier public"></i>';
		}
		else{
			return '<i class="fa fa-lock" data-toggle="tooltip" data-placement="right" title="Fichier privé"></i>';
		}
	}// /get_status()


	function is_completed_step($step_name, $project_steps, $has_mini){
		$filename = str_replace('MINI__', '', key($project_steps));

	    if(@$project_steps[$filename]['concat_with_init']==1){
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


	function is_completed_link_step($step_name, $project_steps){
		$filename = str_replace('MINI__', '', key($project_steps));

	    if(@$project_steps[$filename]['link_results_analyzer']==1){
	      	return true;
	    }

		switch ($step_name) {
			case 'INIT':
				return true;
				break;

			case 'add_selected_columns':
			case 'upload_es_train':
			case 'es_linker':
				return @$project_steps[$filename][$step_name];
				break;

			default :
				return false;
		}
	}// /is_completed_link_step()


	function get_progress_html($bs_color, $ratio, $step, $project_id){

		$html = '<div
					class="progress-bar progress-bar-'.$bs_color.' step '.$step.'"
					role="progressbar"
					aria-valuenow="25"
					aria-valuemin="0"
					aria-valuemax="100"
					data-toggle="tooltip"
					style="width: '.$ratio.'%;">
				</div>';
		//onclick="load_step(\''.$step.'\', \''.$project_id.'\');"

		return $html;
	}// /get_progress_html()


	function get_lien_html($step_todo, $project, $project_type){
		if(get_error_file($project['file_src'], $project['file_ref'])){
			return "";
		}

		if($step_todo){
			$html = '<button
						class="btn btn-xs btn-warning btn_tdb"
						onclick="load_step(\''.$step_todo.'\', \''.$project['project_id'].'\', \''.$project_type.'\');">
						Poursuivre
					</button>';
		}
		else{
			$html = '<button
						class="btn btn-xs btn-success3 btn_tdb"
						onclick="load_step(\'concat_with_init\', \''.$project['project_id'].'\', \''.$project_type.'\');">
						Rapport
					</button>';
		}
		return $html;
	} // /get_lien_html()


	function get_lien_dl_html($step_todo, $project_id, $file_name){
		$html = "";
		if(!$step_todo){
			$html = '<a onclick="dl_file(\''.$project_id.'\', \''.$file_name.'\');">
						<i class="fa fa-download"></i>
					 </a>';
		}

		return $html;
	} // /get_lien_dl_html()


	function get_lien_supp_html($project_type, $project_id){
		# Retour un lien html pour suppression du projet

		$html = '<a href="#"
					onclick="delete_project(\''.$project_type.'\', \''.$project_id.'\');">
					<span class="glyphicon glyphicon-trash"></span>
				</a>';
		return $html;
	}// /get_lien_supp_html()


	function trt_file_names($name){
		if($name == 404){
			return '<i style="color: red;" data-toggle="tooltip" data-placement="top" title="Fichier supprimé par l\'utilisateur ou erreur de traitement. Si votre projet est terminé, vous pouvez télécharger votre fichier final.">Fichier introuvable</i>';
		}

		if(strlen($name) > MAX_LIB_FILENAME){
			//return substr($name,0,MAX_LIB_FILENAME).'...';
			$name = substr($name,0,MAX_LIB_FILENAME).'...';
		}
		return '<span data-toggle="tooltip" data-placement="top" title="'.$name.'">'.$name.'</span>';
	}


	function get_error_file_html($file_src, $file_ref){
		$html = "";
		if(get_error_file($file_src, $file_ref)){
			$html = '<i class="fa fa-times" style="color: red;"></i>';
		}
		return $html;
	}// /get_error_file_html()


	function get_error_file($file_src, $file_ref){
		if($file_src == 404 || $file_ref == 404){
			return true;
		}
		return false;
	}// /get_error_file()
?>

<div>
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#link_tab" id="bt_tab_link" onclick="show_tabs('link');"><h4>Mes projets de jointure</h4></a></li>
	  <li><a data-toggle="tab" href="#normalize_tab" id="bt_tab_normalize" onclick="show_tabs('normalize');"><h4>Mes fichiers</h4></a></li>
	  <li><a data-toggle="tab" href="#account_tab" id="bt_tab_account"><h4>Mon compte</h4></a></li>
	</ul>
</div>

<div class="tab-content">
  <div id="link_tab" class="tab-pane fade in active">
  	<div class="container">
		<div class="row text-right">
			<div class="col-xs-12">
				<button
					class="btn btn-xs btn-success"
					style="margin-bottom: 8px;"
					onclick="window.location.href='<?php echo base_url('index.php/Project/link');?>';">
						+&nbsp;Nouveau projet de jointure
				</button>
			</div>
		</div><!--/row-->
		<div class="row">
			<div class="col-xs-12">
				<p class="well">
					Ci-dessous la liste de vos projets de jointure. Vous pouvez reprendre la où vous vous êtes arrêté sur chaque projet. Si un projet est terminé, vous pouvez afficher son rapport.
					L'îcone <span class="glyphicon glyphicon-trash"></span> vous permet de supprimer le projet.
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
							<th></th>
							<th>Projet</th>
							<th>Date de création</th>
							<th>Source</th>
							<th>Référentiel</th>
							<th>Avancement</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tab_steps = ['add_selected_columns', 'upload_es_train', 'es_linker'];
						$nb_steps = count($tab_steps);
						$ratio = 100/$nb_steps;

						foreach ($linked_projects as $project) {

							// Barre d'avancement
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

							if(!get_error_file($project['file_src'], $project['file_ref'])){
								$steps_html = "";
							}
							
							// Traitemnt des nom de fichiers
							$file_src_maximized = trt_file_names($project['file_src']);
							$file_ref_maximized = trt_file_names($project['file_ref']);

							$error_file = get_error_file_html($project['file_src'],$project['file_ref']);

							echo '<tr>';
							echo '<td>'.$error_file.'</td>';
							echo '<td><span data-toggle="tooltip" data-placement="top" title="'.$project['description'].'">'.$project['display_name'].'</span></td>';
							echo '<td>'.$project['created_tmp'].'</td>';
							echo '<td>'.$file_src_maximized.'</td>';
							echo '<td>'.$file_ref_maximized.'</td>';
							echo '<td class="text-center">'.$steps_html.'</td>';
							echo '<td class="text-center">'.get_lien_html($step_todo, $project,'link').'</td>';
							echo '<td class="text-center">'.get_lien_dl_html($step_todo, $project['project_id'],$project['file_src']).'</td>';
							echo '<td class="text-center">'.get_lien_supp_html('normalize', $project['project_id']).'</td>';
							echo '</tr>';
						} // /foreach $linked_projects
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
	</div><!-- /container -->
  </div><!-- /tab-pane -->

  <div id="normalize_tab" class="tab-pane fade">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php
				if(count($normalized_projects) > 0){
				?>
				<table class="table table-responsive table-condensed table-striped" id="normalized_projects">
					<thead>
						<tr>
							<th>Fichiers</th>
							<th>Date de création</th>
							<th class="text-center">Statut</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tab_steps = ['add_selected_columns', 'replace_mvs', 'recode_types', 'concat_with_init'];
						$nb_steps = count($tab_steps);
						$ratio = 100/$nb_steps;
						foreach ($normalized_projects as $project) {
							// Si upload incomplet, le projet n'a pas de "file", on ne prend pas en compte
							if(empty($project['file'])){
								continue;
							}
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

							if(strlen($project['file']) > MAX_LIB_FILENAME){
								$file_maximized = substr($project['file'],0,MAX_LIB_FILENAME).'...';
							}
							else {
								$file_maximized = $project['file'];
							}

							echo '<tr>';
							echo '<td><span data-toggle="tooltip" data-placement="top" title="'.$project['file'].'">'.$file_maximized.'</span></td>';
							echo '<td>'.$project['created_tmp'].'</td>';
							echo '<td class="text-center">'.get_status($project['public']).'</td>';
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
	</div><!-- /container -->
  </div><!-- /tab-pane -->

  <div id="account_tab" class="tab-pane fade">
  	<div class="container">
		<div class="row">
			<strong>Email : </strong><span class="email"><?php echo $_SESSION['user']['email'];?></span>
		</div>
  		<div class="row">
  			<div class="col-md-6 account_left">
  				<div>
  					<h3>Modifier mon mot de passe</h3>
					<form class="form-horizontal" name="password_change" id="password_change" method="post">
				  	  <div class="form-group">
					    <label for="password_old" class="col-sm-4 control-label">Mot de passe actuel</label>
					    <div class="col-sm-8">
					      <input type="password" class="form-control" id="password_old" placeholder="Password">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="password_new" class="col-sm-4 control-label">Nouveau mot de passe</label>
					    <div class="col-sm-8">
					      <input type="password" class="form-control" id="password_new" placeholder="Password">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="password_new2" class="col-sm-4 control-label">Confirmation</label>
					    <div class="col-sm-8">
					      <input type="password" class="form-control" id="password_new2" placeholder="Password">
					    </div>
					  </div>
					  <div class="form-group">
					    <div class="col-sm-12 text-right">
							<div class="alert alert-danger error_box" role="alert">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								<span id="error_msg"></span>
							</div>
							<button type="submit" class="btn btn-success2">
								<span class="glyphicon glyphicon-edit"></span>&nbsp;Modifier
							</button>
					    </div>
					  </div>
					</form>
  				</div>
  			</div><!--/col-md-6-->
  			<div class="col-md-6 account_right">
  				<div>
  					<h3>Supprimer mon compte</h3>
  					<div class="well">
  						La suppression de votre compte est définitive et entraine la suppression de toutes vos données.
  					</div>
  					<div style="width: 100%;" class="text-right">
  						<button class="btn btn-success" id="bt_delete_all">
  							<span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer mon compte
  						</button>
  					</div>
  				</div>

  			</div><!--/col-md-6-->
  		</div><!--/row-->
  	</div><!-- /container -->
  </div><!-- /tab-pane -->
</div>

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
		//window.location.href = <?php echo '"'.base_url('index.php/User/dashboard_delete_project/"');?> + project_type;
	}// /delete_project()


	function load_step(step, project_id, project_type){
		// if(project_type == 'normalize'){
		// 	window.location.href = <?php echo '"'.base_url('index.php/Project/"');?> + step + "/" + project_id;
		// }
		// else{// link
		// 	window.location.href = <?php echo '"'.base_url('index.php/Project/"');?> + project_type + "/" + project_id;
		// }

		window.location.href = <?php echo '"'.base_url('index.php/Project/"');?> + project_type + "/" + project_id;
	}// /load_step()


	function modify_password() {
		console.log('Modification of password');

		var password_old = $("#password_old");
		var password_new = $("#password_new");
		var password_new2 = $("#password_new2");
		var email = "<?php echo $_SESSION['user']['email'];?>";
		var ret = false;
		$("#error_msg").html("");

		// Le nouveau mot de passe ne doit pas être vide
		if(password_new.val() == ""){
			$("#error_msg").html("Le nouveau mot de passe ne peut pas être vide");
		}

		// Le mot de passe et la confirmation doivent etre identiques
		if(password_new.val() != password_new2.val()){
			$("#error_msg").html("Les mots de passe ne sont pas indentiques");
		}

		if($("#error_msg").html() != ""){
			$(".error_box").css("visibility", "visible");
			return false;
		}
		else{
			$(".error_box").css("visibility", "hidden");
		}


		// Modification en base
		$.ajax({
            type: 'post',
            url: '<?php echo base_url('index.php/Save_ajax/modify_password/');?>',
			data: 'email=' + email + '&password_old=' + password_old.val() + '&password_new=' + password_new.val(),
            async: false,
            success: function (result) {
            	console.log("Modification en base OK");
            	ret = result;

            	$(".error_box").removeClass("alert-danger");
            	$(".error_box").addClass("alert-info");

            	$("#error_msg").html("Mot de passe changé avec succès");
            	$(".error_box").css("visibility", "visible");


            	window.setTimeout(function(){
            		$(".error_box").fadeOut(100);

                	$(".error_box").removeClass("alert-info");
                	$(".error_box").addClass("alert-danger");
            	}, 2000);

            },
            error: function (result, status, error){
                console.log("Modification en base KO");
            }
        });

		// On vide les champs
		$("#password_old").val("");
		$("#password_new").val("");
		$("#password_new2").val("");

        return ret;
	}// /modify_password()


	function delete_all() {
		// Suppression de toutes les informations
		$.ajax({
            type: 'post',
            url: '<?php echo base_url('index.php/Save_ajax/delete_all');?>',
            data: 'user_id=' + <?php echo $_SESSION['user']['id'];?>,
            async: false,
            success: function (result) {
                console.log("Suppression en base OK");
                window.location.href = "<?php echo base_url('index.php/User/logout');?>";
            },
            error: function (result, status, error){
                console.log("Suppression en base KO");
                console.log(result);
            }
        });
	}// /delete_all()


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


	function show_tabs(tab) {
		// Sauvegarde en session de l'onglet en cours
		save_session_sync("dashboard_tab",tab);

		// Affichage de l'onglet
		$("#bt_tab_" + tab).tab("show");
	}// /show_tabs()


	function dl_file(project_id, file_name) {
		console.log("get_lien_dl_html");
		console.log(project_id);
		console.log(file_name);

        tparams = {
            "data_params": {
                "module_name": "es_linker",
                "file_name": file_name
            }
        }

        $.ajax({
            type: 'post',
            url: '<?php echo BASE_API_URL;?>' + '/api/download/link/' + project_id,
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(tparams),
            success: function (result_dl) {
                if(result_dl.error){
                    // show_api_error(result_dl, "API error - dl");
					console.log("API error - dl file");
                }
                else{
                    console.log("success - dl file");

                    // DL du fichier
                    var blob = new Blob([result_dl]);
                    var link = document.createElement('a');
                    document.body.appendChild(link);
                    link.href = window.URL.createObjectURL(blob);
                    link.download = file_name;
                    link.click();
                }
            },
            error: function (result_dl, status, error){
                show_api_error(result_dl, "error - dl file");
                err = true;
                clearInterval(handle);
            }
        });// /ajax
	}// /dl_file()

	$(function() { // ready
		$("#bt_delete_all").click(function(){
			if(confirm("Etes vous certains de vouloir supprimer votre compte ? \nTous vos projets seront également supprimés.")){
				delete_all();
			}
		});

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
							    "lengthMenu": [10],
							    "responsive": true,
								"order": [1, 'desc']
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
							    "lengthMenu": [10],
							    "responsive": true,
								"order": [2, 'desc']
							});

		//$("#linked_projects").order([3, 'asc']);
		<?php
		}
		?>

		$(".dataTables_info").css('display', 'none');
		$(".dataTables_length").css('display', 'none');

		// Action du formulaire de modification du mot de passe
		$("#password_change").submit(function(e){
			e.preventDefault();
			modify_password();
		});

		// Positionnement sur le bon onglet après suppression d'un project_type
		<?php
		$tab = 'link';
		if(isset($_SESSION['dashboard_tab'])){
			$tab = $_SESSION['dashboard_tab'];
		}
		echo '$("#bt_tab_'.$tab.'").tab("show");';
		?>


		// Tooltip des étapes
		$(".add_selected_columns").attr('title','Etape de sélection des colonnes à traiter.');
		$(".replace_mvs").attr('title','Etape de traitement des valeurs manquantes.');
		$(".recode_types").attr('title','Etape de traitement des types.');
		$(".concat_with_init").attr('title','Etape finale d\'enrichissement et de téléchargement du fichier normalisé.');

		$(".upload_es_train").attr('title','Labellisation - Apprentissage.');
		$(".es_linker").attr('title','Lancement du traitement final.');
		$(".link_results_analyzer").attr('title','Etape finale - Analyse');

		$('[data-toggle="tooltip"]').tooltip();

		// Hauteur de la page pour mettre le footer en bas
		var size = set_height('link_tab');
		set_height('normalize_tab', size);
		set_height('account_tab', size);
	}); // / ready
</script>
</body>
</html>
