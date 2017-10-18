<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid intro">
	<!--
    <div class="text-center">
        <div class="breadcrumb flat">
            <a href="<?php echo base_url("index.php/Project/normalize");?>" class="done">Sélection du fichier</a>
            <a href="<?php echo base_url("index.php/Project/load_step2_select_columns");?>" class="done">Sélection des colonnes</a>
            <a href="#" class="active">Valeurs manquantes</a>
            <a href="#" class="todo">Détection des types</a>
            <a href="#" class="todo">Téléchargement</a>
        </div>
    </div>
	-->
	<div class="row" style="padding-top: 20px;">
		<div class="col-sm-8">
			<h2 class="page_title"><span id="project_name"></span> : <i>Recherche des valeurs manquantes</i></h2>
			<span class="cl_filename">
				<i class="fa fa-file-text" aria-hidden="true"></i>
				Traitement du fichier <span id="filename" class="file"></span>
			</span>
		</div>
		<div class="col-sm-4 text-right">
			<a id="bt_skip" class="btn btn-xs btn-success2">Passer cette étape >></a>
		</div>
	</div>
	<div class="row" style="padding-bottom: 20px;">
		<div class="col-sm-6">
			<p class="page_explain">
				Dans de nombreux systèmes d'informations ou pour des données renseignées manuellement, des valeurs manquantes sont représentées par des chaines de caratère ('non-renseigné', 'NR', 'xxxxx', etc.). <strong>Cela nuit à l'analyse de données</strong> et rend la jointure moins performante.
				<br><br>
				Dans cette étape, la machine suggère des libéllés de <strong>valeurs manquantes potentielles</strong> présentes dans votre fichier. Vous pouvez corriger ces valeurs. <strong>Elles seront ensuite remplacées par l'absence de valeur</strong>.
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
	<div class="row" style="padding-bottom: 20px;">
		<div class="col-md-12 text-center">
			<button class="btn btn-success" id="bt_infer_mvs">Lancer la recherche des valeurs manquantes sur l'échantillon</button>
		</div>
	</div>
	<div class="row" id="wait">
		<div class="col-xs-12 text-center">
			<img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">
		</div>
	</div>
	<div class="row background_1" id="result">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12" id="columns"></div>
			</div>
			<div class="row">
				<div class="col-xs-6" id="all_columns">
					Ajouter pour toutes les colonnes : <input type="text" id="in_all_columns">
					<button class="btn btn-success2 btn-xs" id="bt_all_columns">+</button>
				</div>
				<div class="col-xs-6 text-right">
					<button class="btn btn btn-success" id="bt_replace_mvs">Lancer le traitement de l'échantillon</button>
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
	            <button class="btn btn btn-success" id="bt_next" disabled>Etape suivante : Détection des types >></button>
	        </div>
	    </div><!-- /row-->
    </div><!-- /report-->
</div><!--/container-->



<?php 
if(isset($this->session->project_type)){
	$project_type = $this->session->project_type;
}
?>
<script type="text/javascript">

	err = false;

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
                    $("#filename").html(file_name);
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
		    	"module_name": "replace_mvs",
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
					console.dir(result.error);
				}
				else{
				    console.log("success - set_skip");
				    console.dir(result);

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


	function select_all(){
		$( ".columns" ).each(function( index ) {
		  //console.log( index + ": " + $( this ).val() );
		  $(this).prop('checked', true);
		});
	}// /select_all()


	function unselect_all(){
		$( ".columns" ).each(function( index ) {
		  //console.log( index + ": " + $( this ).val() );
		  $(this).prop('checked', false);
		});
	}// /unselect_all()


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
	}// /select_checked_columns()


    function write_mvs(result) {
		var columns = result.result.mvs_dict.columns;
		gl_columns = result.result.mvs_dict.columns;
        var tresh = result.result.mvs_dict.tresh;

        var other_values = new Array(); // Autres valeurs proposées

        var ch = '<table class="table table-responsive table-condensed table-striped">';
        ch += "<tr>";
		ch += "<th></th>";
		ch += "<th data-intro=\"Valeurs manquantes détectées automatiquement\">Valeurs suggérées</th>";
		ch += "<th data-intro=\"Valeurs manquantes détectées automatiquement (peu probables)\">Autres suggestions</th>";
		ch += "<th data-intro=\"Ajoutez des représentations de valeurs manquantes ou nulls\">Ajout manuel</th>";
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

		//$("#result").css("display","inherit");
		$("#result").css("visibility","visible");
    }// /add_value_checked()


	function add_value_checked(column_name){
		$("." + column_name + "_checked").each(function( index ) {
			if($(this).prop('checked') == true){
		  		add_value(this["value"], column_name + "_target", true);
			}
		});

		// Fermeture modal
		$('.modal_other_' + column_name).modal('hide')
	}// /add_value_checked()


	function add_value_on_keypress(e, column_name){
		if(e.keyCode === 13){
		    e.preventDefault();
		    add_value(column_name + "_to_add", column_name + "_target");
		}
	}// /add_value_on_keypress()


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
	}// /add_value()


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
	}// /add_first_value_for_all()


	function auto_delete(obj) {
		// Suppression de l'objet
		$(obj).remove();
	}//auto_delete()


	function auto_delete_all(value) {
		// Suppression de tous les objets identiques
		$('button').remove('.' + value + '_all_to_remove');
	}// /auto_delete_all()


    function treatment_infer() {
        console.log("treatment_infer");

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
											if(result.completed){
							                    clearInterval(handle);

							                    console.log("success - job");
							                    console.dir(result);

							                    // Arret de l'animation recherche
							                    $("#wait").css("display","none");
							                    
							                    write_mvs(result);
											}
											else{
												console.log("job en cours");
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
	}// /treatment_infer()


	function treatment_replace() {
		$('#steps').css('display', 'inherit');
		$("#bt_replace_mvs").prop("disabled", true);
		
    	var oparams = get_params();

		$.ajax({
			type: 'post',
			url: '<?php echo BASE_API_URL;?>' + '/api/schedule/replace_mvs/' + project_id + '/',
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
								if(result2.completed){
				                    clearInterval(handle);

				                    console.log("success - job - replace_mvs");
				                    console.log(result2);

				                    // Affichage du rapport
				                    $('#show_report_ok').css('visibility', 'visible');

				                    var dif = (result2.result.end_timestamp - result2.result.start_timestamp) * 1000;
				                    $("#elapsed_time").html(dif.toFixed(3));

				                    $('#report').css('display', 'inherit');
				                    $("#bt_next").prop("disabled", false);

				                    var modified_columns = result2.result.mod_count;
									
									write_report_html(modified_columns, "tab_reports", true);
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
				}
            },
            error: function (result, status, error){
                console.log(result);
                console.log(status);
                console.log(error);
                err = true;
            }
        });// /ajax
	}// /treatment_replace()


    function valid(){
        // Appel de l'étape suivante
        window.location.href = "<?php echo base_url('index.php/Project/normalize/'.$_SESSION['project_id']);?>";
    }// /valid()


    function add_actions_buttons() {
		$( "#in_all_columns" ).keypress(function( event ) {
			//event.preventDefault();
			if ( event.which == 13 ) {
		    	add_first_value_for_all();
			}
		});// /in_all_columns

		$( "#bt_all_columns" ).click(function() {
		   add_first_value_for_all();
		});// /bt_all_columns


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
	    });// /dl_file

		$("#bt_skip").click(function() {
		   skip();
		});// /bt_skip

		$("#bt_infer_mvs").click(function(){
			// affichage de la div de "chargement" + trt des bt
			$("#wait").css("display","inherit");
			$("#bt_infer_mvs").prop("disabled", true);
			$("#bt_infer_mvs").css("display", "none");
			$("#didacticiel").css("visibility","visible");

			// lancement de l'inference
			treatment_infer();
		});// /bt_infer_mvs


		$("#bt_replace_mvs").click(function(){
			treatment_replace();
		}); // bt_replace_mvs


		$("#bt_next").click(function(){
			valid();
		});// /bt_next
    }// /add_buttons()


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
    }// /get_params()


	$(function() {// Ready
		console.log("chargement");
		console.log("project_id : <?php echo $_SESSION['project_id'];?>");

		project_id = '<?php echo $_SESSION['project_id'];?>';

		// Métadata du projet
		metadata = get_metadata('normalize', project_id);

		// Récupération du nom de fichier et tu nom de module
		last_written();

		// Récupération du nombre de lignes
		// TODO
		// Message en fonlction du nombre de lignes (echantillon ou pas)

		// MAJ du nom du projet
        $("#project_name").html(metadata.display_name);

        // Ajout des actions boutons
        add_actions_buttons();
	});// /ready

</script>
</body>
</html>