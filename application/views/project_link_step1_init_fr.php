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
}// /is_completed_step()


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
}// /get_progress_html()


function get_logo_html($name)
{
    # Recherche d'un éventuel logo en rapport avec le nom de fichier
    $html = '';
    $name = strtolower($name);

    foreach (TAB_LOGO as $key => $value) {
        if(!empty(strstr($name, $key))){
            $html = '<img class="logo" src="'.base_url('assets/img/'.$value).'">';
        }
    }

    return $html;
}// / get_logo_html()


function get_internal_projects_html($internal_projects)
{
    # Renvoi un code HTML d'affichage des projets internes (publiques) dans la modale

    $html = '';

    // Récupération des informations depuis les métatdata des projets internes
    foreach ($internal_projects as $project){
        // On test l'existence d'un fichier dans le projet en cas d'upload en erreur
        if(empty($project['last_written']['file_name'])){
            continue;
        }

        // Date de création
        $timestamp = $project['timestamp'];
        $created_date = date('d/m/Y', $timestamp);

        // Nombre de lignes
        $nrows = $project['files'][key($project['files'])]['nrows'];

        $html .= '<div class="bloc_project" onclick="select_internal_ref(\''.$project['project_id'].'\',\''.$project['display_name'].'\');">';

            $html .= '<div class="row">';
                $html .= '<div class="col-md-1 chk">';
                    $html .= '<h3><span class="glyphicon glyphicon-ok"></span></h3>';
                $html .= '</div>';
                $html .= '<div class="col-md-3">';
                    // Logo
                    $html .= get_logo_html($project['display_name']);;
                $html .= '</div>'; // /col-md-3
                $html .= '<div class="col-md-8">';
                    // Nom du projet
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= '<h3 class="internal_ref_title" style="display:inline;">'.$project['display_name'].'<h3>';
                        $html .= '</div>';
                    $html .= '</div>';
                    // Description du projet
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= '<i>'.$project['description'].'</i>';
                        $html .= '</div>';
                    $html .= '</div>';
                    // Date de création
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= 'Création : '.$created_date;
                        $html .= '</div>';
                    $html .= '</div>';
                    // Nombre de ligne
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12">';
                            $html .= 'Nombre de lignes : '.$nrows;
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>'; // /col-md-8
            $html .= '</div>'; // /row
            $html .= '<hr>';
        $html .= '</div>';// / bloc_project


    }// /foreach

    echo $html;
}// /get_internal_projects_html()


function get_normalized_projects_html($id, $normalized_projects)
{
    $html = '';

    $tab_steps = ['add_selected_columns', 'replace_mvs', 'recode_types', 'concat_with_init'];
    $nb_steps = count($tab_steps);
    $ratio = 100/$nb_steps;

    foreach ($normalized_projects as $project){
        // On ne veut pas afficher les projets "publics" ici
        if($project['public']){
            continue;
        }
        // Si upload incomplet, le projet n'a pas de "file", on ne prend pas en compte
        if(empty($project['file'])){
            continue;
        }
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
            $html .= '<div class="row row_select_project">';
                $html .= '<div class="col-md-1 chk">';
                $html .= '<h4 class="glyphicon glyphicon-ok"></h4>';
                $html .= '</div>';
                $html .= '<div class="col-md-9">';
                    $html .= '<h3 style="margin:0;color: #333"><i class="fa fa-chevron-circle-right"></i>&nbsp;'.$project['display_name'].'</h3>';
                    $html .= '<div style="font-size:12px;">';
                        $html .= '<i>'.$project['description'].'</i>';
                    $html .= '</div>';
                $html .= '</div>';
                $html .= '<div class="col-md-2 text-right">';
                    $html .= $created_date;
                $html .= '</div>';
            $html .= '</div>';
            $html .= '<hr>';
        $html .= '</div>';
    }

    echo $html;
}// /get_normalized_projects_html()

?>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid background_1 intro" style="margin-left: 20px; margin-right: 20px;">
    <div class="row" id="explain">
        <div class="col-md-11">
            <div class="page_explain">
                La jointure ou l'appariement de fichiers permet de relier les lignes correspondantes dans 2 fichiers tabulaires.
            </div>
        </div> <!-- / col-11-->
        <div class="col-md-1 text-right">
            <button type="button" id="bt_help" class="btn btn-success3">AIDE</button>
        </div> <!-- / col-1-->
    </div><!-- / explain -->

    <div class="container-fluid">
    	<div class="row">
            <div class="col-md-12 bhoechie-tab-container">
                <div class="col-md-3 bhoechie-tab-menu">
                  <div class="list-group">
                    <a href="#" class="list-group-item active text-center" id="bt_step_source">
                      <h2>
                          <i class="fa fa-table" id="src_menu_icon" aria-hidden="true"></i>
                          <br/>
                          Sélection de la source
                          <div class="selected_file" id="src_menu_selected_file">
                              <span class="title">Sélection : </span>
                              <span class="file" id="src_selection_menu">Pas de fichier sélectionné</span>
                          </div>
                      </h2>
                    </a>
                    <a href="#" class="list-group-item text-center" id="bt_step_referential">
                        <h2>
                            <i class="fa fa-database" id="ref_menu_icon" aria-hidden="true"></i>
                            <br/>
                            Sélection du référentiel
                            <div class="selected_file" id="ref_menu_selected_file">
                                <span class="title">Sélection : </span>
                                <span class="file" id="ref_selection_menu">Pas de fichier sélectionné</span>
                            </div>
                        </h2>
                    </a>
                    <a href="#" class="list-group-item text-center" id="bt_step_identity">
                        <h2>
                            <i class="fa fa-id-card" id="identity_menu_icon" aria-hidden="true"></i>
                            <br/>
                            Identité du projet
                        </h2>
                    </a>
                    <a href="#" class="list-group-item text-center" id="bt_step_cgu">
                        <h2>
                            <i class="fa fa-check" id="cgu_menu_icon" aria-hidden="true"></i>
                            <br/>
                            CGU
                        </h2>
                    </a>
                  </div>
                </div>
                <div class="col-md-9 bhoechie-tab">
                    <!--Selection de la source-->
                    <div class="bhoechie-tab-content active">
                        <div data-intro="Choisissez ici votre fichier source (le fichier sale à auquel associer une référence)" class="fix_height">
                            <h2 style="display: inline;">
                                <span class="step_numbers"><i class="fa fa-chevron-circle-right"></i></span>
                                &nbsp;Sélection de la source
                                <i class="fa fa-table" aria-hidden="true"></i>
                            </h2>
                            <div>
                                Sélectionnez le fichier "source", c'est à dire le fichier auquel on veut associer des codes de référence.
                            </div>
                            <form class="form-horizontal" name="form_src_file" id="form_src_file" method="post" enctype="multipart/form-data">
                                <div class="row" style="margin-top: 40px;">
                                    <div class="col-md-4 text-center">
                                        <a class="btn btn-xs btn-success2 btn_2_5" id="bt_select_project_src">
                                            <h4 class="glyphicon glyphicon-list-alt"></h4>
                                            <h4>Mes fichiers</h4>
                                        </a>
                                        <button id="envoyer_src" style="display: none;"></button>
                                        <div id="src_project_id" style="display: none;"></div>
                                    </div>
                                    <div class="col-md-4 text-center" style="border-left: 4px dashed #ddd;">
                                        <span class="btn btn-success2 btn-xl fileinput-button btn_2_5">
                                            <h4 class="glyphicon glyphicon-plus"></h4>
                                            <br>
                                            <h4>Nouveau</h4>
                                            <input id="fileupload_src" type="file" name="file">
                                        </span>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12">
                                        <h3 style="display: inline;">Fichier sélectionné :</h3>
                                        <i id="src_selection"></i>
                                        <i id="src_selection_msg">Cliquez sur un des boutons ci-dessus pour sélectioner votre fichier source</i>
                                        <div id="file_name_src" class="hidden"></div>
                                        <div id="src_project_name" class="hidden"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="cold-md-12 text-right">
                                <button onclick="$('#bt_step_referential').click();" class="btn btn-success2">Suivant&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></button>
                            </div>
                        </div>
                    </div><!-- /Selection de la source -->



                    <!--Selection du référentiel-->
                    <div class="bhoechie-tab-content">
                        <div data-intro="Choisissez ici votre fichier de référence" class="fix_height">
                            <h2 style="display: inline;">
                                <span class="step_numbers"><i class="fa fa-chevron-circle-right"></i></span>
                                &nbsp;Sélection du fichier "référentiel"
                                <i class="fa fa-database" aria-hidden="true"></i>
                            </h2>
                            <div>
                                Sélectionnez un fichier "référentiel", dans lequel nous chercherons les élements de la source.
                            </div>

                            <form class="form-horizontal" name="form_ref_file" id="form_ref_file" method="post" enctype="multipart/form-data">
                                <form class="form-horizontal" name="form_src_file" id="form_src_file" method="post" enctype="multipart/form-data">
                                    <div class="row" style="margin-top: 40px;">
                                        <div class="col-md-4 text-center">
                                            <a class="btn btn-xs btn-success2 btn_2_5" style="width:240px;" id="bt_modal_ref">
                                                <h4 class="glyphicon glyphicon-list-alt"></h4>
                                                <h4>Référentiels publiques</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row" style="margin-top: 40px;">
                                        <div class="col-md-4 text-center">
                                            <a class="btn btn-xs btn-success2 btn_2_5" id="bt_select_project_ref">
                                                <h4 class="glyphicon glyphicon-list-alt"></h4>
                                                <h4>Mes fichiers</h4>
                                            </a>
                                            <div id="ref_project_id" style="display: none;"></div>
                                        </div>
                                        <div class="col-md-4 text-center" style="border-left: 4px dashed #ddd;">
                                            <span class="btn btn-success2 btn-xl fileinput-button btn_2_5">
                                                <h4 class="glyphicon glyphicon-plus"></h4>
                                                <h4>Nouveau</h4>
                                                <input id="fileupload_ref" type="file" name="file">
                                            </span>
                                            <!--<span id="file_name_ref"></span>-->
                                            <button id="envoyer_ref" style="display: none;"></button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <h3 style="display: inline;">Fichier sélectionné :</h3>
                                            <i id="ref_selection"></i>
                                            <i id="ref_selection_msg">Cliquez sur un des boutons ci-dessus pour choisir voter référentiel</i>
                                            <div id="file_name_ref" class="hidden"></div>
                                            <div id="ref_project_name" class="hidden"></div>
                                            <div id="ref_internal_project_name" class="hidden"></div>
                                        </div>
                                    </div>

                            </form>
                        </div>

                        <div class="row">
                            <div class="cold-md-12 text-right">
                                <button onclick="$('#bt_step_source').click();" class="btn btn-success2"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Précédent</button>
                                <button onclick="$('#bt_step_identity').click();" class="btn btn-success2">Suivant&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Identité du projet -->
                    <div class="bhoechie-tab-content">
                        <div class="fix_height">
                            <h2 style="display: inline;">
                                <span class="step_numbers"><i class="fa fa-chevron-circle-right"></i></span>
                                &nbsp;Identité du projet
                            </h2>
                            <br /><br /><br />
                            <form class="form-horizontal" name="form_project" id="form_project" method="post">
                                <div class="form-group" data-intro="Choisissez un nom pour vous y retrouver plus facilement">
                                    <label for="project_name" class="col-sm-2 control-label">Nom du projet *</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Nom du projet" value="Projet_1">
                                    </div>
                                </div>
                                <div class="form-group" data-intro="Ajoutez une description optionnelle">
                                    <label for="project_description" class="col-sm-2 control-label">Description du projet</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="project_description" name="project_description" rows="3"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <div class="cold-md-12 text-right">
                                <button onclick="$('#bt_step_referential').click();" class="btn btn-success2"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Précédent</button>
                                <button onclick="$('#bt_step_cgu').click();$('#identity_menu_icon').css('color', '#A7CA48');" class="btn btn-success2">Suivant&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- CGU -->
                    <div class="bhoechie-tab-content">
                        <div class="fix_height">
                            <h2 style="display: inline;">
                                <span class="step_numbers"><i class="fa fa-chevron-circle-right"></i></span>
                                &nbsp;Conditions Générales d'Utilisation
                            </h2>
                            <br /><br /><br />
                            <div class="row">

                                <div class="col-md-offset-1 col-md-10" id="txt_cgu" style="overflow-y: auto;height: 400px;">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    <br /><br />
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    <br /><br />
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    <br /><br />
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    <br /><br />
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    <br /><br />
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    <br /><br />
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label>
                                    <input type="checkbox" id="chk_cgu" disabled>
                                    <span id="label_cgu" class="chk_label_disabled"> En cochant cette case vous acceptez les Conditions Générales d'Utilisation</span>
                                </label>
                                <br />
                                <label>
                                    <input type="checkbox" id="chk_reuse" checked>
                                    <span class="chk_label_enabled"> En cochant cette case vous acceptez que vos données soient utilisées pour l'amélioration de l'application</span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button onclick="$('#bt_step_identity').click();" class="btn btn-success2"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Précédent</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>

    <div class="row" style="padding-top: 20px;padding-bottom: 20px;">
        <div class="col-md-12 text-right">
            <button class="btn btn-success" id="bt_new_project" style="width: 300px;">Créer le projet >></button>
        </div>
    </div>

</div><!-- /container-fluid -->



<!--
<div class="container-fluid background_1" style="margin-left: 20px; margin-right: 20px;">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="display: inline;">
                <span class="step_numbers">1</span>
                &nbsp;Identité du projet
            </h2>
            <form class="form-horizontal" name="form_project" id="form_project" method="post">
                <div class="form-group" data-intro="Choisissez un nom pour vous y retrouver plus facilement">
                    <label for="project_name" class="col-sm-2 control-label">Nom du projet *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Nom du projet" value="Projet_1">
                    </div>
                </div>
                <div class="form-group" data-intro="Ajoutez une description optionnelle">
                    <label for="project_description" class="col-sm-2 control-label">Description du projet</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="project_description" name="project_description" rows="3"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container-fluid background_1" style="margin-left: 20px; margin-right: 20px;">
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <div data-intro="Choisissez ici votre fichier source (le fichier sale à auquel associer une référence)">
                        <h2 style="display: inline;">
                            <span class="step_numbers">2</span>
                            &nbsp;Sélection du fichier "source"
                            <i class="fa fa-table" aria-hidden="true"></i>
                        </h2>
                        <div>
                            Sélectionnez le fichier "source", c'est à dire le fichier auquel on veut associer des codes de référence.
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <h3>
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    &nbsp;Fichier "Source" sélectionné :
                                </h3>
                                <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                &nbsp;<i id="src_selection">Pas encore de sélection</i>
                                <div id="file_name_src" class="hidden"></div>
                                <div id="src_project_name" class="hidden"></div>
                            </div>
                        </div>
                        <hr>
                        <form class="form-horizontal" name="form_src_file" id="form_src_file" method="post" enctype="multipart/form-data">
                            <div class="row" data-intro="Vous pouvez uploader un nouveau fichier ...">
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
                                        <button id="envoyer_src" style="display: none;"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row" data-intro="... ou en reprendre un que vous avez déjà uploadé">
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
                <div class="col-xs-6" style="border-left: 3px dotted #ddd;">
                    <div data-intro="Choisissez ici votre fichier de référence">
                        <h2 style="display: inline;">
                            <span class="step_numbers">3</span>
                            &nbsp;Sélection du fichier "référentiel"
                            <i class="fa fa-database" aria-hidden="true"></i>
                        </h2>
                        <div>
                            Sélectionnez un fichier "référentiel", dans lequel nous chercherons les élements de la source.
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <h3>
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    &nbsp;Fichier "Référentiel" sélectionné :
                                </h3>
                                <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                &nbsp;<i id="ref_selection">Pas encore de sélection</i>
                                <div id="file_name_ref" class="hidden"></div>
                                <div id="ref_project_name" class="hidden"></div>
                                <div id="ref_internal_project_name" class="hidden"></div>
                            </div>
                        </div>
                        <hr>
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
                                    <div id="ref_project_id" style="display: none;"></div>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                </div>
                             </div>
                            <div class="row" data-intro="Vous pouvez aussi choisir un référentiel dans notre collection de référentiels publiques">
                                <div class="col-xs-1">
                                    <h3 class="hover_exist_ref_target">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </h3>
                                </div>
                                <div class="col-xs-8 hover_exist_ref">
                                    <div>
                                        <h3>Référentiels publics</h3>
                                        Vous avez la possibilité d'utiliser des référentiels publiques. Chacun de ces référentiels a déjà été normalisés. Une description de leur contenu est disponible pour chacun d'entre eux.
                                        <br><br>
                                        NB: Nous ne nous engageons pas sur la qualité des données.
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
                    </div>
                </div>
            </div>

            <hr>

            <div class="row" style="padding-top: 20px;padding-bottom: 20px;">
                <div class="col-md-offset-6 col-md-6">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="chk_cgu"> En cochant cette case vous acceptez les <a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">conditions générales d'utilisation</a>
                        </label>
                    </div>
                </div>
                <div class="col-md-offset-6 col-md-6">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="chk_reuse" checked> En cochant cette case vous acceptez que vos données soient utilisées pour l'amélioration de l'application
                        </label>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top: 20px;padding-bottom: 20px;">
                <div class="col-md-12 text-right">
                    <button class="btn btn-success" id="bt_new_project" style="width: 300px;">Créer le projet >></button>
                </div>
            </div>
        -->




            <div class="row background_2">
                <div class="col-md-12">
                    <div class="row" id="result" style="margin-top: 20px;color: #fff;">
                        <div id="steps" style="margin-left: 10px;margin-right: 10px;">
                            <div>
                                <span id="txt_create_merge_project">Création du projet de jointure</span>
                                <span id="create_merge_project_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>

                            <div style="margin-top: 20px;">
                                <span id="txt_init_nrz_src_project">Initialisation du projet de normalisation "SOURCE"</span>
                                <span id="init_nrz_src_project_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>
                            <div>
                                <span id="txt_send_src_file">Envoi du fichier "SOURCE" sur le serveur</span>
                                <span id="send_src_file_ok" class="glyphicon glyphicon-ok check_ok"></span>

                                <div id="progress_src" class="progress" style="margin-bottom: 5px;width:100%">
                                    <div class="progress-bar progress-bar-success progress-bar-striped active" style="height: 5px;width:0%"></div>
                                </div>
                            </div>
                            <div id="send_src_analyse">
                                <span>Analyse du fichier "SOURCE"</span>
                                <span id="send_src_analyse_wait">
                                    <img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 20px;">
                                </span>
                                <span id="send_src_analyse_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>

                            <div style="margin-top: 20px;">
                                <span id="txt_init_nrz_ref_project">Initialisation du projet de normalisation "REFERENTIEL"</span>
                                <span id="init_nrz_ref_project_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>
                            <div>
                                <span id="txt_send_ref_file">Envoi du fichier "REFERENTIEL" sur le serveur</span>
                                <span id="send_ref_file_ok" class="glyphicon glyphicon-ok check_ok"></span>

                                <div id="progress_ref" class="progress" style="margin-bottom: 5px;width:100%">
                                    <div class="progress-bar progress-bar-success progress-bar-striped active" style="height: 5px;width:0%"></div>
                                </div>
                            </div>
                            <div id="send_ref_analyse">
                                <span>Analyse du fichier "REFERENTIEL"</span>
                                <span id="send_ref_analyse_wait">
                                    <img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 20px;">
                                </span>
                                <span id="send_ref_analyse_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>

                            <div style="margin-top: 20px;">
                                <span id="txt_add_src_nrz_projects">Ajout du projet de normalisation "SOURCE" au projet de jointure</span>
                                <span id="add_src_nrz_projects_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>
                            <div>
                                <span id="txt_add_ref_nrz_projects">Ajout du projet de normalisation "REFERENTIEL" au projet de jointure</span>
                                <span id="add_ref_nrz_projects_ok" class="glyphicon glyphicon-ok check_ok"></span>
                            </div>
                        </div> <!--/steps-->
                    </div>

                    <div class="row" id="bloc_bt_next" style="padding-bottom: 20px;">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" id="bt_next">Etape suivante : Association des colonnes >></button>
                        </div>
                    </div>
                </div>
            </div>



            <div id="files" class="files"></div>

        </div> <!-- / col-12-->
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
        <?php
            get_internal_projects_html($internal_projects);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal error-->
<div class="modal fade" id="modal_error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #262626">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color: #ddd">Erreur(s) !</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-1">
                <h2 style="margin-top:0;color: #E00612;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></h2>
            </div>
            <div class="col-xs-11" id="errors">

            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

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
          <h2>Qu’est-ce que ça fait?</h2>
          Cet outil permet de faire des jointures entre deux fichiers de données tabulaires (csv, excel).
          <br />
          Malheureusement, il n'y a rien de magique; plus les données d'entrées sont propres et proches, plus la jointure sera performante. Pour schématiser, si un humain sans connaissances métier est capables de distinguer deux lignes de match et de lignes de non-match dans vos fichiers d'entrée, alors la machine pourra peut-être joindre vos fichiers; sinon, elle n'aura sans doute pas de succès...

          <h3>Prérequis</h3>
          Il est attendu que les entités du ficher sale soient un sous-ensemble de celles du fichier de référence (càd qu'on doit pouvoir être capable de retrouver toutes les lignes de la source dans la référence).
          <br />
          Les lignes à apparier dans la source et la référence doivent avoir des mots en commun (à quelques fautes d'orthographe près). Le matching s'appuie sur le texte et cherche des similarités entre les chaînes de caractères.
          <br />
          Aucun savoir sémantique n'est requis. La machine n'a pas de connaissances de type humain et ne sait pas, par exemple, que "Chateau" et "Forteresse" ont un sens proche qui pourrait aider à matcher. Cela étant dit, il y a quelques cas où nous avons inclus un savoir sémantique (par la fonction `synonym` de Elasticsearch): pour les villes il est possible de trouver "Paris" en recherchant "Lutèce". Il est possible d'ajouter vos propres banques de synonymes pour créer de telles équivalences.
          <br />
          Aucun savoir extérieur n'est requis. La machine fera les matchs en s'appuyant uniquement sur les données présentes dans la ligne. Elle n'ira pas chercher de données d'une source externe (sauf dans le cas de synonymes, décrits au dessus).

          <h3>Concepts</h3>

          <b>source :</b> Une table de données sales à laquelle on souhaite joindre une référence
          <br />
          <b>ref (référentiel) :</b> Une table de données propres dans laquelle nous recherchons des éléments de la source.

          <h3>Données d'entrée</h3>
          Les entrées sont un fichier source et un fichier de référence...

          <h4>Dois-je nettoyer les données d'entrée</h4>
          Ça dépend... Nous suggérons d'essayer le matching sans pré-processing. Mais il faut garder en tête que plus les données d'entrées sont propres et proches, plus le matching sera performant. Si les résultats ne sont pas satisfaisants, nous suggérons d'essayer ce qui suit:
          <ul>
              <li>Enlever les mots "parasites" qui ne présents que dans un des deux fichiers.</li>
              <li>Créer des colonnes avec des variables catégorielles pour faciliter la distinction.</li>
              <li>Utiliser un géocodeur pour normaliser les variables d'adresse.</li>
              <li>Normaliser les codes (identifiants, numéros de téléphone, ...)</li>
              <li>Généralement: essayer de rendre la source plus proche du référentiel</li>
          </ul>
      </div>

      <div class="modal-footer">
        <!--
        <button type="button" class="btn btn-success3" data-dismiss="modal" onclick="javascript:introJs().setOption('showBullets', false).start();">Lancer le didacticiel</button>
        -->
        <button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">

    var err = false;

    function my_errors(direction, my_error) {
    	var div_error = $("#msg_danger");
    	console.log(my_error);
    	switch (my_error){
    		case "project_name_undefined":
    			div_error.html("<strong>Le nom du projet doit être renseigné.</strong>");
    		break;
            case "no_src_project":
                div_error.html("<strong>Veuillez seélectionner un fichier source</strong>");
            break;
            case "no_ref_project":
                div_error.html("<strong>Veuillez seélectionner un fichier référentiel</strong>");
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


    function save_project(project_id, project_type) {
        $.ajax({
            type: 'post',
            url: '<?php echo base_url('index.php/Save_ajax/project');?>',
            data: 'project_id=' + project_id + '&project_type=' + project_type,
            success: function (result) {
                console.log("result : ",result);
            },
            error: function (result, status, error){
                show_api_error(result, "error API - save_project");
            }
        });
    }// /save_project()


	function save_session(name, value) {
		$.ajax({
			type: 'post',
			url: '<?php echo base_url('index.php/Save_ajax/session');?>',
			data: 'name=' + name + '&val=' + value,
			success: function (result) {
				if(!result){
					console.log("sauvegarde en sesion de " + 'name=' + name + '&val=' + value + ':' + result);
                    show_api_error(result, "error API - save_session");
                    //return false;
				}
				else{
					console.log("save_session OK");
                    //return true;
				}
			},
			error: function (result, status, error){
				show_api_error(result, "error - save_session");
				//return false;
			}
		});
	}// /save_session()


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
            success: function (result) {
                if(result.error){
                    show_api_error(result, "API error - select_file");
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
                show_api_error(result, "error - select_file");
                err = true;
            }
        });// /ajax - select_file
    }// /save_id_normalized_project()


    function add_new_normalize_project_src(tparams) {
        console.log("add_new_normalize_project_src");

        $.ajax({
            type: 'post',
            url: '<?php echo BASE_API_URL;?>' + tparams["url"],
            data: JSON.stringify(tparams["params"]),
            contentType: "application/json; charset=utf-8",
            traditional: true,
            success: function (result) {
                console.dir(result);

                if(result.error){
                    show_api_error(result, "API error - new normalize project");
                }
                else{
                    console.log("success");

                    // Récupération de l'identifiant projet
                    src_project_id = result.project_id;

                    $('#txt_init_nrz_src_project').css('display', 'inline');
                    $('#init_nrz_src_project_ok').css('display', 'inline');

                    console.log("treatment/save_session");
                    save_session("src_project_id", src_project_id);

                    // Sauvegarde du projet en base si user authentifié
                    console.log("treatment/save_project");
                    save_project(src_project_id, 'normalize');

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
            },
            error: function (result, status, error){
                show_api_error(result, "error - new normalize project");
            }
        });// /ajax
    }// /add_new_normalize_project_src()


    function add_new_normalize_project_ref(tparams) {
        console.log("add_new_normalize_project_ref");

        $.ajax({
            type: 'post',
            url: '<?php echo BASE_API_URL;?>' + tparams["url"],
            data: JSON.stringify(tparams["params"]),
            contentType: "application/json; charset=utf-8",
            traditional: true,
            success: function (result) {
                if(result.error){
                    show_api_error(result, "API error - new normalize project ref");
                }
                else{
                    console.log("success");

                    // Récupération de l'identifiant projet
                    ref_project_id = result.project_id;

                    $('#txt_init_nrz_ref_project').css('display', 'inline');
                    $('#init_nrz_ref_project_ok').css('display', 'inline');

                    console.log("treatment/save_session");
                    save_session("ref_project_id", ref_project_id);

                    // Sauvegarde du projet en base si user authentifié
                    console.log("treatment/save_project");
                    save_project(ref_project_id, 'normalize');

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
            },
            error: function (result, status, error){
                show_api_error(result, "error - new normalize project ref");
            }
        });// /ajax
    }// /add_new_normalize_project_ref()


    function requirements() {

        error = false;
        var tab_error = new Array();

        // Récupération des valeurs
        var project_name = $("#project_name").val();
        var project_description = $("#project_description").val();

        // Le champ project_name doit être renseigné
        if(project_name == ""){
            tab_error.push('Veuillez renseigner le nom du projet.');
        }

        //if(!new_file_src && !exist_file_src){
        if($("#src_selection").html() == ""){
            tab_error.push('Vous devez sélectionner un fichier SOURCE.');
        }

        //if(!new_file_ref && !exist_file_ref && !exist_ref){
        if($("#ref_selection").html() == ""){
            tab_error.push('Vous devez sélectionner un fichier REFERENTIEL.');
        }

        if($("#src_selection").html() == $("#ref_selection").html()){
            tab_error.push('Le fichier SOURCE et le fichier REFERENTIEL doivent être différents.');
        }

        //  test CGU
        if(!$("#chk_cgu").is(':checked')){
            // Affichage de la modale d'erreur CGU
            tab_error.push('Vous devez valider les <a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">conditions générales d\'utilisation</a> afin de pouvoir commencer la création d\'un projet.');
        }

        if(exist_file_src){
            // recuperation de l'id du projet
            src_project_id = $("#src_project_id").html();
            if(src_project_id == ''){
                tab_error.push('Vous devez sélectionner un fichier SOURCE.');
            }
        }

        if(exist_file_ref || exist_ref){
            // recuperation de l'id du projet
            ref_project_id = $("#ref_project_id").html();
            if(ref_project_id == ''){
                tab_error.push('Vous devez sélectionner un fichier référentiel.');
            }
        }

        $("#errors").html("");
        if(tab_error.length > 0){
            for (var i = 0; i < tab_error.length; i++) {
                $("#errors").html($("#errors").html() + tab_error[i] + '<br>');
            }

            $("#modal_error").modal("show");
        }
        else{
            return true;
        }
    }// /requirements()


    function treatment() {

        var ret = requirements();
        if(!ret){
            return false;
        }

        var project_name = $("#project_name").val();
        var project_description = $("#project_description").val();

        // desactivation du bouton
        $("#bt_new_project").css("display", "none");

        // Appels API ----------------------
            $('#result').css('display', 'inherit');
            go_to('result'); // auto scroll

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
                crossDomain: true,
                success: function (result) {
                    if(result.error){
                        show_api_error(result, "API error - new/link");
                    }
                    else{
                        console.log("success - new/link");

                        // Récupération de l'identifiant projet
                        //project_id = result.project_id;
                        link_project_id = result.project_id;
                        console.log("project_id" + link_project_id);

                        var result_save = "";

                        console.log("treatment/save_session");
                        save_session("link_project_id", link_project_id);

                        // Sauvegarde du projet bdd
                        console.log("treatment/save_project");
                        save_project(link_project_id, 'link');

                        //
                        $('#txt_create_merge_project').css('display', 'inline');
                        $('#create_merge_project_ok').css('display', 'inline');

                        // Ajout des projets de normalisation
                        treatment_src();
                        treatment_ref();
                    }
                },
                error: function (result, status, error){
                    show_api_error(result, "error - new/link");
                }
            });// /ajax
    }// /treatment


    function treatment_src() {
        // Traitement du fichier SOURCE
            if(new_file_src && !error){
                console.log('Creation du projet de normalisation (SOURCE)');
                // Creation du projet de normalisation
                var file_name_temp = $("#src_selection").html();
                var tparams = {
                    "url": "/api/new/normalize",
                    "params": {
                        "display_name": file_name_temp,
                        "description": project_description + '',
                        "internal": false
                    }
                }
                add_new_normalize_project_src(tparams);
            }
            else if(exist_file_src && !error){
                // Ajout du projet de normalisation au projet de link
                save_id_normalized_project("source", src_project_id);

                $('#send_src_analyse_wait').css('display', 'none');
                $('#send_src_analyse_ok').css('display', 'inline-block');

                // Le fichier est déjà uploadé
                UL_fic_src = true;
            }
            else{
                error = true;
                console.log('Pas de sélection de fichier source');
                alert('Veuillez sélectionner un fichier source');
            }
        // /Traitement du fichier SOURCE
    }// /treatment_src()


    function treatment_ref() {
        // Traitement du fichier REF
            if(new_file_ref && !error){
                console.log('Creation du projet de normalisation (REF)');
                var file_name_temp = $("#ref_selection").html();
                // Creation du projet de normalisation
                  var tparams = {
                        "url": "/api/new/normalize",
                        "params": {
                            "display_name": file_name_temp,
                            "description": project_description + '',
                            "internal": false
                        }
                    }
                    add_new_normalize_project_ref(tparams);
            }
            else if(exist_file_ref && !error){
                // Ajout du projet de normalisation au projet de link
                save_id_normalized_project("ref", ref_project_id);

                $('#send_ref_analyse_wait').css('display', 'none');
                $('#send_ref_analyse_ok').css('display', 'inline-block');

                // Le fichier est déjà uploadé
                UL_fic_ref = true;
            }
            else if(exist_ref && !error){
                // Ajout du projet de normalisation au projet de link
                save_id_normalized_project("ref", ref_project_id);

                $('#send_ref_analyse_wait').css('display', 'none');
                $('#send_ref_analyse_ok').css('display', 'inline-block');

                // Le fichier est déjà uploadé
                UL_fic_ref = true;
            }
            else{
                error = true;
                console.log('Pas de sélection de fichier ref');
                alert('Veuillez sélectionner un fichier ref');
            }
        // /Traitement du fichier REF
    }// /treatement_ref()


    function valid_project(){
        console.log('valid_project');
        // MAJ du statut

        // Appel de l'étape suivante
        window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + link_project_id;
    }// /valid_project()


    function select_project(project_id, project_name) {
        if(target){
            $("#" + target + "_project_id").html(project_id);
            $("#" + target + "_project_name").html(project_name);
            $("#" + target + "_selection").html(project_name);
            $("#" + target + "_selection_msg").html("");

            // Menu
            $("#" + target + "_selection_menu").html(project_name);
            $("#" + target + "_menu_selected_file").css("visibility", "visible");
            $("#" + target + "_menu_icon").css("color", "#A7CA48");

            // Passage à l'étape suivante
            if(target == "src"){
                $('#bt_step_referential').click();

                // Fichier source existant
                new_file_src = false;
                exist_file_src = true;

            }
            else{ //ref
                $('#bt_step_identity').click();

                // Fichier referentiel existant
                new_file_ref = false;
                exist_file_ref = true;
                exist_ref = false;
            }
        }
        $("#modal_projects").modal('hide');
    }// /select_project()


    function select_internal_ref(project_id, project_name) {
        // Appelé sur validation d'un projet interne dans la modale
        $("#ref_project_id").html(project_id);
        $("#ref_internal_project_name").html(project_name);
        $("#ref_selection").html(project_name);
        $("#ref_selection_msg").html("");

        // Menu
        $("#ref_selection_menu").html(project_name);
        $("#ref_menu_selected_file").css("visibility", "visible");
        $("#ref_menu_icon").css("color", "#A7CA48");

        // Passage à l'étape suivante
        $('#bt_step_identity').click();

        // Référentiel interne
        exist_ref = true;
        new_file_ref = false;
        exist_file_ref = false;


        $("#modal_ref").modal('hide');
    }// /select_internal_ref()


    // Init - Ready
    $(function() {
        url_src = '';
        url_ref = '';
        UL_fic_src = false;
        UL_fic_ref =  false;
        target = ''; // Utilisé pour la sélection d'un projet dans la modale

        // Navigation
        $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
            e.preventDefault();
            $(this).siblings('a.active').removeClass("active");
            $(this).addClass("active");
            var index = $(this).index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });

        // Scroll CGU
        $("#txt_cgu").scroll(function() {
           if($("#txt_cgu").scrollTop() >= 260) {
               $("#chk_cgu").prop("disabled", false);
               $("#label_cgu").removeClass("chk_label_disabled");
               $("#label_cgu").addClass("chk_label_enabled");
           }
        });


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
                //$(this).css("background", "#eee");
                $(this).find(".chk").css("visibility", 'visible');
            },
            function(){// out
                //$(this).css("background", "white");
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

        $("#bt_help").click(function(){
            $('#modal_help').modal('show');
        });


        $(".fileinput-button").click(function(){
            $(".fileinput-button").prop("disabled", true);

            $("#bt_normalizer").prop("disabled", false);
        });

        $("#chk_cgu").click(function(){
            if($("#chk_cgu").is(':checked')){
                $("#cgu_menu_icon").css("color", "#A7CA48");
            }
            else{
                $("#cgu_menu_icon").css("color", "#333");
            }
        });

        // Upload du fichier SOURCE
        $('#fileupload_src').fileupload({
            url: url_src,
            type:"POST",
            autoUpload: false,
            add: function (e, data) {
                $('#file_name_src').html(data.files[0].name);
                $('#src_selection').html(data.files[0].name);
                $('#src_selection_msg').html("");

                // Menu
                $('#src_selection_menu').html(data.files[0].name);
                $("#src_menu_selected_file").css("visibility", "visible");
                $("#src_menu_icon").css("color", "#A7CA48");

                // Passage a l'étape suivante
                $('#bt_step_referential').click();

                // Nouveau fichier
                new_file_src = true;
                exist_file_src = false;

                data.context = $('#envoyer_src')
                    .click(function (e) {
                        e.preventDefault();
                        $("#progress_src").css('display', 'inline-block');
                        $("#send_src_analyse").css('display', 'inline-block');
                        data.submit();
                    });
            },
            done: function (e, data) {
                console.log("upload src done");
                $('#send_src_analyse_wait').css('display', 'none');
                $('#send_src_analyse_ok').css('display', 'inline-block');

                // Ajout du nouveau projet de normalisation au projet de link
                save_id_normalized_project("source", src_project_id);

                // On indique que l'upload est terminé afin d'afficher le bouton "suivant"
                UL_fic_src = true;
            },
            progressall: function (e, data) {
                console.log("upload src progressall");
                var progress = parseInt(data.loaded / data.total * 100, 10);
                console.log('progress src : ' + progress);
                $('#progress_src .progress-bar').css('width', progress + '%');
                if(progress == 100){
                    console.log('SOURCE : analyse en cours');
                    $("#progress_src").css('display', 'none');
                    $('#send_src_file_ok').css('display', 'inline-block');
                    $('#send_src_analyse_wait').css('display', 'inline-block');
                }
            },
            fail: function (e, data) {
                console.log("upload src fail");
                console.log(e);
                console.log(data);
                $('#progress .progress-bar').css('background-color', 'red');
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
                $('#ref_selection').html(data.files[0].name);
                $('#ref_selection_msg').html("");

                // Menu
                $('#ref_selection_menu').html(data.files[0].name);
                $("#ref_menu_selected_file").css("visibility", "visible");
                $("#ref_menu_icon").css("color", "#A7CA48");

                // Passage à l'étape suivante
                $('#bt_step_identity').click();

                // Nouveau fichier
                new_file_ref = true;
                exist_file_ref = false;
                exist_ref = false;


                data.context = $('#envoyer_ref')
                    .click(function (e) {
                         e.preventDefault();
                        $("#progress_ref").css('display', 'inline-block');
                        $("#send_ref_analyse").css('display', 'inline-block');
                        data.submit();
                    });
            },
            done: function (e, data) {
                console.log("upload ref done");
                $('#send_ref_analyse_wait').css('display', 'none');
                $('#send_ref_analyse_ok').css('display', 'inline-block');

                // Ajout du nouveau projet de normalisation au projet de link
                save_id_normalized_project("ref", ref_project_id);

                // On indique que l'upload est terminé afin d'afficher le bouton "suivant"
                UL_fic_ref = true;
            },
            progressall: function (e, data) {
                console.log("upload ref progressall");
                var progress = parseInt(data.loaded / data.total * 100, 10);
                console.log('progress ref : ' + progress);
                $('#progress_ref .progress-bar').css('width', progress + '%');
                if(progress == 100){
                    console.log('REFERENTIEL : analyse en cours');
                    $("#progress_ref").css('display', 'none');
                    $('#send_ref_file_ok').css('display', 'inline-block');
                    $('#send_ref_analyse_wait').css('display', 'inline-block');
                }
            },
            fail: function (e, data) {
                $('#progress_ref .progress-bar').css('background-color', 'red');
                console.log("upload ref fail");
                console.log(e);
                console.log(data);
            }
        }).prop('disabled', !$.support.fileInput)
          .parent().addClass($.support.fileInput ? undefined : 'disabled');
        // /#fileupload_ref'.fileupload()


        // Test de la creation des projets pour afficher le bouton "suivant"
        var handle = setInterval(function(){
            console.log('Test fin de traitement ...');
            if(UL_fic_src && UL_fic_ref){
                console.log('Fin de traitement OK');
                clearInterval(handle);

                // Affichage du bouton "suivant"
                $('#bloc_bt_next').css('display', 'inherit');
            }
        }, 1000);

        // Tooltip des étapes
        $(".add_selected_columns").attr('title','Etape de sélection des colonnes à traiter.');
        $(".replace_mvs").attr('title','Etape de traitement des valeurs manquantes.');
        $(".recode_types").attr('title','Etape de traitement des types.');
        $(".concat_with_init").attr('title','Etape finale d\'enrichissement et de téléchargement du fichier normalisé.');
        $('[data-toggle="tooltip"]').tooltip();
	}); // / Ready

</script>

</body>
</html>
