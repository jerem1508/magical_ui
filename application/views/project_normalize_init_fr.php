<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid intro">
<!--
    <div class="text-center">
        <div class="breadcrumb flat">
            <a href="#" class="active">Sélection du fichier</a>
            <a href="#" class="todo">Sélection des colonnes</a>
            <a href="#" class="todo">Valeurs manquantes</a>
            <a href="#" class="todo">Détection des types</a>
            <a href="#" class="todo">Téléchargement</a>
        </div>
    </div>
-->
    <div class="row">
        <div class="col-md-12">
            <h1>Normalisation d'un fichier</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 ">
            <div class="page_explain">
                La normalisation d'un fichier à pour but de le nettoyer. Elle améliore grandement le rendement de la jointure magique entre 2 fichiers.
                <br>
                <br>
                <b>4 étapes seront nécessaires à la normalisation de votre fichier :</b>
                <ol>
                    <li>La sélection des colonnes à normaliser</li>
                    <li>La recherche des valeurs manquantes</li>
                    <li>La détection des types de chaque colonne sélectionnée</li>
                    <li>Le téléchargement du fichier normalisé</li>
                </ol>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">

                <div class="col-lg-9">
<!--
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

                      <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                      </ol>


                      <div class="carousel-inner" role="listbox">
                        <div class="item active">
                          <img src="..." alt="...">
                          <div class="carousel-caption">
                            ...
                          </div>
                        </div>
                        <div class="item">
                          <img src="..." alt="...">
                          <div class="carousel-caption">
                            ...
                          </div>
                        </div>
                        ...
                      </div>


                      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
-->
                </div>
                <div class="col-lg-3 text-right">
                    <span class="btn btn-default btn-xl fileinput-button btn_2_3" onclick="javascript:introJs().setOption('showBullets', false).start();">
                        <img src="<?php echo base_url('assets/img/laptop.svg');?>"><br>Aide
                    </span>
                </div>
            </div>
        </div><!-- /col-lg-6-->
    </div><!-- / row-->
</div>

<form class="form-horizontal" name="form1" id="form1" method="post" enctype="multipart/form-data">

<div class="container-fluid" style="margin-top: 0px;">
    <div class="row  background_1">
        <div class="col-md-6">
            <div>
                <h2 style="display: inline;">
                    <span class="step_numbers">1</span>
                    Identité du projet
                </h2>
                <div class="form-group" data-intro="Choisissez un nom pour vous y retrouver plus facilement">
                	<label for="project_name" class="col-sm-3 control-label">Nom du projet *</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control" id="project_name" name="project_name" placeholder="Nom du projet" value="Projet_1">
                	</div>
                </div>
                <div class="form-group" data-intro="Ajoutez une description optionnelle">
                	<label for="project_description" class="col-sm-3 control-label">Description du projet</label>
                	<div class="col-sm-9">
                		<textarea class="form-control" id="project_description" name="project_description" rows="3"></textarea>
                	</div>
                </div>
                <?php
                if(@$_SESSION['user']['status'] == '99'){
                    ?>
                    <div class="form-group">
                        <label for="public" class="col-sm-3 control-label">Référentiel public</label>
                        <div class="col-sm-9">
                            <input type="checkbox" id="chk_public">
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="chk_cgu"> En cochant cette case vous acceptez les <a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">conditions générales d'utilisation</a>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="chk_reuse" checked> En cochant cette case vous acceptez que vos données soient utilisées pour l'amélioration de l'application
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div data-intro="Uploadez un fichier à transformer">
                <h2 style="display: inline;">
                    <span class="step_numbers">2</span>
                    Sélection du fichier à normaliser
                </h2>
                <div class="row">
                    <div class="col-xs-9">
                        Choisissez le fichier que vous voulez transformer. Celui ci peut être au format <b>CSV</b> (séparateurs "," ou ";") ou au format <b>Excel</b> (xls ou xlsx). <b>La première ligne du fichier doit contenir l'entête</b>. Nous limitons actuellement les fichiers utilisateurs à <b>1 million de lignes</b>.
                        <br>
                        <br>
                        Dans le cas de fichiers Excel, seule la première feuille sera prise en compte. Les données doivent être sous forme de tableau disposé en haut à gauche du fichier. La première ligne du fichier est supposée contenir l'entête. Enfin les formules ne seront pas évaluées et seront considérées comme du texte.
                        <br>
                        <br>
                        <b>
                        NB: Nous recommandons l'utilisation du format CSV (séparteur ",") et l'encodage UTF-8 pour le stockage de vos données tabulaires sous forme de fichiers. Ceux-ci constituent des formats internationnaux et libres de droits.
                        </b>
                    </div>
                    <div class="col-xs-3 text-right">
                        <span class="btn btn-default btn-xl fileinput-button btn_2_3">
                            <h4 class="glyphicon glyphicon-plus"></h4>
                            <br>
                            <h4>Nouveau</h4>
                            <input id="fileupload" type="file" name="file">
                        </span>
                        <br>
                        <span id="file_name"></span>
                        <button id="envoyer" style="display: none;"></button>
                    </div>
                </div><!-- / row-->
            </div><!-- /well-->

        </div>
    </div>
</div>

<div class="container-fluid  background_1" style="padding-bottom: 20px;">
    <!-- Message box -->
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger my_hidden" id="msg_danger"></div>
        </div>
    </div>
    <!-- / Message box -->
    <div class="row" style="margin-bottom: 0px;">
        <div class="col-md-12 text-right">
            <button class="btn btn btn-success" id="bt_normalizer" disabled="disabled">Créer le projet</button>
        </div>
    </div>
</div><!--/container-->

</form>

<div class="container-fluid background_2" id="result">

    <div>
        <div id="report">
            <h2>
                <i class="fa fa-flag-checkered" aria-hidden="true"></i>
                Rapport :
            </h2>
            <div class="row">
                <div class="col-md-3">
                    <!--<img src="<?php echo base_url('assets/img/report.png');?>" style="height: 150px;">-->
                    <div id="steps">
                        <ul>
                            <li>
                                Création du projet <span id="create_project_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </li>
                            <li>
                                Envoi du fichier sur le serveur <span id="upload_file_ok" class="glyphicon glyphicon-ok check_ok"></span>
                                <div id="progress" class="progress" style="margin-bottom: 5px;">
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


<!-- Modal -->
<div class="modal fade" id="modal_cgu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #262626">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color: #ddd">Erreur !</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-1">
                <h2 style="margin-top:0;color: #E00612;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></h2>
            </div>
            <div class="col-xs-11">
                Vous devez valider les <a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">conditions générales d'utilisation</a> afin de pouvoir commencer la création d'un projet.
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

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


    function unset_session(name) {
        $.ajax({
            type: 'post',
            url: '<?php echo base_url('index.php/Save_ajax/unsession');?>',
            data: 'name=' + name,
            async: false,
            success: function (result) {
                console.log(result);
                if(!result){
                    console.log("Suppression en session KO");
                    return false;
                }
                else{
                    console.log("Suppression en session OK");
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


    function call_api_sync(tparams, err) {
    	console.log("call_api_sync");
        console.dir("tparams:");
        console.dir(tparams);

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
                    console.log("Return error");
                    return false;
                }
                else{
                    console.log("call_api_sync - success");

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
    			console.log("call_api_sync - API error");
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

            if(public){
                if(project_description == ''){
                    alert("Vous devez saisir une description pour un référentiel public !");
                    $("#bt_normalizer").prop("disabled", false);
                    return;
                }
            }

            // creation du projet
            var tparams = {
                "url": "/api/new/normalize",
                "params": {
                    "display_name": project_name,
                    "description": project_description,
                    "public": public
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
        // Appel de l'étape suivante
        ///window.location.href = "<?php echo base_url('index.php/Project/save_step1_init/');?>" + project_id;
        window.location.href = "<?php echo base_url('index.php/Project/normalize/');?>" + project_id;
    }


    // Init - Ready
    $(function() {

        // Suppression de la variable de session link_project_id si elle existe
        // cette variable est renseignée uniquement lorsque l'on vient d'un projet de LINK
        unset_session("link_project_id");

        //$("body").css("height", $(window).height()) ;
        public = false;

        // Actions sur clics
        url = "vide";

        $("#bt_normalizer").click(function(e){
            e.preventDefault();
            //  test CGU
            if($("#chk_cgu").is(':checked')){
                var project_id = "";
                treatment("normalizer");
            }
            else{
                // Affichage de la modale d'erreur CGU
                $("#modal_cgu").modal("show");
            }
        });

        $("#chk_public").change(function() {
            public = $("#chk_public").is(':checked');
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

                //$('#progress').css('display', 'none');
                $('#upload_file_ok').css('visibility', 'visible');
                $('#check_file_ok').css('visibility', 'visible');

                var run_info = data.result.run_info;

                $('#ncols').html(run_info.ncols);
                $('#nrows').html(run_info.nrows);
                $('#separator').html(run_info.sep);
                $('#encoding').html(run_info.encoding);

                $('#report').css('display', 'inherit');
                $('#show_report_ok').css('visibility', 'visible');

                $("#bt_next").css("visibility", "visible");

                go_to('report');
            },
            progressall: function (e, data) {
                console.log("upload progressall");
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css('visibility', 'visible');
                $('#progress .progress-bar').css('width', progress + '%');
            },
            fail: function (e, data) {
                console.log("upload fail");
                console.log(data);
                $('#progress .progress-bar').css('background-color', 'red');
            }
        }).prop('disabled', !$.support.fileInput)
          .parent().addClass($.support.fileInput ? undefined : 'disabled');


        $('#chk_public').bootstrapToggle({
          on: 'Oui',
          off: 'Non',
          onstyle: 'success2',
          offstyle: 'default',
          size: 'small'
        });
    });

</script>
</body>
</html>
