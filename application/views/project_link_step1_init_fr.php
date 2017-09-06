<?php

function is_completed_step($step_name, $project_steps, $has_mini)
{
    $filename = str_replace('MINI__', '', key($project_steps));

    if($project_steps[$filename]['concat_with_init']==1){
        return true;
    }

    switch ($step_name) {
        case 'INIT':
            return true;
            break;

        case 'add_selected_columns':
        case 'replace_mvs':
        case 'recode_types':
            if($has_mini){
                return $project_steps['MINI__'.$filename][$step_name];
            }
            else{
                return $project_steps[$filename][$step_name];
            }

            break;
        default :
            return false;
    }
}

function get_progress_html($bs_color, $ratio, $step, $project_id)
{
    $html = '<div 
                class="progress-bar progress-bar-'.$bs_color.' step '.$step.'" 
                role="progressbar" 
                aria-valuenow="25" 
                aria-valuemin="0" 
                aria-valuemax="100" 
                data-toggle="tooltip" 
                style="width: '.$ratio.'%;">
            </div>';

    return $html;
}


function get_normalized_projects_html($id, $normalized_projects)
{
    $html = '';

    $tab_steps = ['add_selected_columns', 'replace_mvs', 'recode_types', 'concat_with_init'];
    $nb_steps = count($tab_steps);
    $ratio = 100/$nb_steps;

    foreach ($normalized_projects as $project){
        // Jauge
        $steps_html = '<div class="progress">';
        $found_step_todo = false;
        $step_todo = "";
        foreach ($tab_steps as $step) {
            $bs_color = (is_completed_step($step, $project['steps_by_filename'], $project['has_mini']))?"success2":"warning";
            $steps_html.= get_progress_html($bs_color, $ratio, $step, $project['project_id']);

            if(!$found_step_todo){
                if(!is_completed_step($step, $project['steps_by_filename'], $project['has_mini'])){
                    $step_todo = $step;
                    $found_step_todo = true;
                }
            }
        }
        $steps_html.= '</div>';
        // /Jauge

        // dates
        $timestamp = strtotime($project['created_tmp']);
        $created_date = date('d/m/Y', $timestamp);

        $timestamp = strtotime($project['modified_tmp']);
        $modified_date = date('d/m/Y h:m', $timestamp);
        // /dates

        $html .= '<div class="bloc_project" onclick="select_project(\''.$project['project_id'].'\',\''.$project['display_name'].'\');">';
            $html .= '<div class="row">';
                $html .= '<div class="col-md-1 chk">';
                $html .= '<h3><span class="glyphicon glyphicon-ok"></span></h3>';
                $html .= '</div>';
                $html .= '<div class="col-md-11">';
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= '<h4>'.$project['display_name'].'<h4>';
                        $html .= '</div>';
                    $html .= '</div>';

                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12" style="height: 5px;">';
                            $html .= $steps_html;
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= $project['file'];
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= '<i>'.$project['description'].'</i>';
                        $html .= '</div>';
                    $html .= '</div>';
                    
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= 'Création : '.$created_date;
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= 'Dernière modification : '.$modified_date;
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
            $html .= '<hr>';
        $html .= '</div>';
    }

    echo $html;

}// /get_normalized_projects_html()

?>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid" style="margin-top: 20px;">
    <div class="row">
       <!--
        <div class="col-xs-2">
            <ul class="steps">
                <li class="step active">
                    <div class="title">
                        <span class="glyphicon glyphicon-menu-right"></span>
                        Sélection des fichiers
                    </div>
                    <div>
                        1. Identité du projet                        
                    </div>
                    <div>
                        2. Sélection du fichier "source"
                    </div>
                    <div>
                        3. Sélection du fichier "référentiel"
                    </div>
                </li>
                <li class="step">
                    <div class="title">
                        <span class="glyphicon glyphicon-menu-right"></span>
                        Association des colonnes
                    </div>
                </li>
                <li class="step">
                    <div class="title">
                        <span class="glyphicon glyphicon-menu-right"></span>
                        Apprentissage
                    </div>
                </li>
                <li class="step">
                    <div class="title">
                        <span class="glyphicon glyphicon-menu-right"></span>
                        Traitement
                    </div>
                </li>
                <li class="step">
                    <div class="title">
                        <span class="glyphicon glyphicon-menu-right"></span>
                        Téléchargements
                    </div>
                </li>
            </ul>
        </div>
        -->
        <div class="col-xs-12">
            <div class="well">
            	<h1>Jointure de fichiers</h1>
                <p>
                    Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. 
                </p>
            </div><!-- /well -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="well">
                        <h2 style="display: inline;">
                            <span class="step_numbers">1</span>
                            .Identité du projet
                        </h2>
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
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="well"  style="height: 630px;"">
                        <h2 style="display: inline;">
                            <span class="step_numbers">2</span>
                            .Sélection du fichier "source"
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
                                <div class="col-xs-1 text-right">
                                    <h3 class="hover_new_file_src_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_new_file_src" id="bt_new_file_src">
                                    <div>
                                        <h3>Nouveau fichier</h3>
                                        Tout nouveau fichier devra suivre au préalable un processus de normalisation afin de pouvoir être utilisé dans un projet de jointure.
                                        La normalisation rendra la jointure plus efficace. (<a href="#">Qu'est-ce que la normalisation ?</a>)
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_new_file_src">
                                    <div class="text-center" style="margin-top: 40px;">

                                        <span class="btn btn-default btn-xl fileinput-button btn_2_3">
                                            <h4 class="glyphicon glyphicon-plus"></h4>
                                            <br>
                                            <h4>Nouveau</h4>
                                            <input id="fileupload_src" type="file" name="file">
                                        </span>

                                        <div id="file_name_src"></div>
                                        <button id="envoyer_src" style="display: none;"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-1 text-right">
                                    <h3 class="hover_exist_file_src_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_exist_file_src" id="bt_exist_file_src">
                                    <div>
                                        <h3>Fichier déjà normalisé</h3>
                                        Si vous possédez un compte et que vous avez déjà normalisé le fichier souhaité, vous avez la possibilité de le sélectionner. Seuls les fichiers entièrement normalisés sont disponibles.
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_exist_file_src" style="margin-top: 40px;">
                                    <div class="text-center">
                                    <?php
                                    if(!isset($_SESSION['user'])){
                                    ?>
                                    <a href="<?php echo base_url('index.php/User/login/link');?>">
                                        <span class="glyphicon glyphicon-lock"></span>
                                        M'identifier
                                    </a>
                                    <?php
                                    }
                                    else{
                                    ?>
                                    <a class="btn btn-xs btn-default btn_2_3" id="bt_select_project_src">
                                        <h4 class="glyphicon glyphicon-list-alt"></h4>
                                        <h4>Mes fichiers</h4>
                                    </a>
                                    <div id="src_project_name"></div>
                                    <div id="src_project_id" style="display: none;"></div>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
                <div class="col-xs-6">
                    <div class="well" style="height: 630px;">
                        <h2 style="display: inline;">
                            <span class="step_numbers">3</span>
                            .Sélection du fichier "référentiel"
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
                                <div class="col-xs-1">
                                    <h3 class="hover_new_file_ref_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_new_file_ref" id="bt_new_file_ref">
                                    <div>
                                        <h3>Nouveau fichier</h3>
                                        Tout nouveau fichier devra suivre au préalable un processus de normalisation afin de pouvoir être utilisé dans un projet de jointure.
                                        La normalisation rendra la jointure plus efficace. (<a href="#">Qu'est-ce que la normalisation ?</a>)
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_new_file_ref">
                                    <div class="text-center" style="margin-top: 40px;">
                                        <span class="btn btn-default btn-xl fileinput-button btn_2_3">
                                            <h4 class="glyphicon glyphicon-plus"></h4>
                                            <br>
                                            <h4>Nouveau</h4>
                                            <input id="fileupload_ref" type="file" name="file">
                                        </span>
                                        <span id="file_name_ref"></span>
                                        <button id="envoyer_ref" style="display: none;"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-1">
                                    <h3 class="hover_exist_file_ref_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_exist_file_ref" id="bt_exist_file_ref">
                                    <div>
                                        <h3>Fichier déjà normalisé</h3>
                                        Si vous possédez un compte et que vous avez déjà normalisé le fichier souhaité, vous avez la possibilité de le sélectionner. Seuls les fichiers entièrement normalisés sont disponibles.
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_exist_file_ref" style="margin-top: 40px;">
                                    <div class="text-center">
                                    <?php
                                    if(!isset($_SESSION['user'])){
                                    ?>
                                    <a href="<?php echo base_url('index.php/User/login/link');?>">
                                        <span class="glyphicon glyphicon-lock"></span>
                                        M'identifier
                                    </a>
                                    <?php
                                    }
                                    else{
                                    ?>
                                    <a class="btn btn-xs btn-default btn_2_3" id="bt_select_project_ref">
                                        <h4 class="glyphicon glyphicon-list-alt"></h4>
                                        <h4>Mes fichiers</h4>
                                    </a>
                                    <div id="ref_project_name"></div>
                                    <div id="ref_project_id" style="display: none;"></div>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                </div>
                             </div>
                            <div class="row">
                                <div class="col-xs-1">
                                    <h3 class="hover_exist_ref_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_exist_ref">
                                    <div>
                                        <h3>Référentiels internes</h3>
                                        Vous avez la possibilité d'utiliser des référentiels publiques. Ces référentiels ont déjà été normalizés. Une description de leur contenu est disponible pour chacun d'entre eux.
                                    </div>
                                </div>
                                <div class="col-xs-3 hover_exist_ref">
                                    <div class="text-center" style="margin-top: 40px;">
                                        <a class="btn btn-xs btn-default btn_2_3" id="bt_modal_ref">
                                            <h4 class="glyphicon glyphicon-list-alt"></h4>
                                            <h4>Sélectionner</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /well-->
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-success" id="bt_new_project" style="width: 300px;">Créer le projet >></button>
                </div>
            </div>


            <div class="row" id="result" style="margin-top: 20px;">
                <div class="well" id="steps">
                    <div>
                        <span id="txt_create_merge_project">Création du projet de jointure</span><span id="create_merge_project_ok" class="glyphicon glyphicon-ok check_ok">
                    </div>
                    <div>
                        <span id="txt_init_nrz_src_project">Initialisation du projet de normalisation "SOURCE"</span><span id="init_nrz_src_project_ok" class="glyphicon glyphicon-ok check_ok">
                    </div>
                    <div>
                        <span id="txt_send_src_file">Envoi du fichier "SOURCE" sur le serveur</span><span id="send_src_file_ok" class="glyphicon glyphicon-ok check_ok">
                        <div id="progress_src" class="progress" style="height: 5px;margin-bottom: 5px;width:100%">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                    </div>
                    <div>
                        <span id="txt_init_nrz_ref_project">Initialisation du projet de normalisation "REFERENTIEL"</span><span id="init_nrz_ref_project_ok" class="glyphicon glyphicon-ok check_ok">
                    </div>
                    <div>
                        <span id="txt_send_ref_file">Envoi du fichier "REFERENTIEL" sur le serveur</span><span id="send_ref_file_ok" class="glyphicon glyphicon-ok check_ok">
                        <div id="progress_ref" class="progress" style="height: 5px;margin-bottom: 5px;width:100%">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                    </div>
                    <div>
                        <span id="txt_add_src_nrz_projects">Ajout du projet de normalisation "SOURCE" au projet de jointure</span><span id="add_src_nrz_projects_ok" class="glyphicon glyphicon-ok check_ok">
                    </div>
                    <div>
                        <span id="txt_add_ref_nrz_projects">Ajout du projet de normalisation "REFERENTIEL" au projet de jointure</span><span id="add_ref_nrz_projects_ok" class="glyphicon glyphicon-ok check_ok">
                    </div>
                </div>
            </div><!--/container-->

            <div class="row" id="bloc_bt_next">
                <div class="col-md-12 text-right">
                    <button class="btn btn-success" id="bt_next">Etape suivante : Association des colonnes >></button>
                </div>
            </div>

            <div id="files" class="files"></div>

        </div> <!-- / col-10-->
    </div><!-- / row -->
</div><!--/container-->


<!-- Modal des projets de normalisation de l'utilisateur-->
<div class="modal fade" id="modal_projects" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sélection d'un projet de normalisation</h4>
      </div>
      <div class="modal-body" id="modal_projects_body">
        <?php
            get_normalized_projects_html("normalized_projects_ref", $normalized_projects);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal des référentiels internes-->
<div class="modal fade" id="modal_ref" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sélection d'un référentiel interne</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>




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


    function save_project_sync(project_id, project_type) {
        $.ajax({    
            type: 'post',
            url: '<?php echo base_url('index.php/Save_ajax/project');?>',
            data: 'project_id=' + project_id + '&project_type=' + project_type,
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

                    if(file_role == "source"){
                        $('#txt_add_src_nrz_projects').css('display', 'inline');
                        $('#add_src_nrz_projects_ok').css('display', 'inline');
                    }
                    if(file_role == "ref"){
                        $('#txt_add_ref_nrz_projects').css('display', 'inline');
                        $('#add_ref_nrz_projects_ok').css('display', 'inline');                        
                    }
                }
            },
            error: function (result, status, error){
                console.log("error - select_file");
                console.log(result);
                err = true;
            }
        });// /ajax - select_file
    }


    function add_new_normalize_project_src(tparams) {
        console.log("add_new_normalize_project_src");

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
                }
                else{
                    console.log("success");

                    // Récupération de l'identifiant projet
                    src_project_id = result.project_id;

                    $('#txt_init_nrz_src_project').css('display', 'inline');
                    $('#init_nrz_src_project_ok').css('display', 'inline');
                }
            },
            error: function (result, status, error){
                console.log(result);
                console.log(status);
                console.log(error);
            }
        });// /ajax
    }


    function add_new_normalize_project_ref(tparams) {
        console.log("add_new_normalize_project_ref");

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
                }
                else{
                    console.log("success");

                    // Récupération de l'identifiant projet
                    ref_project_id = result.project_id;
                    
                    //
                    $('#txt_init_nrz_ref_project').css('display', 'inline');
                    $('#init_nrz_ref_project_ok').css('display', 'inline');
                }
            },
            error: function (result, status, error){
                console.log(result);
                console.log(status);
                console.log(error);
            }
        });// /ajax
    }

    function requirements() {
        
        if(exist_file_src){
            // recuperation de l'id du projet
            src_project_id = $("#src_project_id").html();
            if(src_project_id == ''){
                alert('Vous devez sélectionner un projet "SOURCE"');
                return false;
            }
        }

        if(exist_file_ref){
            // recuperation de l'id du projet
            ref_project_id = $("#ref_project_id").html();
            if(ref_project_id == ''){
                alert('Vous devez sélectionner un projet "REFERENTIEL"');
                return false;
            }
        }

        return true;
    }

    function treatment() {

        var ret = requirements();
        if(!ret){
            return false;
        }

        error = false;

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

        // /Controles ----------------------
        

        // Appels API ----------------------

            $('#result').css('display', 'inherit');
            go_to('result'); // auto scroll

            //$("#result").fadeToggle();

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
                        result_save = save_session_sync("link_project_id", link_project_id);
                        
                        // Sauvegarde du projet bdd
                        console.log("treatment/save_project_synch");
                        save_project_sync(link_project_id, 'link');

                        // 
                        $('#txt_create_merge_project').css('display', 'inline');
                        $('#create_merge_project_ok').css('display', 'inline');
                    }

                },
                error: function (result, status, error){
                    console.log("error - new/link");
                    console.log(result);
                }
            });// /ajax


            // Ajout des projets de normalisation
            // Traitement du fichier SOURCE
                if(new_file_src && !error){
                    console.log('Creation du projet de normalisation (SOURCE)');

                    // Creation du projet de normalisation
                      var tparams = {
                            "url": "/api/new/normalize",
                            "params": {
                                "display_name": project_name + 'auto_normalize_src',
                                "description": project_description + 'auto_normalize_src',
                                "internal": false
                            }
                        }
                        add_new_normalize_project_src(tparams);

                        console.log("treatment/save_session_synch");
                        result_save = save_session_sync("src_project_id", src_project_id);
                        
                        // Sauvegarde du projet en base si user authentifié
                        console.log("treatment/save_project_synch");
                        save_project_sync(src_project_id, 'normalize');

                        //$("#create_project_ok").slideToggle();

                    // Upload du fichier
                    url_src = '<?php echo BASE_API_URL;?>/api/normalize/upload/' + src_project_id;

                    $('#txt_send_src_file').css('display', 'inline');
                    $('#fileupload_src').fileupload(
                        'option',
                        'url',
                        url_src
                    );

                    $("#envoyer_src").click();


                }
                else if(exist_file_src && !error){
                    // Ajout du projet de normalisation au projet de link
                    save_id_normalized_project("source", src_project_id);
                }
                else{
                    error = true;
                    console.log('Pas de sélection de fichier source');
                    alert('Veuillez sélectionner un fichier source');
                }
            // /Traitement du fichier SOURCE

            // Traitement du fichier REF
                if(new_file_ref && !error){
                    console.log('Creation du projet de normalisation (REF)');

                    // Creation du projet de normalisation
                      var tparams = {
                            "url": "/api/new/normalize",
                            "params": {
                                "display_name": project_name + 'auto_normalize_ref',
                                "description": project_description + 'auto_normalize_ref',
                                "internal": false
                            }
                        }
                        add_new_normalize_project_ref(tparams);

                        console.log("treatment/save_session_synch");
                        result_save = save_session_sync("ref_project_id", ref_project_id);
                        
                        // Sauvegarde du projet en base si user authentifié
                        console.log("treatment/save_project_synch");
                        save_project_sync(ref_project_id, 'normalize');

                        //$("#create_project_ok").slideToggle();

                    // Upload du fichier
                    url_ref = '<?php echo BASE_API_URL;?>/api/normalize/upload/' + ref_project_id;

                    $('#txt_send_ref_file').css('display', 'inline');
                    $('#progress_ref').css('display', 'inline-bloc');
                    $('#fileupload_ref').fileupload(
                        'option',
                        'url',
                        url_ref
                    );

                    $("#envoyer_ref").click();


                }
                else if(exist_file_ref && !error){
                    // Ajout du projet de normalisation au projet de link
                    save_id_normalized_project("ref", ref_project_id);
                }
                else{
                    error = true;
                    console.log('Pas de sélection de fichier ref');
                    alert('Veuillez sélectionner un fichier ref');
                }
            // /Traitement du fichier REF



            $('#bloc_bt_next').css('display', 'inherit');

        // /Appels API ----------------------

    }// /treatment


    function valid_project(){
        console.log('valid_project');
        // MAJ du statut

        // Appel de l'étape suivante
        window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + link_project_id;
        
    }

    function select_project(project_id, project_name) {
        if(target){
            $("#" + target + "_project_id").html(project_id);
            $("#" + target + "_project_name").html(project_name);
        }

        $('#modal_projects').modal('hide');

     }

    // Init - Ready
    $(function() {
        url_src = '';
        url_ref = '';
        target = ''; // Utilisé pour la sélection d'un projet dans la modale

        $("#bt_new_project").click(function(e){
            console.log("bt_new_project");
            e.preventDefault();
            treatment();
        });


        $("#bt_modal_ref").click(function(){
            $('#modal_ref').modal('show');
        });


        $("#bt_select_project_src").click(function(){
            target = "src";
            $('#modal_projects').modal('show');
        });

        $(".bloc_project").hover(
            function(){// over
                $(this).css("background", "#eee");
                $(this).find(".chk").css("visibility", 'visible');
            },
            function(){// out
                $(this).css("background", "white");
                $(this).find(".chk").css("visibility", 'hidden');
            }
        );

        $("#bt_select_project_ref").click(function(){
            target = "ref";
            $('#modal_projects').modal('show');
        });


        $("#bt_modal_projects_ref").click(function(){
            target = "ref";
            $('#modal_projects').modal('show');
        });


        $("#bt_next").click(function(){
            valid_project();
        });


        $(".fileinput-button").click(function(){
            $(".fileinput-button").prop("disabled", true);

            $("#bt_normalizer").prop("disabled", false);
        });


        // Upload du fichier SOURCE
        $('#fileupload_src').fileupload({
            url: url_src,
            type:"POST",
            autoUpload: false,
            add: function (e, data) {
                $('#file_name_src').html(data.files[0].name);

                data.context = $('#envoyer_src')
                    .click(function (e) {
                         e.preventDefault();
                        //$('#progress .progress-bar').css('visibility', 'visible');
                        data.submit();
                    });
            },
            done: function (e, data) {
                console.log("upload done");

                //
                
                $('#send_src_file_ok').css('display', 'inline');

                // Ajout du nouveau projet de normalisation au projet de link
                save_id_normalized_project("source", src_project_id);

            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress_src .progress-bar').css(
                    'width',
                    progress + '%'
                );

                console.log("upload progressall");
                console.log('url_src : ' + url_src);
            },
            fail: function (e, data) {
                $('#progress .progress-bar').css(
                    'background-color', 'red'
                );
                console.log("upload fail");
                console.log(e);
                console.log(data);
            }
        }).prop('disabled', !$.support.fileInput)
          .parent().addClass($.support.fileInput ? undefined : 'disabled');
        // /#fileupload_src'.fileupload()


        // Upload du fichier REF
        $('#fileupload_ref').fileupload({
            url: url_ref,
            type:"POST",
            autoUpload: false,
            add: function (e, data) {
                $('#file_name_ref').html(data.files[0].name);

                data.context = $('#envoyer_ref')
                    .click(function (e) {
                         e.preventDefault();
                        //$('#progress .progress-bar').css('visibility', 'visible');
                        data.submit();
                    });
            },
            done: function (e, data) {
                console.log("upload done");
                
                //
                $('#send_ref_file_ok').css('display', 'inline');

                // Ajout du nouveau projet de normalisation au projet de link
                save_id_normalized_project("ref", ref_project_id);

            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress_ref .progress-bar').css(
                    'width',
                    progress + '%'
                );
                
                console.log("upload progressall");
                console.log('url_ref : ' + url_ref);
            },
            fail: function (e, data) {
                $('#progress .progress-bar').css(
                    'background-color', 'red'
                );
                console.log("upload fail");
                console.log(e);
                console.log(data);
            }
        }).prop('disabled', !$.support.fileInput)
          .parent().addClass($.support.fileInput ? undefined : 'disabled');
        // /#fileupload_ref'.fileupload()


        // Tooltip des étapes
        $(".add_selected_columns").attr('title','Etape de sélection des colonnes à traiter.');
        $(".replace_mvs").attr('title','Etape de traitement des valeurs manquantes.');
        $(".recode_types").attr('title','Etape de traitement des types.');
        $(".concat_with_init").attr('title','Etape finale d\'enrichissement et de téléchargement du fichier normalisé.');

        $('[data-toggle="tooltip"]').tooltip(); 


	});

</script>



</body>
</html>
