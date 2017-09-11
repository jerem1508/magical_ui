
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px;">
    <div class="text-center">
        <div class="breadcrumb flat">
            <!--<a href="#" class="done">Sélection du fichier</a>-->
            <a href="#" class="active">Sélection du fichier</a>
            <a href="#" class="todo">Sélection des colonnes</a>
            <a href="#" class="todo">Valeurs manquantes</a>
            <a href="#" class="todo">Détection des types</a>
            <a href="#" class="todo">Téléchargement</a>
        </div>
    </div>

    <div class="well">
        <h1>Normalisation d'un fichier</h1>
        <p>
            Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. 
        </p>
    </div>

	<form class="form-horizontal" name="form1" id="form1" method="post" enctype="multipart/form-data">
    <div class="well">
        <h2 style="display: inline;">
            <span class="step_numbers">1</span>
            .Identité du projet
        </h2>
			<div class="form-group">
				<label for="project_name" class="col-sm-2 control-label">Nom du projet *</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="project_name" name="project_name" placeholder="Nom du projet" value="Projet_1">
				</div>
			</div>
			<div class="form-group">
				<label for="project_description" class="col-sm-2 control-label">Description du projet</label>
				<div class="col-sm-10">
					<textarea class="form-control" id="project_description" name="project_description" rows="3"></textarea>
				</div>
			</div>
    </div>

    <div class="well">
        <h2 style="display: inline;">
            <span class="step_numbers">2</span>
            .Sélection du fichier à normaliser
        </h2>
        <div class="row">
            <div class="col-xs-9">
                Choisissez le fichier que vous voulez transformer. Celui ci peut être au format csv (séparateurs "," ou ";") ou au format excel (xls ou xlsx). La première ligne du fichier doit contenir l'entête. Nous limitons actuellement les fichiers utilisateurs à 1M de lignes.
		    
		Dans le cas de fichiers Excel, seule la première feuille sera prise en compte. Les données doivent être sous forme de tableau disposé en haut à gauche du fichier. La première ligne du fichier est supposée contenir l'entête. Enfin les formules ne seront pas évaluées et seront considérées comme du texte.
		    
		NB: Nous recommandons l'utilisation du format csv (séparteur ",") et l'encodage UTF-8 pour le stockage de vos données tabulaires sous forme de fichiers. Ceux-ci constituent des formats internationnaux et libres de droits.
            </div>
            <div class="col-xs-3 text-center">
                <span class="btn btn-default btn-xl fileinput-button btn_2_3">
                    <h4 class="glyphicon glyphicon-plus"></h4>
                    <br>
                    <h4>Nouveau</h4>
                    <input id="fileupload" type="file" name="file">
                </span> 
                <span id="file_name"></span>
                <button id="envoyer" style="display: none;"></button>
            </div>
        </div><!-- / row-->
    </div><!-- /well-->

    <!-- Message box -->
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger my_hidden" id="msg_danger"></div>
        </div>
    </div>
    <!-- / Message box -->

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-12 text-right">
            <button class="btn btn btn-success" id="bt_normalizer" disabled="disabled">Créer le projet</button>
        </div>
    </div>
    </form>
</div><!--/container-->


<div class="container" id="result">
    <div class="well" id="steps">
        <ul>
            <li>
                Création du projet <span id="create_project_ok" class="glyphicon glyphicon-ok check_ok"></span>
            </li>
            <li>
                Envoi du fichier sur le serveur <span id="upload_file_ok" class="glyphicon glyphicon-ok check_ok"></span>
                <div id="progress" class="progress" style="height: 5px;margin-bottom: 5px;">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
            </li>
            <li>
                Analyse du fichier <span id="check_file_ok" class="glyphicon glyphicon-ok check_ok"></span>
            </li>
            <li>
                Affichage du rapport <span id="show_report_ok" class="glyphicon glyphicon-ok check_ok"></span>
            </li>
        </ul>
    </div>
    <div class="well">
        <div id="report">
            <h2>Rapport : </h2>
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="<?php echo base_url('assets/img/report.png');?>" style="height: 150px;">
                </div>
                <div class="col-md-3">
                    <div class="panel panel-info">
                      <div class="panel-body text-center">
                        <h2 style="display: inline;"><span id="nrows"></span></h2> <i>lignes</i>
                      </div>
                    </div>
                    <div class="panel panel-info">
                      <div class="panel-body text-center">
                        <h2 style="display: inline;"><span id="ncols"></span></h2> <i>colonnes</i>
                      </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="panel panel-info">
                      <div class="panel-body text-center">
                        <table class="table">
                            <tr>
                                <th></th>
                                <th class="text-center">Initiale</th>
                                <th class="text-center">Finale</th>
                            </tr>
                            <tr>
                                <th>Séparateur</th>
                                <td id="separator"></td>
                                <td>,</td>
                            </tr>
                            <tr>
                                <th>Encodage</th>
                                <td id="encoding"></td>
                                <td>UTF-8</td>
                            </tr>
                        </table>
                      </div>
                    </div>
                </div>
            </div><!-- /row-->
        </div><!--/report-->
    </div><!-- /well-->
    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn btn-success" id="bt_next">Etape suivante : Sélection des colonnes >></button>
        </div>
    </div><!-- /row-->

</div><!--/container-->


<div id="files" class="files"></div>

        <?php 
            if(isset($this->session->project_type)){
				$project_type = $this->session->project_type;
			}
		?>


	<script type="text/javascript">

var err = false;

		function my_errors(direction, my_error) {
			var div_error = $("#msg_danger");
			console.log(my_error);
			switch (my_error){
				case "project_name_undefined":
					div_error.html("<strong>Le nom du projet doit être renseigné.</strong>");
				break;
                case "api_new_error":
                    div_error.html("<strong>Création du projet impossible.</strong>");
                break;
			}

            if(div_error.hasClass("my_hidden")){
                div_error.removeClass("my_hidden")
                         .addClass("my_show")
                         .slideToggle("slow");
            }
		}



        function save_project_sync(project_id) {
            $.ajax({    
                type: 'post',
                url: '<?php echo base_url('index.php/Save_ajax/project');?>',
                data: 'project_id=' + project_id + '&project_type=normalize',
                async: false,
                success: function (result) {
                    console.log("result : ",result);
                },
                error: function (result, status, error){
                    console.log(result);
                    console.log(status);
                    console.log(error);
                    return false;
                }
            });
        }


		function save_session_sync(name, value) {
			$.ajax({	
				type: 'post',
				url: '<?php echo base_url('index.php/Save_ajax/session');?>',
				data: 'name=' + name + '&val=' + value,
				//contentType: "application/json; charset=utf-8",
				//traditional: true,
				async: false,
				success: function (result) {
					console.log(result);
		
					if(!result){
						console.log("sauvegarde en sesion KO");
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
		}



		function call_api_sync(tparams, err) {
			console.log("call_api");console.dir(tparams);

			$.ajax({
				type: 'post',
				url: '<?php echo BASE_API_URL;?>' + tparams["url"],
				data: JSON.stringify(tparams["params"]),
				contentType: "application/json; charset=utf-8",
				traditional: true,
				async: false,
				success: function (result) {
					console.dir(result);

					if(result.error){
						console.log("API error");
						return false;
					}
					else{
                        console.log("success");

                        // Récupération de l'identifiant projet
                        project_id = result.project_id;
                        console.log("project_id" + project_id);

                        var result_save = "";
                    
                        console.log("treatment/save_session_synch");
                        result_save = save_session_sync("project_id", result.project_id);
                        
                        // Sauvegarde du projet
                        console.log("treatment/save_project_synch");
                        save_project_sync(result.project_id);

                        $("#create_project_ok").slideToggle();
                    }
                },
                error: function (result, status, error){
                    console.log(result);
                    console.log(status);
                    console.log(error);
                    err = true;
                }
            });// /ajax

        }


        function call_api_upload(form, project_id) {
            $.ajax({
                url: '<?php echo BASE_API_URL;?>' + '/api/normalize/upload/' + project_id,
                type: "POST",
                data: form,
                crossDomain: true,
                processData: false,
                contentType: false,
                async: true, // TODO: check this (to avoid next page before uplload)
                success: function(result){
                    file_name = form.get('file').name;
                    console.log("Uploaded file ".concat(file_name));
                },
                error: function(er){
                    console.log(er.statusText.concat(" (error ", er.status, ")"));
                }
            });
        }



        function treatment(project_type) {
            console.log("treatment");
            // desactivation du bouton
            $("#bt_normalizer").prop("disabled", true);

            // Controles ----------------------
                // Récupération des valeurs
                var project_name = $("#project_name").val();
                var project_description = $("#project_description").val();

                // Le champ project_name doit être renseigné
                if(project_name == ""){
                    console.log("project_name not defined");
                    // Message utilisateur
                    my_errors("show", "project_name_undefined");

                    return false;
                }

                // TODO : Tester la sélection du fichier

            // /Controles ----------------------
            
            $(".fileinput-button").attr("disabled", "disabled");

            // Appels API ----------------------
                $("#result").fadeToggle();

                // creation du projet
                var tparams = {
                    "url": "/api/new/normalize",
                    "params": {
                        "display_name": project_name,
                        "description": project_description,
                        "internal": false
                    }
                }
                console.log("treatment/call_api_synch");
                err = call_api_sync(tparams, err);
                if(err == true){console.log("Erreur de creation du projet");return false;}


                // Envoi du fichier sur le serveur
                url = '<?php echo BASE_API_URL;?>/api/normalize/upload/' + project_id;

                $('#fileupload').fileupload(
                    'option',
                    'url',
                    url
                );

                $("#envoyer").click();

            // /Appels API ----------------------


		}


        function valid_project(){
            // MAJ du statut
            

            // Appel de l'étape suivante
            window.location.href = "<?php echo base_url('index.php/Project/save_step1_init/');?>" + project_id;
            
        }


        // Init - Ready
        $(function() {
            
            //$("body").css("height", $(window).height()) ;
            
            // Actions sur clics
            url = "vide";

            $("#bt_normalizer").click(function(e){
                e.preventDefault();
                var project_id = "";
                treatment("normalizer");
            });


            $(".fileinput-button").click(function(){
                $(".fileinput-button").prop("disabled", true);

                $("#bt_normalizer").prop("disabled", false);
            });


			$("#bt_next").click(function(e){
				valid_project();// maj du statut + affichage de l'etape suivante
			});


            $('#fileupload').fileupload({
                url: url,
                type:"POST",
                autoUpload: false,
                add: function (e, data) {
                    $('#file_name').html(data.files[0].name);
                    console.log(data);
                    data.context = $('#envoyer')
                        .click(function (e) {
                             e.preventDefault();
                             console.log("2:" + url)
                            $('#progress .progress-bar').css('visibility', 'visible');
                            data.submit();
                        });
                },
                done: function (e, data) {
                    console.log("upload done");
                    console.log("data");
                    console.log(data);

                    $('#progress').css('display', 'none');
                    $('#upload_file_ok').css('visibility', 'visible');
                    $('#check_file_ok').css('visibility', 'visible');

                    var run_info = data.result.run_info;

                    $('#ncols').html(run_info.ncols);
                    $('#nrows').html(run_info.nrows);
                    $('#separator').html(run_info.sep);
                    $('#encoding').html(run_info.encoding);

                    $('#report').css('display', 'inherit');
                    $('#show_report_ok').css('visibility', 'visible');

                    go_to('report');
                    
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                    console.log("upload progressall");
                },
                fail: function (e, data) {
                    $('#progress .progress-bar').css(
                        'background-color', 'red'
                    );
                    console.log("upload fail");
                    console.dir(data);
                }
            }).prop('disabled', !$.support.fileInput)
              .parent().addClass($.support.fileInput ? undefined : 'disabled');

		});

	</script>



</body>
</html>
