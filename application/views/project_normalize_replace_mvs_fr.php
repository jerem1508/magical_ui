
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px;">
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
	<div class="well">
		<div class="row">
			<div class="col-sm-8">
				<h2 class="page_title"><span id="project_name"></span> : <i>Recherche des valeurs manquantes</i></h2>
			</div>
			<div class="col-sm-4 text-right">
				<div id="didacticiel">
					<a href="#" onclick="javascript:introJs().setOption('showBullets', false).start();">Didacticiel</a>
					&nbsp;|&nbsp;
				</div>
				<a href="<?php echo base_url('index.php/Project/load_step4_infer_types');?>">Passer cette étape</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 page_explain">
				Dans de nombreux systèmes d'informations ou pour des données renseignées manuellement, des valeurs manquantes sont représentées par des chaines de caratère ('non-renseigné', 'NR', 'xxxxx', etc.). <strong>Cela nuit à l'analyse de données</strong> et rend la jointure moins performante.
				<br><br>
				Dans cette étape, la machine suggère des libéllés de <strong>valeurs manquantes potentielles</strong> présentes dans votre fichier. Vous pouvez corriger ces valeurs. <strong>Elles seront ensuite remplacées par l'absence de valeur</strong>.
			</div>
		</div>
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
				$("#bt_infer_mvs").css("display", "none");
				$("#didacticiel").css("visibility","visible");

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
			<div class="col-xs-12">
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


						                    var modified_columns = result2.result.mod_count;
											
											write_report_html(modified_columns, "tab_reports", true);

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
