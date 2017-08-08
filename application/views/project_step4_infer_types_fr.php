<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Normalisation</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-tagsinput.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css');?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/style_fu.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/jquery.fileupload.css');?>">

    <script type="text/javascript" src="<?php echo base_url('assets/jquery-3.2.1.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/bootstrap-tagsinput.min.js');?>"></script>


    <script type="text/javascript" src="<?php echo base_url('assets/jquery.ui.widget.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/jquery.iframe-transport.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.fileupload.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/functions.js');?>"></script>

    <style type="text/css">
        #msg_danger, #result, #report, #steps, #wait{
            /*On masque par défaut*/
            display: none;
        }

        #start_treatment_ok, #show_report_ok{
        	visibility: hidden;
        }
        .tagsinput-perso{
        	margin-right: 5px;
        }
        .tagsinput-perso-all{
        	background-color: #5bc0de;
        	/*background-color: #E37495;*/
        	color: white;
        }
        #dl_file{
        	cursor: pointer;
        }
        .category_title{
        	cursor: pointer;
        }
		@media (min-width: 992px) {
		    .modal-lg {
		        width: 1100px;
		    }
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
                    <?php
                    if(isset($_SESSION['user'])){
                        echo "<li><a href='".base_url("index.php/User/dashboard")."'><span class='glyphicon glyphicon-th' aria-hidden='true'></span>&nbsp;&nbsp;Tableau de bord</a></li>";
                        echo "<li><a href='".base_url("index.php/User/logout")."'><span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp;&nbsp;Déconnexion</a></li>";
                    }
                    else{
                        echo "<li><a href='".base_url("index.php/User/login/normalize")."'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span>&nbsp;&nbsp;S'identifier</a></li>";
                    }
                    ?>
                    <li role="separator" class="divider"></li>
                    <li><a href="#"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>&nbsp;&nbsp;English</a></li>
                </ul>
            </div><!-- /dropdown-->
		</div>
	</div>

	<hr>

    <div class="text-center">
        <div class="breadcrumb flat">
            <!--<a href="#" class="done">Sélection du fichier</a>-->
            <a href="<?php echo base_url("index.php/Project/normalize");?>" class="done">Sélection du fichier</a>
            <a href="<?php echo base_url("index.php/Project/load_step2_select_columns");?>" class="done">Sélection des colonnes</a>
            <a href="<?php echo base_url("index.php/Project/load_step3_missing_values");?>" class="done">Valeurs manquantes</a>
            <a href="#" class="active">Détection des types</a>
            <a href="#" class="todo">Traitement & Téléchargement</a>
        </div>
    </div>

	<div class="well">
		<div class="row">
			<div class="col-md-10">
				<h2 style="margin-top: 0;"><span id="project_name"></span> : <i>Détection des types</i></h2>
			</div>
			<div class="col-md-2 text-right">
				<a href="<?php echo base_url('index.php/Project/load_step4_infer_types');?>">Passer cette étape</a>
			</div>
		</div>
		<p>
			Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. <br><br>
			Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. 
		</p>
		<div class="row">
			<div class="col-md-12 text-center">
				<button class="btn btn-success" id="bt_infer_types">Lancer la détection des types</button>
			</div>
		</div>
		<script type="text/javascript">
			$("#bt_infer_types").click(function(){
				// affichage de la div de "chargement" + trt des bt
				$("#wait").css("display","inherit");
				//$("#bt_infer_types").prop("disabled", true);
				$("#bt_infer_types").css("display", "none");

				// lancement de l'inference
				treatment();
			});
		</script>
		
		<div class="row">
			<div class="col-xs-12 text-center" id="wait">
				<img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">
			</div>
		</div>
		
		<div class="row" id="result">
			<div class="col-xs-12">
			<!--
				<div class="row">
					<div class="col-xs-12 text-center" style="margin-bottom: 20px;">
						<button class="btn btn-success2"><span class='glyphicon glyphicon-eye-open'></span>&nbsp;Aperçu des données</button>
					</div>
				</div>
			-->
				<div class="row">
					<div class="col-xs-12">
						<hr>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12" id="columns" style=" overflow-x:scroll"></div>
				</div>

				<div class="row">
					<div class="col-xs-12 text-right">
						<button class="btn btn btn-success" id="bt_recode_types">Lancer le traitement de l'échantillon</button>
					</div>
				</div>
			</div>
		</div>
    </div><!-- /well-->
</div><!--/container-->

<div class="container">
    <div class="well" id="steps">
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

    <div class="well" id="report">
        <h2>Rapport : </h2>
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="<?php echo base_url('assets/img/report.png');?>" style="height: 150px;">
            </div>
            <div class="col-md-9">
            	<h3>Modifications effectuées</h3>
            	<div id="tab_reports"></div>
            	<!--
            	<a id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier</a>
            	-->
            </div>
        </div><!-- /row-->
	    <div class="row">
	        <div class="col-md-12 text-right">
	            <button class="btn btn btn-success" id="bt_next" disabled>Etape suivante : Traitement et téléchargement >></button>
	        </div>
	    </div><!-- /row-->
    </div><!-- /well /report-->

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
								<input type="text" class="form-control" id="search" placeholder="Recherche par mot clé">
							</div>
						</form>
						<div id="search_result">
							...
						</div>
					</div>
					<div class="col-md-4">
						<h3 style="display: inline;">Catégories</h3><!--&nbsp;<a id="bt_toggle_cat_in_modal">Déplier tout</a>-->
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

		err = false;
		selected_column = "";
		tab_sample = new Array();
		columns = "";


		function chargement(err) {
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

								                    write_tags_modal(result.result.type_tags);
													
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

        }

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
        }

        function create_tab_html(tab) {
        	var html = '<table class="table table-striped table-responsive table-condensed" style="width:100%;">';

        	for (var i = 0; i < tab.length; i++) {
        		html += '<tr><td>' + tab[i] + '</td></tr>';
        	}

        	html += '</table>';

        	return html;
        }

        function show_modal_types_select(id_td_bt_column) {
        	selected_column = id_td_bt_column;

        	// On renseigne la visualisation des données dans la modal en ffonction de la colonne cliquée
        	var column = id_td_bt_column.substring(6);
			$('#data_visualisation_modal').html(create_tab_html(tab_sample[column]));
			$("#lib_column_modal").html(column);
        	$('#modal_types_select').modal('show');
        }

        function create_button_infer_html(value, lib) {
        	var button_html = '<button class="btn btn-xs btn-success2" value="' + lib + '" onClick="show_modal_types_select(\'td_bt_' + value + '\');">';
        	button_html += rch(lib, 25);
        	button_html += '&nbsp;<span class="glyphicon glyphicon-edit"></span></button>';
        	return button_html;
        }

        function create_button_no_infer_html(value) {
        	var button_html = '<button class="btn btn-xs btn-warning" value="empty" onClick="show_modal_types_select(\'td_bt_' + value + '\');">Ajout manuel&nbsp;<span class="glyphicon glyphicon-plus"></span></button>';
        	return button_html;
        }

        function space_to_underscore(lib) {
        	lib = lib.replace(" ", "_");
        	return lib;
        }

        function apos_to_underscore(lib) {
        	lib = lib.replace("'", "_");
        	return lib;	
        }

        function normalize(lib) {
        	lib = space_to_underscore(lib);
        	lib = apos_to_underscore(lib);

        	return lib;
        }

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


        	var html = '<table class="table table-striped table-responsive table-condensed" style="width:100%;">';
			html += '<thead><tr>' + html_th + '</tr></thead>'; // / ligne entete
			html += '<tr>' + html_tr + '</tr></thead>'; // / ligne entete
			html += "</table>";

        	$("#result #columns").html(html);
        	$("#result").css("display","inherit");

        	gl_columns = tab_col; // Sauvegarde des colonnes ne tableau global
        }

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
        }


		function write_categories_types_modal(categories){
			console.log("write_categories_types_modal");
			console.dir(categories);

			var html = "";
			for(cat in categories){
				html += '<h5 class="category_title" onClick="toggle_p(\'' + normalize(cat) + '\');"><span id="' + normalize(cat) + '_chevron" class="glyphicon glyphicon-chevron-right"></span>' + cat + '[' + categories[cat].length + ']</h5>';
				//console.log(cat);
				html += '<div id="' + normalize(cat) + '_content" class="category">';

				for (var i = 0; i < categories[cat].length; i++) {
					// console.log(categories[cat][i]);
					html += '<div><a href="#" onClick="set_value(\'' + categories[cat][i] + '\');">' + categories[cat][i] + '</a></div>';
				}
				html += '</div>';
			}

			$("#cat_list_modal").html(html);

			minimize_categories_modal();

		}


		function write_tags_modal(result) {
			console.log("write_tags_modal");
			console.dir(result);

<?php
/*
$input = preg_quote('bl', '~'); // don't forget to quote input string!
$data = array('orange', 'blue', 'green', 'red', 'pink', 'brown', 'black');

$result = preg_grep('~' . $input . '~', $data);
*/
?>

		}


		function minimize_categories_modal() {
			$(".category").toggle();
		}


		function set_value(lib) {
			var value = selected_column.substring(6);
			$("#"+selected_column).html(create_button_infer_html(value, lib));
			$('#modal_types_select').modal('hide');
		}


        function treatment(project_type) {
            console.log("treatment");

            // Appels API ----------------------
            chargement(err);
            // /Appels API ----------------------
        }

        function delete_td_bt() {
        	var value = selected_column.substring(6);
			$("#"+selected_column).html(create_button_no_infer_html(value));
			$('#modal_types_select').modal('hide');
        }

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
        }


        function valid(){
            // Appel de l'étape suivante
            window.location.href = "<?php echo base_url('index.php/Project/concat_with_init/'.$_SESSION['project_id']);?>";
        }

		// Init - Ready
		$(function() {

			$("#bt_next").click(function(){
				valid();
			});

			$.ajax({
				type: 'get',
				url: '<?php echo BASE_API_URL;?>' + '/api/metadata/normalize/<?php echo $_SESSION['project_id'];?>',
				success: function (result) {

					if(result.error){
						console.log("API error");
						console.log(result.error);
					}
					else{
                        console.log("success - metadata");
                        console.dir(result);

                        metadata = result.metadata;
                        columns = metadata.column_tracker.original;

                        $("#project_name").html(metadata.display_name);
                    }
                },
                error: function (result, status, error){
                    console.log(result);
                    console.log(status);
                    console.log(error);
                    err = true;
                }
            });// /ajax metadata


			// creation de l'échantillon
			generate_sample();


			$("#bt_recode_types").click(function(){

				$('#steps').css('display', 'inherit');
				$("#bt_recode_types").prop("disabled", true);

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
													console.log("success - job en cours");

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

			});

			$("#bt_delete_modal").click(function(){
				delete_td_bt();
			});

		});

	</script>



</body>
</html>
