<?php
if(isset($this->session->project_type)){
	$project_type = $this->session->project_type;
}


if(isset($_SESSION['link_project_id'])){
?>
<script type="text/javascript">
	window.location.href = "<?php echo base_url('index.php/Project/link/'.$_SESSION['link_project_id']);?>";
</script>
<?php
}
?>




<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid intro">

<!--
    <div class="text-center">
        <div class="breadcrumb flat">
            <a href="<?php echo base_url("index.php/Project/normalize");?>" class="done">Sélection du fichier</a>
            <a href="<?php echo base_url("index.php/Project/add_selected_columns");?>" class="done">Sélection des colonnes</a>
            <a href="<?php echo base_url("index.php/Project/replace_mvs");?>" class="done">Valeurs manquantes</a>
            <a href="<?php echo base_url("index.php/Project/recode_types");?>" class="done">Détection des types</a>
            <a href="#" class="active">Téléchargement</a>
        </div>
    </div>
-->
		<div class="row">
			<div class="col-md-12">
				<h2 style="margin-top: 0;"><span id="project_name"></span> : <i>Traitement & téléchargements</i></h2>
				<span class="cl_filename">
				<i class="fa fa-file-text" aria-hidden="true"></i>
				Traitement du fichier <span id="filename" class="file"></span>
				</span>
			</div>
		</div>
		<div class="row" style="padding-bottom: 20px;">
			<div class="col-sm-12">
				<p class="page_explain">
					Si vous avez uploadé un gros fichier, les étapes de traitement précédentes ont été faites sur un échantillon. Vous pouvez lancer le traitement sur l'ensemble du fichier sur cette page.
				</p>
			</div>
		</div>
		<div class="row" id="trt_all" style="padding-bottom: 20px;">
			<div class="col-md-12 text-center">
				<button class="btn btn-success" id="bt_concat_with_init">Lancer le traitement sur l'ensemble du fichier</button>
			</div>
		</div>

		<div class="row" style="padding-bottom: 20px;">
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
					<div class="col-xs-12" id="columns"></div>
				</div>

				<div class="row">
					<div class="col-xs-12 text-right">
						<button class="btn btn btn-success" id="bt_recode_types">Lancer le traitement de l'échantillon</button>
					</div>
				</div>
			</div>
		</div>
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
</div><!--/container-->

<div class="container-fluid background_1" id="reports">
	<!--
    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <h4>Etape 1 : Sélection des colonnes</h4>
            </div>
            <div class="row">
                <div class="col-md-6"><b>Colonnes initiales</b></div>
                <div class="col-md-6"><b>Colonnes sélectionnées</b></div>
            </div>
            <div class="row">
                <div class="col-md-6" id="report_original_columns"></div>
                <div class="col-md-6" id="report_selected_columns"></div>
            </div>
        </div>
    </div>
	-->
    <div class="row">
        <div class="col-md-12">
            <h4>
            	Recherche des valeurs manquantes - <i>Modifications effectuées</i>
            </h4>
        </div>
        <div id="report_replace_mvs"></div>
    </div><!-- /row-->

    <div class="row">
        <div class="col-md-12">
            <h4>
            	Détection des types - <i>Modifications effectuées</i>
            </h4>
        </div>
        <div id="report_recode_types"></div>
    </div><!-- /row-->


	<?php
	if(isset($_SESSION['link_project_id'])){
	?>
        <div class="row" style="padding-bottom: 20px;">
            <div class="col-md-12 text-center">
            <button class="btn btn-success" id="bt_link_project">Poursuivre le projet de jointure</button>
            <script type="text/javascript">
            	$("#bt_link_project").click(function(){
            		window.location.href = "<?php echo base_url('index.php/Project/link/'.$_SESSION['link_project_id']);?>";
            	});
            </script>
            </div>
        </div>
	<?php
	}
	else{
	?>
        <div class="row" style="padding-bottom: 20px;">
            <!---
            <div class="col-md-4">
                <button class="btn btn-success2" id="dl_cfg_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier de configuration</button>
            </div>
			-->
            <div class="col-md-4">
                <button class="btn btn-success2" id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier final</button>
            </div>
			<div class="col-md-4">
                <a href="<?php echo base_url("index.php/Home");?>" class="btn btn-success"><span class="glyphicon glyphicon-home"></span>&nbsp;Retour accueil</a>
            </div>
        <?php
        if(isset($_SESSION['user']))
        {
        ?>
            <div class="col-md-4 text-right">
                <button class="btn btn-success" id="bt_next">Voir mon tableau de bord >></button>
            </div>
        <?php
        }
        ?>
        </div><!-- /row-->
	<?php
	}
	?>

</div><!--/container-->

<script type="text/javascript">

	err = false;
	selected_column = "";
	tab_sample = new Array();
	columns = "";


    function write_reports(module_name) {
        // Download config
        //MINI__source_1.csv__run_info.json
        //MINI__source_1.csv
        var tparams = {
            "data_params": {
                "module_name": module_name,
                "file_name": file_name + "__run_info.json"
            }
        }

        $.ajax({
            type: 'post',
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            url: '<?php echo BASE_API_URL;?>' + '/api/download_config/normalize/<?php echo $_SESSION["project_id"];?>/',
            data: JSON.stringify(tparams),
            success: function (result) {

                if(result.error){
                    console.log("API error - download_config");
                    console.log(result.error);
                }
                else{
                    console.log("success - download_config");
                    console.dir(result);

                    $('#report').css('display', 'inherit');
                    write_report_html(result.result.mod_count, "report_" + module_name, true);
                }
            },
            error: function (result, status, error){
                console.log("error");
                console.log(result);
                err = true;
            }
        });// /ajax - Download config
    }

	function chargement(err) {
		var tparams = {
            "before_module": "concat_with_init"
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


                    if(metadata.has_mini){
                    	// File_name sans MINI__
                        if(file_name.indexOf("MINI__") >= 0){
                    	   file_name = file_name.substr(6);
                        }

			            tparams = {
			            	"data_params": {
			                	"module_name": module_name,
			                	"file_name": file_name
			                },
			                "module_params": null
			            }

                    	// RunAll
						console.log("appel run_all");
						$.ajax({
							type: 'post',
							dataType: "json",
							contentType: "application/json; charset=utf-8",
							url: '<?php echo BASE_API_URL;?>' + '/api/schedule/run_all_transforms/<?php echo $_SESSION['project_id'];?>/',
							data: JSON.stringify(tparams),
							success: function (result) {

								if(result.error){
									console.log("API error - run_all");
									console.dir(result.error);
								}
								else{
								    console.log("success - run_all");
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

                                                    $("#reports").css("visibility","visible");

                                                    write_reports("replace_mvs");

                                                    write_reports("recode_types");

                                                    write_dl('file');

                                                    write_dl('config');
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
			            });// /ajax
                    }
                    else{
                    	// concat_with_init
                    	console.log("appel concat_with_init NO MINI");
		       		    tparams = {
			            	"data_params": {
			                	"module_name": module_name,
			                	"file_name": file_name
			                },
			                "module_params": null
			            }
						$.ajax({
							type: 'post',
							dataType: "json",
							contentType: "application/json; charset=utf-8",
							url: '<?php echo BASE_API_URL;?>' + '/api/schedule/concat_with_init/<?php echo $_SESSION['project_id'];?>/',
							data: JSON.stringify(tparams),
							success: function (result) {

								if(result.error){
									console.log("API error - concat_with_init");
									console.dir(result.error);
								}
								else{
								    console.log("success - concat_with_init");
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

                                                   	$("#reports").css("visibility","visible");

                                                    write_reports("replace_mvs");

                                                    write_reports("recode_types");

								                    write_dl('file');

								                    write_dl('config');
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
			            });// /ajax

                    } // /else pas MINI






                }// / lastwritten - success
            },
            error: function (result, status, error){
                console.log("error");
                console.log(result);
                err = true;
            }
        });// /ajax - last_written

    }

    function to_tab_html(tab_columns)
    {
    	var html = '<table class="table table-striped table-responsive table-condensed" style="width:100%;">';
    	for (var i = 0; i < tab_columns.length; i++) {
    		html += '<tr><td>' + tab_columns[i] + '</td></tr>';
    	}

    	html += '</table>'

    	return html;
    }
    function write_report(step) {
    	var container_step = 'report_' + step;

    	switch(step){
    		case 'select_columns':
				$("#report_original_columns").html(to_tab_html(metadata.column_tracker.original));
				$("#report_selected_columns").html(to_tab_html(metadata.column_tracker.selected));

    		break;
    		case 'replace_mvs':


    			$('#' + container_step).html(container_step);

    		break;
    		case 'recode_types':

    		break;

    	}

    }

    function write_dl(type_file) {
    	// body...
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
    	if($('#' + normalized_cat + 'chevron').hasClass("glyphicon-chevron-right")){
    		$('#' + normalized_cat + 'chevron').removeClass("glyphicon-chevron-right");
    		$('#' + normalized_cat + 'chevron').addClass("glyphicon-chevron-down");
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

					file_name = result.file_name;

                    if(metadata.has_mini){
                    	file_name = file_name.substr(6);
                    }

		            tparams = {
		            	"data_params": {
		                	"module_name": result.module_name,
		                	"file_name": file_name
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

	// Init - Ready
	$(function() {

 		$("#dl_file").click(function(){
			tparams = {
				"data_params": {
			    	"module_name": "concat_with_init",
			    	"file_name": file_name
			    }
			}

			$.ajax({
				type: 'post',
				url: '<?php echo BASE_API_URL;?>' + '/api/download/normalize/<?php echo $_SESSION['project_id'];?>',
				contentType: "application/json; charset=utf-8",
				data: JSON.stringify(tparams),
				success: function (result_dl) {
					if(result_dl.error){
						console.log("API error - dl");
						console.dir(result_dl);
					}
					else{
			            console.log("success - dl");
			            console.dir(result_dl);

			            // DL du fichier
					    var blob=new Blob([result_dl]);
					    var link=document.createElement('a');
					    link.href=window.URL.createObjectURL(blob);
					    link.download=file_name;
					    link.click();

			        }
			    },
			    error: function (result_dl, status, error){
			        console.log("error");
			        console.log(result_dl);
			        err = true;
			        clearInterval(handle);
			    }
			});// /ajax
        }); // /dl_file.click()

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

                    // S'il y avait un mini, on propose le traitement sur l'ensemble du fichier
                    if(metadata.has_mini){
                    	$("#trt_all").prop('display','inherit');
                    }
                    else{
                    	// Affichage du rapport finale
                    	$("#report").prop('display','inherit');
                    }

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
		//generate_sample();


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

							                    var modified_columns = result2.result.modified_columns;

							                    var html = '<table class="table table-responsive table-condensed table-striped">';
							                    var t_lignes = new Array();

							                    for (var i = 0; i < modified_columns.length; i++) {
							                    	var liste_values = result2.result.replace_num.columns[modified_columns[i]];

							                    	console.log(modified_columns[i]);

							                    	var total = 0;
							                    	var t_lib_values = new Array();
							                    	for (value_name in liste_values) {
							                    		console.log(value_name);
							                    		t_lib_values.push(value_name);
							                    		total += result2.result.replace_num.columns[modified_columns[i]][value_name];

							                    		console.log(result2.result.replace_num.columns[modified_columns[i]][value_name]);
							                    	}
							                    	var ligne_html = '<tr>';
							                    	ligne_html += '<td>'+modified_columns[i]+'</td>';
							                    	ligne_html += '<td>'+total+' lignes modifiées ('+t_lib_values.join(",")+')</td>';
							                    	ligne_html += '</tr>';
							                    	t_lignes.push(ligne_html);
							                    }

							                    for (var i = 0; i < t_lignes.length; i++) {
							                    	html += t_lignes[i];
							                    }

							                    html += '</table>';
							                    $("#tab_report").html(html);


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


		$("#bt_concat_with_init").click(function(){
			// affichage de la div de "chargement" + trt des bt
			$("#wait").css("display","inherit");

			$("#bt_concat_with_init").css("display", "none");

			// lancement de l'inference
			treatment();
		});

		$("#bt_next").click(function(){
			window.location.href = "<?php echo base_url('index.php/User/dashboard');?>";
		});

	});// /ready

</script>



</body>
</html>
