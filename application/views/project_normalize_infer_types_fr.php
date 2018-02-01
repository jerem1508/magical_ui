<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid intro" style="padding-bottom: 20px;">
<!--
    <div class="text-center">
        <div class="breadcrumb flat">
            <a href="<?php echo base_url("index.php/Project/normalize");?>" class="done">Sélection du fichier</a>
            <a href="<?php echo base_url("index.php/Project/load_step2_select_columns");?>" class="done">Sélection des colonnes</a>
            <a href="<?php echo base_url("index.php/Project/load_step3_missing_values");?>" class="done">Valeurs manquantes</a>
            <a href="#" class="active">Détection des types</a>
            <a href="#" class="todo">Traitement & Téléchargement</a>
        </div>
    </div>
-->

		<div class="row" style="padding-top: 20px;">
			<div class="col-sm-8">
				<h2 class="page_title"><span id="project_name"></span> : <i>Détection des types</i></h2>
				<span class="cl_filename">
				<i class="fa fa-file-text" aria-hidden="true"></i>
				Traitement du fichier <span id="filename" class="file"></span>
			</span>
			</div>
			<div class="col-sm-4 text-right">
				<a id="bt_skip_infer" class="btn btn-xs btn-success2">Passer cette étape >></a>
			</div>
		</div>
		<div class="row" style="padding-bottom: 20px;">
			<div class="col-sm-6">
				<p class="page_explain">
					Dans cette étape, nous tentons de <strong>détecter automatiquement le type</strong> de valeurs contenu dans les colonnes du fichier pour ensuite proposer un recodage approprié.
				</p>
			</div>
			<div class="col-sm-6 text-right">
				<div id="didacticiel">
	            	<span class="btn btn-default btn-xl fileinput-button btn_2_3" onclick="javascript:introJs().setOption('showBullets', false).start();">
	                	<img src="<?php echo base_url('assets/img/laptop.svg');?>"><br>Aide
		            </span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<button class="btn btn-success" id="bt_infer_types">Lancer la détection des types</button>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 text-center" id="wait">
				<img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">
				<h3>Le traitement peut prendre quelques minutes, veuillez patienter ...</h3>
			</div>
		</div>
</div><!--/container-->

<div class="container-fluid">
		<div class="row background_1" id="result">
			<h3>Résultat de la détection</h3>
			<div class="col-xs-12">
				<div class="row">
					<div class="col-xs-12" id="columns" style="overflow-x:scroll"></div>
				</div>
				<div class="row" style="padding-top: 20px;">
					<div class="col-xs-12 text-right">
						<!--<button class="btn btn btn-success" id="bt_recode_types">Lancer le traitement de l'échantillon</button>-->
						<button class="btn btn btn-success" id="bt_skip">Suivant >></button>
					</div>
				</div>
			</div>
		</div>
</div><!--/container-->

<div class="container-fluid background_2">
    <div id="report">
        <h2>
        	<i class="fa fa-flag-checkered" aria-hidden="true"></i>
        	Rapport :
        </h2>
        <div class="row">
            <div class="col-md-3">
			    <div id="steps" style="color: #fff;">
			        <ul>
			            <li>
			                Lancement du traitement <span id="start_treatment_ok" class="glyphicon glyphicon-ok check_ok"></span>
			                <div id="treatment_process">.......</div>
			            </li>
			            <li>
			                Affichage du rapport <span id="show_report_ok" class="glyphicon glyphicon-ok check_ok"></span>
			            </li>
			        </ul>
			    </div>
            </div>
            <div class="col-md-9">
            	<h3 style="color: #fff;">Modifications effectuées</h3>
            	<div id="tab_reports" class="background_1"></div>
            	<!--
            	<a id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier</a>
            	-->
            </div>
        </div><!-- /row-->
	    <div class="row" style="padding-bottom: 20px;">
	        <div class="col-md-12 text-right">
	            <!--<button class="btn btn btn-success" id="bt_next" disabled>Suivant >></button>-->
	        </div>
	    </div><!-- /row-->
    </div><!-- /report-->
</div><!--/container-->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Sélection des types" id="modal_types_select">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" id="gridSystemModalLabel" style="display: inline;">Sélection d'un type pour la colonne <h3 style="display: inline;color: #FA5D58;" id="lib_column_modal"></h3></h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<form class="form-inline">
							<div class="form-group">
								<input type="text" class="form-control" id="in_search" placeholder="Recherche par mot clé">
							</div>
						</form>
						<div id="search_result">
							...
						</div>
					</div>
					<div class="col-md-4">
						<h3>Catégories</h3><!--&nbsp;<a id="bt_toggle_cat_in_modal">Déplier tout</a>-->
						<div id="cat_list_modal"></div>
					</div>
					<div class="col-md-4">
						<h3>Echantillon du fichier</h3>
						<div id="data_visualisation_modal"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" id="bt_delete_modal"></span>Supprimer le type sélectionné&nbsp;<span class="glyphicon glyphicon-trash"></button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
</div>

<?php
if(isset($this->session->project_type)){
	$project_type = $this->session->project_type;
}
?>

<script type="text/javascript">
	function get_metadata(project_type, project_id) {
	    // Récupere les métadata via API

	    var metadata = "";
	    var ret = false;

	    $.ajax({
	        type: 'get',
	        async: false,
	        url: '<?php echo BASE_API_URL;?>' + '/api/metadata/' + project_type + '/' + project_id,
	        success: function (result) {
	            if(result.error){
	                console.log("API error");console.log(result.error);
	            }
	            else{
	                console.log("success - metadata");console.dir(result);
	                ret = result.metadata;
	            }
	        },
	        error: function (result, status, error){
	            console.log(result);
	            console.log(status);
	            console.log(error);
	        }
	    });// /ajax metadata

	    return ret;
	}// / get_metadata


	function last_written() {
        var tparams = {
            "before_module": "replace_mvs"
        }

		$.ajax({
			type: 'post',
			dataType: "json",
			contentType: "application/json; charset=utf-8",
			url: '<?php echo BASE_API_URL;?>' + '/api/last_written/normalize/' + project_id,
			data: JSON.stringify(tparams),
			success: function (result) {

				if(result.error){
					console.log("API error - last_written");
					console.log(result.error);
				}
				else{
                    console.log("success - last_written");
                    console.dir(result);

                    module_name = result.module_name;
                    file_name = result.file_name;
                    $("#filename").html(file_name)
                }
            },
            error: function (result, status, error){
                console.log("error");
                console.log(result);
                err = true;
            }
        });// /ajax - last_written
	}// /last_written()


	function skip() {
		// Test du filename, on ne doit pas ecrire sur le MINI
		var file_name_temp = file_name;
		if(file_name.substr(0,6) === 'MINI__' ){
			file_name_temp = file_name.substr(6);
		}

		// Paramètres API
		tparams = {
			"data_params": {
		    	"module_name": "recode_types",
		    	"file_name": file_name_temp
		    },
		    "module_params": {
		    	"skip_value": true
		    }
		}
		$.ajax({
			type: 'post',
			dataType: "json",
			contentType: "application/json; charset=utf-8",
			url: '<?php echo BASE_API_URL;?>' + '/api/set_skip/normalize/' + project_id,
			data: JSON.stringify(tparams),
			success: function (result) {

				if(result.error){
					console.log("API error - set_skip");
					console.log(result.error);
				}
				else{
				    console.log("success - set_skip");
				    console.log(result);

				    // Chargement de la page suivante (rappel du controller)
				    location.reload();
				}
		    },
		    error: function (result, status, error){
		        console.log("error - set_skip");
		        console.log(result);
		        err = true;
		    }
		});// /ajax - set_skip
	}// /skip()


	function skip_infer() {
		// Test du filename, on ne doit pas ecrire sur le MINI
		var file_name_temp = file_name;
		if(file_name.substr(0,6) === 'MINI__' ){
			file_name_temp = file_name.substr(6);
		}

		// Paramètres API
		tparams = {
			"data_params": {
		    	"module_name": "infer_types",
		    	"file_name": file_name_temp
		    },
		    "module_params": {
		    	"skip_value": true
		    }
		}
		$.ajax({
			type: 'post',
			dataType: "json",
			contentType: "application/json; charset=utf-8",
			url: '<?php echo BASE_API_URL;?>' + '/api/set_skip/normalize/' + project_id,
			data: JSON.stringify(tparams),
			success: function (result) {

				if(result.error){
					console.log("API error - set_skip");
					console.log(result.error);
				}
				else{
				    console.log("success - set_skip");
				    console.log(result);

				    // Chargement de la page suivante (rappel du controller)
				    location.reload();
				}
		    },
		    error: function (result, status, error){
		        console.log("error - set_skip");
		        console.log(result);
		        err = true;
		    }
		});// /ajax - set_skip

		// skip bt_recode_types
		skip();
	}// /skip_infer()


	function treatment_infer_types(err) {
		var tparams = {
            "before_module": "recode_types"
        }

		$.ajax({
			type: 'post',
			dataType: "json",
			contentType: "application/json; charset=utf-8",
			url: '<?php echo BASE_API_URL;?>' + '/api/last_written/normalize/<?php echo $_SESSION['project_id'];?>',
			data: JSON.stringify(tparams),
			success: function (result) {

				if(result.error){
					console.log("API error - last_written");
					console.log(result.error);
				}
				else{
                    console.log("success - last_written");
                    console.dir(result);

                    module_name = result.module_name;
                    file_name = result.file_name;
					/*
						Appel du job infer_mvs
					*/
		            tparams = {
		            	"data_params": {
		                	"module_name": module_name,
		                	"file_name": file_name
		                },
		                "module_params": null
		            }
					console.log("appel infer_mvs");

					$.ajax({
						type: 'post',
						dataType: "json",
						contentType: "application/json; charset=utf-8",
						url: '<?php echo BASE_API_URL;?>' + '/api/schedule/infer_types/<?php echo $_SESSION['project_id'];?>/',
						data: JSON.stringify(tparams),
						success: function (result) {

							if(result.error){
								console.log("API error - infer_types");
								console.dir(result.error);
							}
							else{
							    console.log("success - infer_types");
							    console.dir(result);

							    // Appel
							    var handle = setInterval(function(){
									$.ajax({
										type: 'get',
										url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
										success: function (result) {
											if(result.completed){
						                		clearInterval(handle);
							                    console.log("success - job");
							                    console.dir(result);

							                    // Arret de l'animation recherche
							                    $("#wait").css("display","none");

							                    write_types(result.result);

							                    write_categories_types_modal(result.result.all_types);

							                    tags_modal(result.result.type_e);

							                    $("#didacticiel").css("visibility","visible");
											}
											else{
												console.log("success - job en cours");
							                }
							            },
							            error: function (result, status, error){
							                console.log("error");
							                console.log(result);
							                err = true;
							                clearInterval(handle);
							            }
							        });// /ajax - job
							    }, 1000);
							}
		                },
		                error: function (result, status, error){
		                    console.log("error");
		                    console.log(result);
		                    err = true;
		                }
		            });// /ajax - infer_mvs


                }
            },
            error: function (result, status, error){
                console.log("error");
                console.log(result);
                err = true;
            }
        });// /ajax - last_written
    }// /treatment_infer_types()


    function rch(lib, nb_car) {
    	console.log()
    	if(lib.length > nb_car && lib.split(" ").length > 0){
    		t_split_lib = lib.split(" ");

    		lib = t_split_lib[0] + '<br>';

    		for (var i = 1; i < t_split_lib.length; i++) {
    			lib += " " + t_split_lib[i];
    		}
    	}

    	return lib;
    }// /rch()


    function create_tab_html(tab) {
    	var html = '<table class="table table-striped table-responsive table-condensed" style="width:100%;">';

    	for (var i = 0; i < tab.length; i++) {
    		html += '<tr><td>' + tab[i] + '</td></tr>';
    	}

    	html += '</table>';

    	return html;
    }// /create_tab_html()


    function show_modal_types_select(id_td_bt_column) {
    	selected_column = id_td_bt_column;

    	// On renseigne la visualisation des données dans la modal en ffonction de la colonne cliquée
    	var column = id_td_bt_column.substring(6);
		$('#data_visualisation_modal').html(create_tab_html(tab_sample[column]));
		$("#lib_column_modal").html(column);
    	$('#modal_types_select').modal('show');
    }// /show_modal_types_select


    function create_button_infer_html(value, lib) {
    	var button_html = '<button class="btn btn-xs btn-success2" value="' + lib + '" onClick="show_modal_types_select(\'td_bt_' + value + '\');">';
    	button_html += rch(lib, 25);
    	button_html += '&nbsp;<span class="glyphicon glyphicon-edit"></span></button>';
    	return button_html;
    }// /create_button_infer_html


    function create_button_no_infer_html(value) {
    	var button_html = '<button class="btn btn-xs btn-warning" value="empty" onClick="show_modal_types_select(\'td_bt_' + value + '\');">Ajout manuel&nbsp;<span class="glyphicon glyphicon-plus"></span></button>';
    	return button_html;
    }// /create_button_no_infer_html


	String.prototype.replaceAll = function(search, replacement) {
	    var target = this;
	    return target.split(search).join(replacement);
	}; // Ajout de replaceAll


    function space_to_underscore(lib) {
    	lib = lib.replaceAll(" ", "_");
    	return lib;
    }// /space_to_underscore


    function apos_to_underscore(lib) {
    	lib = lib.replaceAll("'", "_");
    	return lib;
    }// /apos_to_underscore


    function normalize(lib) {
    	lib = space_to_underscore(lib);
    	lib = apos_to_underscore(lib);

    	return lib;
    }// /normalize


    function write_types(result) {
    	var tab_col = new Array();
    	var tab_infer = new Array();

    	for (var i = 0; i < metadata.column_tracker.selected.length; i++) {
    		var column_name = metadata.column_tracker.selected[i];

			tab_col.push(column_name);

			// Si une inference existe pour cette colonne, on stocke l'info
			if(typeof result.column_types[column_name] != 'undefined'){
				// Si le champ fait plus de 25 caractères, et qu'il comporte un espace, on le fait aller a la ligne
				//tab_infer[result.columnTypes[column_name]] = create_button_infer_html(result.columnTypes[column_name]);
				tab_infer[column_name] = create_button_infer_html(column_name,result.column_types[column_name]);
			}
			else{
				tab_infer[column_name] = create_button_no_infer_html(column_name);
			}
		}

    	var html_th = "";
    	var html_tr = "";

    	for (column_name in tab_infer){
			// ligne de boutons
			html_tr += '<td class="text-center" id="td_bt_' + normalize(column_name) + '">' + tab_infer[column_name] + '</td>';
		}

		for (var i = 0; i < tab_col.length; i++) {
			// Entete
			html_th += '<th class="text-center">' + tab_col[i] + '</th>';
		}


    	var html = '<table class="table table-striped table-responsive table-condensed" style="width:100%;" data-intro=\"Le type détecté dans vos colonnes s\'affiche et peut être modifié ici\">';
		html += '<thead><tr>' + html_th + '</tr></thead>'; // / ligne entete
		html += '<tr>' + html_tr + '</tr></thead>'; // / ligne entete
		html += "</table>";

    	$("#result #columns").html(html);
    	$("#result").css("visibility","visible");

    	gl_columns = tab_col; // Sauvegarde des colonnes ne tableau global
    }// write_types


    function toggle_p(normalized_cat) {
    	$('#' + normalized_cat + '_content').slideToggle();
    	if($('#' + normalized_cat + '_chevron').hasClass("glyphicon-chevron-right")){
    		$('#' + normalized_cat + '_chevron').removeClass("glyphicon-chevron-right");
    		$('#' + normalized_cat + '_chevron').addClass("glyphicon-chevron-down");
    	}
    	else{
    		$('#' + normalized_cat + '_chevron').removeClass("glyphicon-chevron-down");
    		$('#' + normalized_cat + '_chevron').addClass("glyphicon-chevron-right");
    	}
    }// /toggle_p


	function write_categories_types_modal(categories){
		console.log("write_categories_types_modal");
		console.dir(categories);

		var html = "";
		for(cat in categories){
			html += '<h5 class="category_title" onClick="toggle_p(\'' + normalize(cat) + '\');"><span id="' + normalize(cat) + '_chevron" class="glyphicon glyphicon-chevron-right"></span>' + cat + '[' + categories[cat].length + ']</h5>';
			html += '<div id="' + normalize(cat) + '_content" class="category">';

			for (var i = 0; i < categories[cat].length; i++) {
				html += '<div><a href="#" onClick="set_value(\'' + categories[cat][i] + '\');">' + categories[cat][i] + '</a></div>';
			}
			html += '</div>';
		}

		$("#cat_list_modal").html(html);

		minimize_categories_modal();

	}// /write_categories_types_modal


	function tags_modal(tags) {
		// Creation de tab_tags qui aura pour indices les tags associés à un ou plusieurs types
		// tab_tags est global

		for(tag in tags){
			for (var i = 0; i < tags[tag].length; i++) {
				// Ajout de l'élément s'il n'existe pas
				if (tab_tags.indexOf(tags[tag][i]) === -1) {
					tab_tags.push(tags[tag][i]);

					tab_tags[tags[tag][i]] = new Array();
					tab_tags[tags[tag][i]].push(tag);
				}
				else{
					// todo: test de l'existence
					tab_tags[tags[tag][i]].push(tag);
				}
			}
		}
	} // /tags_modal


	function filtreTexte(requete) {
	  return tab_tags.filter(function (el) {
	    return el.toLowerCase().indexOf(requete.toLowerCase()) > -1;
	  })
	}// /filtreTexte


	function search_with_tags() {
		var needle = $("#in_search").val();

		if(needle.length < 2){
			return false;
		}
		else {
			$("#search_result").html("");
		}

		var html = "";
		var tab_keys = filtreTexte(needle);

		// Recherche des types associés
		var tab_types_list = new Array();
		for (var i = 0; i < tab_keys.length; i++) {
			tab_types_list[tab_keys[i]] = tab_tags[tab_keys[i]];
		}

		var tab_final = new Array();
		for (var tab in tab_types_list){
			// Récupération de toutes les valeurs
			// ! elles peuvent etre en double
			var tab_values = tab_types_list[tab];

			for (var i = 0; i < tab_values.length; i++) {

				if(tab_final.indexOf(tab_values[i]) == -1){ // On retire les doublons
					tab_final.push(tab_values[i]);
				}
			}
		}

		// Tri du tableau
		tab_final.sort();

		// Parcours du tableau pour affichage
		for (var i = 0; i < tab_final.length; i++) {
			html += '<a href="#" onClick="set_value(\'' + tab_final[i] + '\');">' + tab_final[i] + '</a><br>';
		}

		// Affichage des tags dans la modal
		$("#search_result").html(html);

	}// /search_with_tags


	function minimize_categories_modal() {
		$(".category").toggle();
	}// /minimize_categories_modal


	function set_value(lib) {
		var value = selected_column.substring(6);
		$("#"+selected_column).html(create_button_infer_html(value, lib));
		$('#modal_types_select').modal('hide');
	}// /set_value


    function delete_td_bt() {
    	var value = selected_column.substring(6);
		$("#"+selected_column).html(create_button_no_infer_html(value));
		$('#modal_types_select').modal('hide');
    }// /delete_td_bt


	function generate_sample() {
		console.log("Sample");
        var tparams = {
            "module_name": "INIT"
        }
		$.ajax({
			type: 'post',
			dataType: "json",
			contentType: "application/json; charset=utf-8",
			url: '<?php echo BASE_API_URL;?>' + '/api/last_written/normalize/<?php echo $_SESSION['project_id'];?>',
			data: JSON.stringify(tparams),
			success: function (result) {

				if(result.error){
					console.log("API error");
					console.log(result.error);
				}
				else{
                    console.log("success");
                    console.dir(result);

		            tparams = {
		            	"data_params": {
		                	"module_name": result.module_name,
		                	"file_name": result.file_name
		                },
		                "module_params":{
		                	"sampler_module_name": "standard",
			                "sample_params": {
			                	"num_rows": 20
			                }
		                }
		            }
					console.log("appel sample");

					$.ajax({
						type: 'post',
						dataType: "json",
						contentType: "application/json; charset=utf-8",
						url: '<?php echo BASE_API_URL;?>/api/sample/normalize/<?php echo $_SESSION['project_id'];?>',
						data: JSON.stringify(tparams),
						success: function (result) {

							if(result.error){
								console.log("API error");
								console.dir(result.error);
							}
							else{
		                        console.log("success sample");
		                        console.dir(result.sample);

		                        // Remplissage de la modale
		                        var ch = '<table class="table table-responsive table-condensed table-striped" id="sample_table">';

		                        ch += "<thead><tr>";
								$.each(columns, function( j, name) {
									tab_sample[name] = new Array();
									  ch += '<th>' + name + "</th>";
									});
		                        ch += "</tr></thead><tbody>";

		                        console.dir(columns);

								$.each(result.sample, function( i, obj) {
									ch += "<tr>";
									$.each(columns, function( j, name) {
										ch += "<td>" + obj[name] + "</td>";
										tab_sample[name].push(obj[name]);
									});
									ch += "</tr>";
								});
								ch += "</tbody></table>";
		                    }
		                },
		                error: function (result, status, error){
		                    console.log("error");
		                    console.log(result);
		                    err = true;
		                }
		            });// /ajax
                }
            },
            error: function (result, status, error){
                console.log("error");
                console.log(result);
                err = true;
            }
        });// /ajax
    }// / generate_sample


    function get_params() {
		//var tab_columns = new Array();
		var tab_columns_all = new Array();

		var obj = new Object();
		obj.data_params = new Object();
		obj.data_params.module_name = module_name;
		obj.data_params.file_name = file_name;

		obj.module_params = new Object();
		obj.module_params.column_types = new Object();

		// Parcours de toutes les colonnes
		gl_columns.forEach(function(val){
			// Récupération du type correspondant
			var type = $("#td_bt_" + val + " .btn").val();

			if(type == "empty"){
				return;
			}
			// Si !empty, on l'ajoute aux parametres
			//tab_columns[val] = type;
			obj.module_params.column_types[val] = type;
		});

		return obj;
    }// /get_params


    function valid(){
        // Appel de l'étape suivante
        window.location.href = "<?php echo base_url('index.php/Project/normalize/'.$_SESSION['project_id']);?>";
    }// /valid


	function treatment_recode_types(){
		var oparams = get_params();
		console.log("obj_recode_types");
		console.dir(oparams);

		$.ajax({
			type: 'post',
			url: '<?php echo BASE_API_URL;?>' + '/api/schedule/recode_types/<?php echo $_SESSION['project_id'];?>/',
			data: JSON.stringify(oparams),
			contentType: "application/json; charset=utf-8",
			traditional: true,
			async: false,
			success: function (result) {
				console.log("job - recode_types - success");
				console.dir(result);

			    $("#treatment_process").html("");
			    $('#start_treatment_ok').css('visibility', 'visible');

			    // Appel
			    var handle = setInterval(function(){
			    	$("#treatment_process").html($("#treatment_process").html() + "."); // avancement
					$.ajax({
						type: 'get',
						url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
						success: function (result2) {
							if(result2.completed){
		                		clearInterval(handle);

			                    console.log("success - trt - recode_types");
			                    console.dir(result2);

			                    // Affichage du rapport
			                    $('#show_report_ok').css('visibility', 'visible');

			                    var dif = (result2.result.end_timestamp - result2.result.start_timestamp) * 1000;
			                    $("#elapsed_time").html(dif.toFixed(3));

			                    $('#report').css('display', 'inherit');
			                    $("#bt_next").prop("disabled", false);

            					write_report_html(result2.result.mod_count, "tab_reports", true);
							}
							else{
								console.log("job en cours");
			                }
			            },
			            error: function (result2, status, error){
			                console.log("error");
			                console.log(result2);
			                err = true;
			                clearInterval(handle);
			            }
			        });// /ajax - job
			    }, 1000);
            },
            error: function (result, status, error){
				console.log("job - recode_types - error");
                console.log(result);
                console.log(status);
                console.log(error);
                err = true;
            }
        });// /ajax - recode_types
	}// /treatment_recode_types()


    function add_actions_buttons() {
		$("#bt_next").click(function(){
			valid();
		});

		$("#bt_skip_infer").click(function() {
		   skip_infer();
		});// /bt_skip_infer

		$("#bt_skip").click(function() {
		   skip();
		});// /bt_skip

		$('#in_search').on('input',function(e){
			search_with_tags()
		});

		$("#bt_delete_modal").click(function(){
			delete_td_bt();
		});

		$("#bt_infer_types").click(function(){
			// affichage de la div de "chargement" + trt des bt
			$("#wait").css("display","inherit");
			$("#bt_infer_types").css("display", "none");

			// lancement de l'inference
			treatment_infer_types();
		});

		$("#bt_recode_types").click(function(){
			$('#steps').css('display', 'inherit');
			$("#bt_recode_types").prop("disabled", true);

			// lancement du recodage
			treatment_recode_types();
		}); // /bt_recode_types
    }// /add_actions_buttons()

	// Init - Ready
	$(function() {

		// Globales
		err = false;
		selected_column = "";
		tab_sample = new Array();
		columns = "";
		tab_tags = new Array();

		project_id = '<?php echo $_SESSION['project_id'];?>';

		// Métadata du projet
		metadata = get_metadata('normalize', project_id);

		// Colonnes du fichier
		columns = metadata.column_tracker.original;

		// Récupération du nom de fichier et tu nom de module
		last_written()

		// MAJ du nom du projet
		$("#project_name").html(metadata.display_name);

		// creation de l'échantillon
		generate_sample();

        // Ajout des actions boutons
        add_actions_buttons();

		// Lancement auto de l'inference
		$("#bt_infer_types").click();
	});// /Ready
</script>
</body>
</html>
