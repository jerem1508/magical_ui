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
        	background-color: #E37495;
        	color: white;
        }
        #dl_file{
        	cursor: pointer;
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
            <a href="#" class="active">Valeurs manquantes</a>
            <a href="#" class="todo">Détection des types</a>
            <a href="#" class="todo">Téléchargement</a>
        </div>
    </div>
	<div class="well">
		<div class="row">
			<div class="col-md-10">
				<h2 style="margin-top: 0;"><span id="project_name"></span> : <i>Recherche des valeurs manquantes</i></h2>
			</div>
			<div class="col-md-2 text-right">
				<a href="<?php echo base_url('index.php/Project/load_step4_infer_types');?>">Passer cette étape</a>
			</div>
		</div>
		
		<p>
			Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. 
		</p>
		<div class="row">
			<div class="col-md-12 text-center">
				<button class="btn btn-success" id="bt_infer_mvs">Lancer la recherche des valeurs manquantes sur l'échantillon</button>
			</div>
		</div>
		<script type="text/javascript">
			$("#bt_infer_mvs").click(function(){
				// affichage de la div de "chargement" + trt des bt
				$("#wait").css("display","inherit");
				$("#bt_infer_mvs").prop("disabled", true);

				// lancement de l'inference
				treatment();
			});
		</script>
		<div class="row" id="wait">
			<div class="col-xs-12 text-center">
				<img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">
			</div>
		</div>
		<div class="row" id="result">
			<div class="col-xs-12 text-center">
			<hr>
			</div>
			<div class="col-xs-12">
			<!--
				<div class="row">
					<div class="col-xs-12 text-center" style="margin-bottom: 20px;">
						<button class="btn btn-success2"><span class='glyphicon glyphicon-eye-open'></span>&nbsp;Aperçu des données</button>
					</div>
				</div>
			-->
				<div class="row">
					<div class="col-xs-12" id="columns">
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6" id="all_columns">
						Ajouter pour toutes les colonnes : <input type="text" id="in_all_columns">
						<button class="btn btn-success2 btn-xs" id="bt_all_columns">+</button>

						<script type="text/javascript">
							$( "#in_all_columns" ).keypress(function( event ) {
								//event.preventDefault();
								if ( event.which == 13 ) {
							    	add_first_value_for_all();
								}
							});
							$( "#bt_all_columns" ).click(function() {
							   add_first_value_for_all();
							});
						</script>
					</div>
					<div class="col-xs-6 text-right">
						<button class="btn btn btn-success" id="bt_replace_mvs">Lancer le traitement de l'échantillon</button>
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
            <div class="col-md-3">
                <div class="panel panel-info">
                	<div class="panel-heading">
                		Temps de traitement
                	</div>
                  <div class="panel-body text-center">
                    <h2 style="display: inline;"><span id="elapsed_time"></span></h2> <i>millisecondes</i>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
            	<div id="tab_report"></div>
            	<a id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier</a>
            </div>

        </div><!-- /row-->

	    <div class="row">
	        <div class="col-md-12 text-right">
	            <button class="btn btn btn-success" id="bt_next" disabled>Etape suivante : Détection des types >></button>
	        </div>
	    </div><!-- /row-->
    </div><!-- /well /report-->
</div><!--/container-->



	<?php 
	if(isset($this->session->project_type)){
		$project_type = $this->session->project_type;
	}
	?>


	<script type="text/javascript">

		err = false;

		function select_all(){
			$( ".columns" ).each(function( index ) {
			  //console.log( index + ": " + $( this ).val() );
			  $(this).prop('checked', true);
			});
		}

		function unselect_all(){
			$( ".columns" ).each(function( index ) {
			  //console.log( index + ": " + $( this ).val() );
			  $(this).prop('checked', false);
			});
		}



		function select_checked_columns(){
			var tab_columns = new Array();
			$( ".columns" ).each(function( index ) {
				if( $(this).prop('checked') == true){
					tab_columns.push($(this).val());
					console.log( index + ": " + $( this ).val() );
				}
			});
			//var ch = tab_columns.join(",");
			return tab_columns;
		}

		$("#bt_next").click(function(){
			valid();
		});


		function write_report_html(obj_to_print, auto_scroll)
		{
			var html = '<div><table class="table table-responsive table-condensed table-striped">';

			html += "toto";

			html += '</table></div>';

			$("#report").html($("#report").html() + html);

			// Gestion du scroll
			// TODO
		}

		function chargement(err) {

            var tparams = {
                "before_module": "replace_mvs"
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
							url: '<?php echo BASE_API_URL;?>' + '/api/schedule/infer_mvs/<?php echo $_SESSION['project_id'];?>/',
							data: JSON.stringify(tparams),
							success: function (result) {

								if(result.error){
									console.log("API error - infer_mvs");
									console.dir(result.error);
								}
								else{
								    console.log("success - infer_mvs");
								    console.dir(result);

								    // Appel 
								    var handle = setInterval(function(){
										$.ajax({
											type: 'get',
											url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
											success: function (result) {
												if(result.error){
													console.log("API error - job");
													console.dir(result.error);
												}
												else{
								                    console.log("success - job");
								                    console.dir(result);

								                    clearInterval(handle);

								                    // Arret de l'animation recherche
								                    $("#wait").css("display","none");
								                    
								                    write_mvs(result);
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
        } // / chargement


        function write_mvs(result) {
			var columns = result.result.mvs_dict.columns;
			gl_columns = result.result.mvs_dict.columns;
	        var tresh = result.result.mvs_dict.tresh;

	        var other_values = new Array(); // Autres valeurs proposées

	        var ch = '<table class="table table-responsive table-condensed table-striped">';
	        ch += "<tr>";
			ch += "<th></th>";
			ch += "<th>Valeurs suggérées</th>";
			ch += "<th>Autres suggestions</th>";
			ch += "<th>Ajout manuel</th>";
	        ch += "</tr>";
	        	
	        for (column in columns) {
	        	ch += "<tr>";
				ch += "<td>" + column + "</td>";

				// Valeurs suggérées
				ch += "<td id='" + column + "_target'>";
				var tab_len = columns[column].length;
				other_values[column] = new Array();
				if(tab_len > 0){
					for (var i = 0; i < tab_len; i++) {
						if(columns[column][i].score < 0.6){
							other_values[column].push(columns[column][i].val);
						}
						else{
							// ch += "<input type='text' data-role='tagsinput' value='" + columns[column][i].val + "'>";
							ch += add_value(columns[column][i].val);
						}
					}
				}
				ch += "</td>";

				// Autres
				ch += "<td>";
				var disabled="";
				if(other_values[column].length > 0){
					//disabled = " disabled";
					ch += '<a href="#" data-toggle="modal" data-target=".modal_other_' + column + '"' + disabled + '>Autres valeurs</a>';
				}
				// Modale
					ch += '<div class="modal fade modal_other_' + column + '" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">';
					ch += '  <div class="modal-dialog modal-sm">';
					ch += '    <div class="modal-content">';
					ch += '<div class="modal-header">';
					ch += '	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					ch += '	<h4 class="modal-title" id="myModalLabel">Autres valeurs détectées</h4>';
					ch += '</div>';
					ch += '<div class="modal-body">';

					for (var i = 0; i < other_values[column].length; i++) {
						ch += '<div class="checkbox">';
						ch += '<label>';
						ch += '  <input type="checkbox" class="' + column + '_checked" value="' + other_values[column][i] + '"> ' + other_values[column][i];
						ch += '</label>';
						ch += '</div>';
					}

					ch += '</div>';
					ch += '<div class="modal-footer">';
					ch += '	<button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>';
					ch += '	<button type="button" class="btn btn-success" onclick="add_value_checked(\'' + column + '\');">Valider</button>';
					ch += '</div>';
					ch += '    </div>';
					ch += '  </div>';
					ch += '</div>';

				ch += "</td>";

				// Ajout manuel
				ch += "<td>";
				ch += '<input class="form" type="text" id="' + column + '_to_add" onkeypress="add_value_on_keypress(event, \'' + column + '\');">';
				ch += "&nbsp;";
				ch += '<button class="btn btn-success2 btn-xs" onclick="add_value(\''+ column + '_to_add\', \'' + column + '_target\');">+</button>';
				ch += "</td>";

	        	ch += "</tr>";

	        }

	        ch += "</table>";
			$("#columns").html(ch);

			$("#result").css("display","inherit");
        }

		function add_value_checked(column_name){
			$("." + column_name + "_checked").each(function( index ) {
				if($(this).prop('checked') == true){
			  		add_value(this["value"], column_name + "_target", true);
				}
			});

			// Fermeture modal
			$('.modal_other_' + column_name).modal('hide')

		}


		function add_value_on_keypress(e, column_name){
			if(e.keyCode === 13){
			    e.preventDefault();
			    add_value(column_name + "_to_add", column_name + "_target");
			}

		}

		function add_value(value, target="", from_modal=false){
			// Ajout auto
			if(target == ""){
				var html = '<button class="btn btn-xs tagsinput-perso btn-info" onclick="auto_delete(this);" value="' + value + '">' + value + ' X</button>';
				return html;
			}
			// Test de la valeur existante
			// todo

			// Ajout sur clic
			var val = from_modal ? value : $("#"+value).val();

			var html = '<button class="btn btn-xs tagsinput-perso btn-info" onclick="auto_delete(this);" value="' + val + '">' + val + ' X</button>';
			$('#'+target).html($('#'+target).html() + html);
			
			if(!from_modal){
				$("#" + value).val("");
			}
		}


		function add_first_value_for_all() {
			console.dir(gl_columns);

			// Valeur a ajouter
			var value = $("#in_all_columns").val();

			// Ajout pour toutes les colonnes
			for (column in gl_columns) {
				var target = column + "_target";
				var html = '<button class="btn btn-xs tagsinput-perso tagsinput-perso-all ' + value + '_all_to_remove" onclick="auto_delete_all(\'' + value + '\');" value="' + value + '">' + value + ' X</button>';
				$('#' + target).html(html + $('#' + target).html());
			}

			// Erase du champ
			$( "#in_all_columns" ).val("");
		}


		function auto_delete(obj) {
			$(obj).remove();
		}


		function auto_delete_all(value) {
			$('button').remove('.' + value + '_all_to_remove');
		}


        function treatment(project_type) {
            console.log("treatment");

            // Appels API ----------------------
            chargement(err);

            // /Appels API ----------------------

		}


        function valid(){
            // Appel de l'étape suivante
            window.location.href = "<?php echo base_url('index.php/Project/recode_types/'.$_SESSION['project_id']);?>";
        }


        function get_params() {
			var tab_columns = new Array();
			var tab_columns_all = new Array();

			// Parcours de toutes les colonnes
			for (column in gl_columns) {
				var obj_btn = $('#' + column + '_target button');
				var tab_values_scores = new Array();
				var ch_tmp1 = "";

				for (var i = obj_btn.length - 1; i >= 0; i--) {
					var ch_tmp2 = '{"val": "' + obj_btn[i]["value"] + '","score": 1}';
					tab_values_scores.push(ch_tmp2);
				}

				ch_tmp1 += '"' + column + '": [';
				ch_tmp1 += tab_values_scores.join(",");
				ch_tmp1 += ']';

				tab_columns.push(ch_tmp1);
			}

			var obj_str = '{"data_params": {"module_name": "' + module_name + '", "file_name": "' + file_name + '"},'
			obj_str += '"module_params": {"mvs_dict": {"columns": {' + tab_columns.join(",") + '}, "all": []}}}';

			console.log("obj_str: ");
			console.dir(obj_str);
			
			return obj_str;
        }

        $("#dl_file").click(function(){
			tparams = {
				"data_params": {
			    	"module_name": "replace_mvs",
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
        });

		// Init - Ready
		$(function() {

			console.log("chargement");
			console.log("project_id : <?php echo $_SESSION['project_id'];?>");

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


			$("#bt_replace_mvs").click(function(){

				$('#steps').css('display', 'inherit');
				$("#bt_replace_mvs").prop("disabled", true);
				
            	var oparams = get_params();

				$.ajax({
					type: 'post',
					url: '<?php echo BASE_API_URL;?>' + '/api/schedule/replace_mvs/<?php echo $_SESSION['project_id'];?>/',
					data: oparams,
					contentType: "application/json; charset=utf-8",
					traditional: true,
					async: false,
					success: function (result) {
						console.dir(result);

						if(result.error){
							console.log("API error - replace_mvs");
							console.dir(result.error);
						}
						else{
						    console.log("success - replace_mvs");
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
										if(result2.error){
											console.log("API error - job");
											console.dir(result2.error);
										}
										else{
						                    console.log("success - job - replace_mvs");
						                    console.dir(result2);

						                    clearInterval(handle);

						                    // Affichage du rapport
						                    $('#show_report_ok').css('visibility', 'visible');

						                    var dif = (result2.result.end_timestamp - result2.result.start_timestamp) * 1000;
						                    $("#elapsed_time").html(dif.toFixed(3));

						                    $('#report').css('display', 'inherit');
						                    $("#bt_next").prop("disabled", false);

write_report_html("","");
/*
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
*/

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
						}
	                },
	                error: function (result, status, error){
	                    console.log(result);
	                    console.log(status);
	                    console.log(error);
	                    err = true;
	                }
	            });// /ajax




			});


		});

	</script>



</body>
</html>
