<?php
if(isset($this->session->project_type)){
	$project_type = $this->session->project_type;
}
?>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid background_1" style="margin-left:20px;margin-right:20px;">
	<div class="row">
		<div class="col-sm-11">
			<!--<h2 class="page_title"><span id="project_name"></span> : <i>Sélection des colonnes</i></h2>-->
			<span class="cl_filename">
				<i class="fa fa-file-text" aria-hidden="true"></i>
				Traitement du fichier <span id="filename" class="file"></span>
			</span>
		</div>
		<div class="col-sm-1 text-right">
            <button id="bt_help" class="btn btn-success3">
                Aide
            </button>
		</div>
	</div>

	<div class="row background_1">
		<div class="col-xs-9" style="border-right: 3px dotted #aaa;">
			<div class="row">
				<div class="col-md-8">
					<h3>Extrait aléatoire des données</h3>
				</div>
				<div class="col-md-4 text-right">
					<h3>
					<button type="button" class="btn btn-xs btn-success2" id="bt_generate_sample"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Regénérer</button>
					</h3>
				</div>
			</div>
			<div id="data_all" style="overflow-x:scroll"></div>
		</div>
		<div class="col-xs-3">
			<h3>Colonnes à sélectionner</h3>
			<div id="result" data-intro="Sélectionnez les colonnes à nettoyer" style="overflow-y:scroll; height: 400px"></div>
		</div>
	</div>

</div><!--/container-->

<div class="container-fluid background_1" style="padding-top: 20px;padding-bottom: 20px">
    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn btn-success" id="bt_next">Etape suivante : Détection des valeurs manquantes >></button>
        </div>
    </div><!-- /row-->
</div><!--/container-->


<div class="modal fade" tabindex="-1" role="dialog" id="modal_help">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
            <i class="fa fa-question-circle"></i>
            Aide
        </h4>
      </div>
      <div class="modal-body">
        <div class="page_explain">
              <b>
                  Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
			  </b>
      	</div>
		<h3>sfkjsl skjds</h3>
		Sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.

</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success3" data-dismiss="modal" onclick="javascript:introJs().setOption('showBullets', false).start();">Lancer le didacticiel</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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
		    	"module_name": "add_selected_columns",
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
		  // console.log( index + ": " + $( this ).val() );
		  $(this).prop('checked', true);
		});
	}// /select_all()


	function unselect_all(){
		$( ".columns" ).each(function( index ) {
		  // console.log( index + ": " + $( this ).val() );
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


	function treatment() {
		console.log("treatment");

		//Recupération des colonnes
        columns = metadata.column_tracker.original;

        var bt = '<button class="btn btn-xs btn-success2 bt_select_all">&nbsp;Tout sélectionner</button>&nbsp;<button class="btn btn-xs btn-warning bt_unselect_all">&nbsp;Tout désélectionner</button>';
        var ch = bt;

		$.each(columns, function( i, name) {
		  ch = ch + "<div class='checkbox'><label><input type='checkbox' class='columns' checked value='" + name + "'>&nbsp;" + name + "</label></div>\n";
		});

		ch = ch + bt;

		$("#result").html(ch);
	} // /treatment


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

	                $("#filename").html(result.file_name);

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

								// Modification de la taille de la DIV des colonnes en fonction de la taille du sample
								var height_sample = $("#data_all").height();
								console.log(height_sample);
								$("#result").css("height", height_sample);
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
	}// / enerate_sample()


	function valid(){
	    // Appel de l'étape suivante
	    //window.location.href = "<?php echo base_url('index.php/Project/replace_mvs/'.$_SESSION['project_id']);?>";
	    window.location.href = "<?php echo base_url('index.php/Project/normalize/'.$_SESSION['project_id']);?>";
	}// /valid()


	function add_actions_buttons() {
		$("#bt_help").click(function(){
	        $('#modal_help').modal('show');
	    });

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

		$(".bt_select_all").click(function(){
			select_all();
		});
		$(".bt_unselect_all").click(function(){
			unselect_all();
		});
	}// /add_actions_buttons()

	// Init - Ready
	$(function() {
		err = false;

		project_id = '<?php echo $_SESSION['project_id'];?>';

		// Métadata du projet
		metadata = get_metadata('normalize', project_id);

		// MAJ du nom du projet
		$("#project_name").html(metadata.display_name);

		// Lancement du traitement
		treatment();

		// Génération du sample
		generate_sample();

		// Ajout des actions boutons
		add_actions_buttons()
	});// /ready

</script>
</body>
</html>
