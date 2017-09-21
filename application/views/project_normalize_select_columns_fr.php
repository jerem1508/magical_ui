<?php 
if(isset($this->session->project_type)){
	$project_type = $this->session->project_type;
}
?>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px;">
<!--
    <div class="text-center">
        <div class="breadcrumb flat">
            <a href="<?php echo base_url("index.php/Project/normalize");?>" class="done">Sélection du fichier</a>
            <a href="#" class="active">Sélection des colonnes</a>
            <a href="#" class="todo">Valeurs manquantes</a>
            <a href="#" class="todo">Détection des types</a>
            <a href="#" class="todo">Téléchargement</a>
        </div>
    </div>
-->
	<div class="well">
		<h2><span id="project_name"></span> : <i>Sélection des colonnes</i></h2>
		<p>
			 Sélectionnez les colonnes à nettoyer. Dans le cadre d'un projet de jointure, nous recommendons fortement de nettoyer toutes les colonnes suceptibles de servir à la jointure de vos fichiers.
		</p>


	    <div class="well">
	        <a href="#" onclick="javascript:introJs().setOption('showBullets', false).start();">Aide</a>
	    </div>

		<div class="row">
			<div class="col-xs-6 well" style="background-color: #fff">
				<h3>Extrait aléatoire des données</h3>
				Vous avez la possibilité d'afficher un extrait aléatoire du fichier en cours. Cet extrait affichera un maximum de 50 lignes. A chaque clic sur le bouton ci-dessous, un nouvel extrait sera généré.
				<br><br>
				<button class="btn btn-success2 btn-xs" id="bt_view" data-toggle="modal" data-target="#modal-dataview_all" data-intro="Regarder un échantillon de données pour la mémoire..."><span class='glyphicon glyphicon-eye-open'></span>&nbsp;Voir l'extrait</button>

				<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal-dataview_all">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">Aperçu des données</h4>
				      </div>
				      <div class="modal-body" id="data_all" style=" overflow-x:scroll">
				        
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-success2" id="bt_generate_sample"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Regénérer</button>
				        <button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>
				      </div>
				    </div>
				  </div>
				</div>

			</div>
			<div class="col-xs-6">
				<div id="result" data-intro="Sélectionnez les colonnes à nettoyer"></div>
			</div>
		</div>
    </div><!-- /well-->
</div><!--/container-->

<div class="container">
    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn btn-success" id="bt_next">Etape suivante : Détection des valeurs manquantes >></button>
        </div>
    </div><!-- /row-->
</div><!--/container-->


<script type="text/javascript">

		// Init - Ready
		$(function() {
		

			err = false;

			function select_all(){
				$( ".columns" ).each(function( index ) {
				  // console.log( index + ": " + $( this ).val() );
				  $(this).prop('checked', true);
				});
			}

			function unselect_all(){
				$( ".columns" ).each(function( index ) {
				  // console.log( index + ": " + $( this ).val() );
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


			function chargement(err) {
				console.log("chargement");
				/*
				Recupération des colonnes
				*/
				$.ajax({
					type: 'get',
					url: '<?php echo BASE_API_URL;?>' + '/api/metadata/normalize/<?php echo $_SESSION['project_id'];?>',
					success: function (result) {

						if(result.error){
							console.log("API error");
							console.log(result.error);
						}
						else{
	                        console.log("success");
	                        console.dir(result.metadata.column_tracker.original);

							metadata = result.metadata;

	                        $("#project_name").html(metadata.display_name);

	                        var bt = '<button class="btn btn-xs btn-success2 bt_select_all">&nbsp;Tout sélectionner</button>&nbsp;<button class="btn btn-xs btn-warning bt_unselect_all">&nbsp;Tout désélectionner</button>';
	                        var ch = bt;

	                        columns = metadata.column_tracker.original;
							$.each(columns, function( i, name) {
							  ch = ch + "<div class='checkbox'><label><input type='checkbox' class='columns' checked value='" + name + "'>&nbsp;" + name + "</label></div>\n";
							});

							ch = ch + bt;

							$("#result").html(ch);

							$(".bt_select_all").click(function(){
								select_all();
							});
							$(".bt_unselect_all").click(function(){
								unselect_all();
							});


	                    }
	                },
	                error: function (result, status, error){
	                    console.log(result);
	                    console.log(status);
	                    console.log(error);
	                    err = true;
	                }
	            });// /ajax metadata



				generate_sample();



	        } // /Chargement


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
											  ch += '<th>' + name + "</th>";
											});
				                        ch += "</tr></thead><tbody>";
				                        console.dir(columns);
										$.each(result.sample, function( i, obj) {
											ch += "<tr>";
											$.each(columns, function( j, name) {
												ch += "<td>" + obj[name] + "</td>";
											});
											ch += "</tr>";
										});
										ch += "</tbody></table>";

					                    $("#data_all").html(ch);
					                	
					                    $("#sample_table").DataTable({
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
														        "lengthMenu": [5,20,"ALL"],
														        "responsive": true
														    });
										

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
	        }// / generate_sample()


	        function treatment(project_type) {
	            console.log("treatment");

	            // Appels API ----------------------
	            chargement(err);
	            // /Appels API ----------------------
			}








	        function valid(){
	            // Appel de l'étape suivante
	            window.location.href = "<?php echo base_url('index.php/Project/replace_mvs/'.$_SESSION['project_id']);?>";
	        }


			$("#bt_next").click(function(){
				var columns = select_checked_columns();

			    var tparams = {
			        "columns": columns
			    }

				console.log(JSON.stringify(tparams));

				$.ajax({
					type: 'post',
					url: '<?php echo BASE_API_URL;?>' + '/api/normalize/select_columns/<?php echo $_SESSION['project_id'];?>',
					data: JSON.stringify(tparams),
					contentType: "application/json; charset=utf-8",
					traditional: true,
					async: false,
					success: function (result) {
						console.dir(result);

						if(result.error){
							console.log("API error");
							
						}
						else{
			                console.log("success");

			                valid();
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


			$("#bt_generate_sample").click(function(){
				$("#data_all").html("");
				generate_sample();
			});


			treatment();

		});

	</script>






</body>
</html>
