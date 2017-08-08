<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_normalized_projects_html($id, $normalized_projects)
{
    $html = '<table class="table table-responsive table-condensed table-striped" id="'.$id.'">';

    $html.= '<thead><tr><th></th><th>Nom du projet</th><th>Nom du fichier</th></tr></thead>';
    $html.= '<tbody>';

    $cpt_valid_projects = 0;

    foreach ($normalized_projects as $project){
        $project_id = $project['project_id'];
        $display_name = $project['display_name'];
        $description = $project['description'];
        $file_name = $project['file'];

        // Si normalisation effectuée entièrement :
        if($project['steps_by_filename'][$file_name]['concat_with_init']){
            $cpt_valid_projects ++;

            $html.= '<tr>';
            $html.= '<td>';
            $html.= '<input type="checkbox" class="'.$id.' chk_'.$id.'" value="'.$project_id.'" onclick="">';
            $html.= '</td>';
            $html.= '<td>'.$display_name.'</td>';
            $html.= '<td>'.$file_name.'</td>';
            $html.= '</tr>';
        }

    }
    $html.= '</tbody>';
    $html.= '</table>';

    if($cpt_valid_projects > 0){
        echo $html;
        ?>
        <script type="text/javascript">
            $("#<?php echo $id;?>").DataTable({
                                    "language": {
                                       "paginate": {
                                            "next":       "<span class='glyphicon glyphicon-triangle-right'></span>",
                                            "previous":   "<span class='glyphicon glyphicon-triangle-left'></span>"
                                        },
                                        "search":         "Rechercher:",
                                    },
                                    "lengthMenu": [5],
                                    "responsive": true,
                                    "bInfo": false,
                                    "bPaginate": true,
                                    "lengthChange": false
                                });
        </script>
        <?php
    }
}// /get_normalized_projects_html()
?>
<!DOCTYPE html>
<html>
<head>
	<title>Normalisation</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css');?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/style_fu.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/jquery.fileupload.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery.dataTables.min.css');?>">

    <script type="text/javascript" src="<?php echo base_url('assets/jquery-3.2.1.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js');?>"></script>


    <script type="text/javascript" src="<?php echo base_url('assets/jquery.ui.widget.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/jquery.iframe-transport.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.fileupload.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/functions.js');?>"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/project_link_step1_init.js');?>"></script>

    <style type="text/css">
        #result, #msg_danger, #create_project_ok, #upload_file_progress, #report{
            /*On masque par défaut*/
            display: none;
        }
        #show_report_ok, #upload_file_ok, #check_file_ok{
            visibility: hidden;
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
                        echo "<li><a href='".base_url("index.php/User/login/link")."'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span>&nbsp;&nbsp;S'identifier</a></li>";
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
            <a href="#" class="active">Sélection des fichiers</a>
            <a href="#" class="todo">Etape 2</a>
            <a href="#" class="todo">Etape 3</a>
            <a href="#" class="todo">Etape 4 </a>
            <a href="#" class="todo">Téléchargements</a>
        </div>
    </div>

<!-- Message box -->
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger my_hidden" id="msg_danger"></div>
        </div>
    </div>
    <!-- / Message box -->

    <div class="well">
    	<h1>Jointure de fichiers</h1>
        <p>
            Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. 
        </p>
    </div>

        <h2>
            <span class="glyphicon glyphicon-triangle-right"></span>
            Commencer un projet de jointure
        </h2>
    <div class="well">
        <form class="form-horizontal" name="form_project" id="form_project" method="post">
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
        </form>
    </div>

    <div class="well">
        <h2>
            <span class="glyphicon glyphicon-file color_src"></span>
            Fichier "source"
        </h2>
        <div>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>

        <form class="form-horizontal" name="form_src_file" id="form_src_file" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-1 text-right">
                    <h3 class="hover_new_file_src_target">
                        <span class="glyphicon glyphicon-ok"></span>
                    </h3>
                </div>
                <div class="col-md-8 hover_new_file_src" id="bt_new_file_src">
                    <div>
                        <h3>Nouveau fichier</h3>
                        Tout nouveau fichier devra suivre au préalable un processus de normalisation afin de pouvoir être utilisé dans un projet de jointure.
                        La normalisation rendra la jointure plus efficace. (<a href="#">Qu'est-ce que la normalisation ?</a>)
                    </div>
                </div>
                <div class="col-md-3 hover_new_file_src">
                    <div class="text-center" style="margin-top: 60px;">
                        <span class="btn btn-success2 btn-xs fileinput-button btn_width">
                            <span>Nouveau fichier</span>
                            <input id="fileupload_src" type="file" name="file_src_no_nrz">
                        </span>

                        <span id="file_name_src"></span>
                        <button id="envoyer_src" style="display: none;"></button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1 text-right">
                    <h3 class="hover_exist_file_src_target">
                        <span class="glyphicon glyphicon-ok"></span>
                    </h3>
                </div>
                <?php
                if(!isset($_SESSION['user'])){
                ?>
                <div class="col-md-8 hover_exist_file_src" id="bt_exist_file_src">
                <?php
                }
                else{
                ?>
                <div class="col-md-11 hover_exist_file_src" id="bt_exist_file_src">
                <?php
                }
                ?>
                    <div>
                        <h3>Fichier déjà normalisé</h3>
                        Si vous possédez un compte et que vous avez déjà normalisé le fichier souhaité, vous avez la possibilité de le sélectionner. Seuls les fichiers entièrement normalisés sont disponibles.
                    </div>
                </div>
                <?php
                if(!isset($_SESSION['user'])){
                ?>
                <div class="col-md-3 hover_exist_file_src" style="margin-top: 60px;">
                    <div class="text-center">
                        <a  class="btn btn-xs btn-success2 btn_width" 
                            href="<?php echo base_url('index.php/User/login/link');?>">
                            <span class="glyphicon glyphicon-lock"></span>
                            M'identifier
                        </a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <?php
            if(isset($_SESSION['user'])){
                echo '<div class="row"><div class="col-md-offset-1 col-md-11 hover_exist_file_src">';
                get_normalized_projects_html("normalized_projects_src", $normalized_projects);
                echo '</div></div>';
            }
            ?>
        </form>
    </div><!-- /well-->

    <div class="well">
        <h2>
            <span class="glyphicon glyphicon-file color_ref"></span>
            Fichier "référentiel"
        </h2>
        <div>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>


        <form class="form-horizontal" name="form_ref_file" id="form_ref_file" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-1">
                    <h3 class="hover_new_file_ref_target">
                        <span class="glyphicon glyphicon-ok"></span>
                    </h3>
                </div>
                <div class="col-md-8" id="bt_new_file_ref">
                    <div>
                        <h3>Nouveau fichier</h3>
                        Tout nouveau fichier devra suivre au préalable un processus de normalisation afin de pouvoir être utilisé dans un projet de jointure.
                        La normalisation rendra la jointure plus efficace. (<a href="#">Qu'est-ce que la normalisation ?</a>)
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center" style="margin-top: 60px;">
                        <span class="btn btn-success2 btn-xs fileinput-button btn_width">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Nouveau fichier</span>
                            <input id="fileupload_ref" type="file" name="file_ref_no_nrz">
                        </span>

                        <span id="file_name_ref"></span>
                        <button id="envoyer_ref" style="display: none;"></button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <h3 class="hover_exist_file_ref_target">
                        <span class="glyphicon glyphicon-ok"></span>
                    </h3>
                </div>
                <?php
                if(!isset($_SESSION['user'])){
                ?>
                <div class="col-md-8" id="bt_exist_file_ref">
                <?php
                }
                else{
                ?>
                <div class="col-md-11" id="bt_exist_file_ref">
                <?php
                }
                ?>
                    <div>
                        <h3>Fichier déjà normalisé</h3>
                        Si vous possédez un compte et que vous avez déjà normalisé le fichier souhaité, vous avez la possibilité de le sélectionner. Seuls les fichiers entièrement normalisés sont disponibles.
                    </div>
                </div>
                <?php
                if(!isset($_SESSION['user'])){
                ?>
                <div class="col-md-3" style="margin-top: 60px;">
                    <div class="text-center">
                        <a  class="btn btn-xs btn-success2 btn_width" 
                            href="<?php echo base_url('index.php/User/login/link');?>">
                            <span class="glyphicon glyphicon-lock"></span>
                            M'identifier
                        </a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <?php
            if(isset($_SESSION['user'])){
                echo '<div class="row"><div class="col-md-offset-1 col-md-11">';
                get_normalized_projects_html("normalized_projects_ref", $normalized_projects);
                echo '</div></div>';
            }
            ?>
            <div class="row">
                <div class="col-md-1">
                    <h3 class="hover_exist_ref_target">
                        <span class="glyphicon glyphicon-ok"></span>
                    </h3>
                </div>
                <div class="col-md-8">
                    <div>
                        <h3>Référentiels internes</h3>
                        Vous avez la possibilité d'utiliser des référentiels publiques. Ces référentiels ont déjà été normalizés. Une description de leur contenu est disponible pour chacun d'entre eux.
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center" style="margin-top: 60px;">
                        <a  class="btn btn-xs btn-success2 btn_width" 
                            href="#">
                            <span class="glyphicon glyphicon-list-alt"></span>
                            Choisir un référentiel interne
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- /well-->





    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn-success" id="bt_new_project" style="width: 300px;">Créer le projet >></button>
        </div>
    </div>

</div><!--/container-->


<!-- Modal des référentiels internes-->
<div class="modal fade" id="modal_ref" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<div class="container" id="result">
   

</div><!--/container-->







<div id="files" class="files"></div>


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
            data: 'project_id=' + project_id + '&project_type=link',
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

        function save_id_normalized_project(file_role, project_id) {
            console.log("save_id_normalized_project");
            console.log(file_role+"/"+project_id);

            var tparams = {
                "file_role": file_role,
                "project_id": project_id
            }

            $.ajax({
                type: 'post',
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                url: '<?php echo BASE_API_URL;?>' + '/api/link/select_file/' + link_project_id,
                data: JSON.stringify(tparams),
                async: false,
                success: function (result) {

                    if(result.error){
                        console.log("API error - select_file");
                        console.log(result.error);
                    }
                    else{
                        console.log("success - select_file");
                        console.dir(result);
                    }
                },
                error: function (result, status, error){
                    console.log("error - select_file");
                    console.log(result);
                    err = true;
                }
            });// /ajax - select_file
        }

        function treatment() {
            console.log("treatment");
            // desactivation du bouton
            $("#bt_new_project").prop("disabled", true);

            // Récupération des valeurs
            var project_name = $("#project_name").val();
            var project_description = $("#project_description").val();

            // Controles ----------------------
                // Le champ project_name doit être renseigné
                if(project_name == ""){
                    console.log("project_name not defined");
                    // Message utilisateur
                    my_errors("show", "project_name_undefined");

                    return false;
                }

                // TODO : Tester la sélection des fichiers


            // /Controles ----------------------
            
//            $(".fileinput-button").attr("disabled", "disabled");

            // Appels API ----------------------
                $("#result").fadeToggle();

                // creation du projet
                var tparams = {
                    "url": "/api/new/link",
                    "params": {
                        "display_name": project_name,
                        "description": project_description,
                        "internal": false
                    }
                }

                $.ajax({
                    type: 'post',
                    url: '<?php echo BASE_API_URL;?>' + tparams["url"],
                    data: JSON.stringify(tparams["params"]),
                    contentType: "application/json; charset=utf-8",
                    traditional: true,
                    async: false,
                    success: function (result) {
                        if(result.error){
                            console.log("API error - new/link");
                        }
                        else{
                            console.log("success - new/link");

                            // Récupération de l'identifiant projet
                            //project_id = result.project_id;
                            link_project_id = result.project_id;
                            console.log("project_id" + link_project_id);

                            var result_save = "";
                        
                            console.log("treatment/save_session_synch");
                            result_save = save_session_sync("project_id", link_project_id);
                            
                            // Sauvegarde du projet bdd
                            console.log("treatment/save_project_synch");
                            save_project_sync(link_project_id);

//                            $("#create_project_ok").slideToggle();
                        }
                        console.dir(result);
                    },
                    error: function (result, status, error){
                        console.log("error - new/link");
                        console.log(result);
                    }
                });// /ajax


                // Ajout des projets de normalisation
                save_id_normalized_project("source", "8d2b9a1ecbe4aceb4bd0da0e1c850df5");
                save_id_normalized_project("ref", "3f02e6ca7b837508c9acbfb15b3a9557");
               
                
                // Traitement du fichier source :
/*
                    si nouveau
                        creation du projet de normalisation + upload du fichier source
                    sinon si existant
                        recupération de l identifiant du projet de normalisation
                        
                    enregistrement du projet de normalisation dans le projet de link
*/

                // traitement du fichier de referentiel
/* 
                    si nouveau
                        creation du projet de normalisation + upload du fichier referentiel
                    sinon si referentiel interne ou referentiel user
                        recupération de l identifiant du projet de normalisation

                    enregistrement du projet de normalisation dans le projet de link
*/

                //appel du controller
                valid_project();



/*
                // Envoi du fichier sur le serveur
                url = 'http://127.0.0.1:5000/api/normalize/upload/' + project_id;

                console.log("1:" + url)
                $('#fileupload').fileupload(
                    'option',
                    'url',
                    url
                );

                $("#envoyer").click();
*/
            // /Appels API ----------------------


		}


        function valid_project(){
            // MAJ du statut

            // Appel de l'étape suivante
            window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + link_project_id;
            
        }



		// Init - Ready
		$(function() {

            $("#bt_new_project").click(function(e){
                console.log("bt_new_project");
                e.preventDefault();

                treatment();

            });


            $("#bt_modal_ref").click(function(){
                $('#modal_ref').modal('show');
            });



            $(".fileinput-button").click(function(){
                $(".fileinput-button").prop("disabled", true);

                $("#bt_normalizer").prop("disabled", false);
            });


/*

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

*/

		});

	</script>



</body>
</html>
