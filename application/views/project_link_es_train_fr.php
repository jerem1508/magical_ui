<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<!--
<div class="container-fluid intro" id="entete" style="padding-bottom: 20px;">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="page_title"><span id="project_name1"></span> : <i>Apprentissage</i></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="page_explain">
                L'étape d'apprentissage va permettre à la machine de s'adapter au mieux à vos données. Des exemples vont vous être présentés,il vous suffira de répondre par "OUI" ou par "NON" en fonction de leur concordance.
                <br><br>
                Plusieurs indices vous donneront le taux de réussite estimé du traitement finale.
                <br>
                Indice de pécision :
                <br>
                Indice de rappel : Pourcentage de lignes considérée justes par rapport au nombre de lignes totales du fichier
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button class="btn btn-success" id="bt_start">Commencer l'apprentissage</button>
        </div>
    </div>
</div>
<div id="tempo" style="min-height: 400px;"></div>
-->

<div class="container-fluid work background_1" style="padding-bottom: 20px;margin-left:20px;margin-right:20px;">
    <div class="row">
        <div class="col-md-11">
            <div class="page_explain">
                L'étape d'apprentissage va permettre à la machine de s'adapter au mieux à vos données. Des exemples vont vous être présentés, il vous suffira de répondre par "OUI" ou par "NON" en fonction de leur concordance.
            </div>
        </div>
        <div class="col-md-1 text-right">
            <button type="button" id="bt_help" class="btn btn-success3">AIDE</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9"><!-- Partie principale -->

            <div class="row"  data-intro="Les filtres (sur le référentiel) permettent de rendre obligatoires ou d'interdire certains mots. Cela permet d'obtenir de meilleurs résultats sur le match. Cependant, le raffraichissement peut être un peu long.">
                <div class="col-xs-12">
                    <h2>
                        <span class="step_numbers"><i class="fa fa-chevron-circle-right"></i></span>
                        &nbsp;Filtres sur le référentiel
                    </h2>
                </div>
            </div>
            <div class="row" data-intro="Spécifiez par colonne les termes obligatoires. TOUS les termes indiqués devront être présents dans les lignes du réfentiel proposées.">
                <div class="col-xs-offset-1 col-xs-2" style="padding-top: 5px;">
                    Termes obligatoires
                </div>
                <div class="col-xs-9">
                    <input type="text" id="filter_plus" data-role="tagsinput" value="">
                    <button class="btn btn-default" id="bt_add_filter_plus">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div>
            <div class="row" data-intro="Spécifiez par colonne les termes interdits. AUCUN des termes indiqués ne devront devront être présents dans les lignes du réfentiel proposées.">
                <div class="col-xs-offset-1 col-xs-2" style="padding-top: 5px;">
                    Termes à exclures
                </div>
                <div class="col-xs-9">
                    <input type="text" id="filter_minus" data-role="tagsinput" value="">
                    <button class="btn btn-default" id="bt_add_filter_minus">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div><!-- / row-->

            <hr style="border-top: 4px dashed #ddd;">

            <div class="row" data-intro="Indiquez nous si le match proposé est correct. La machine tente d'apprendre de ses erreurs; plus vous labellisez, meilleurs seront les résultats.">
                <div class="col-xs-12">
                    <h2>
                        <span class="step_numbers"><i class="fa fa-chevron-circle-right"></i></span>
                        &nbsp;Labellisation
                    </h2>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 text-justify">
                            <div class="well">
                                La labellisation permet à la machine d'apprendre comment apparier les lignes entre elles. Vous devez indiquer si les paires proposées concordent (OUI) ou diffèrent (NON), ou si la ligne de la source n'a pas besoin d'être cherchée dans le référentiel (Oublier cette ligne (source)). La machine propose alternativemement les matchs les plus probables et des matchs qu'elle voit comme faux.
                            </div><!-- /well-->
                        </div>
                    </div><!-- / row-->
                    <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
                        <div class="col-xs-offset-1 col-xs-4 text-justify">
                            <div style="margin-bottom: 20px;">
                                <h4 style="margin-top: 0;display: inline;">Filtres utilisateur temporaires :</h4>
                                <button id="bt_user_filters_delete" style="visibility: hidden;" class="btn btn-xs btn-danger" onclick="delete_user_filter();">
                                    <i class="fa fa-trash"></i>&nbsp;Effacer
                                </button>
                            </div>

                            <div id="user_filters">
                                <i class="fa fa-info-circle"></i> Pour ajouter un filtre temporaire, vous devez cliquer sur un ou plusieurs termes de la source. Cela à pour but de cibler plus précisément les recherches et donc d'optimiser la proposition faite.
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div id="message">
                                <img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">
                            </div>
                            <div class="q_label">
                                Ces informations sont-elles identiques ?
                            </div>
                            <div>
                                <button class="btn btn-default btn-xl btn_icon btn-default"
                                data-toggle="tooltip"
                                title="Revenir à la proposition précédente"
                                onclick="socket_answer('previous');"
                                id="bt_previous">
                                <h2><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></h2>
                            </button>
                            <button class="btn btn-default btn-xl btn_2_3 btn-yes"
                            onclick="socket_answer('yes');"
                            id="bt_yes">
                            <h2>OUI</h2>
                        </button>
                        <button class="btn btn-default btn-xl btn_2_3 btn-no"
                        onclick="socket_answer('no');"
                        id="bt_no">
                        <h2>NON</h2>
                    </button>
                    <button class="btn btn-default btn-xl btn_icon btn-default"
                    data-toggle="tooltip"
                    title="Je ne sais pas"
                    onclick="socket_answer('uncertain');"
                    id="bt_uncertain">
                    <h2><i class="fa fa-question-circle" aria-hidden="true"></i></h2>
                </button>
                <button class="btn btn-default btn-xl btn_icon btn-default"
                data-toggle="tooltip"
                title="'Oublier' = ne pas tenir compte de cette ligne du fichier source"
                onclick="socket_answer('forget_row');"
                id="bt_forget">
                <h2><i class="fa fa-times" aria-hidden="true"></i></h2>
            </button>
        </div>
    </div>
</div><!-- / row-->

</div>
</div><!-- / row-->

        </div><!-- / Partie principale -->
        <div class="col-md-3"><!-- Partie stats -->
            <div class="row" data-intro="Suivez ici les performances estimées. Quand celles çi sont satisfaisantes, passez à l'étape suivante">
                <div class="stat"
                    data-toggle="tooltip"
                    title="Informations sur la précision">
                    <span class="title">Précision estimée</span>
                    <span class="number" id="stat_estimated_precision">0 %</span>
                </div>

                <div class="stat"
                    data-toggle="tooltip"
                    title="Informations sur la couverture">
                    <span class="title">Couverture estimée</span>
                    <span class="number" id="stat_estimated_recall">0 %</span>
                </div>

                <!--
                <div class="stat"
                    data-toggle="tooltip"
                    title="L'avancement correspond au pourcentage du fichier déjà traité par la labellisation utilisateur.">
                    <span class="title">Avancement</span>
                    <span class="number" id="stat_real" style="display: inline;"></span>
                    sur
                    <span class="number" id="stat_real_nbrows" style="display: inline;"></span>
                </div>
                -->



                <div class="row stat yes_color">
                    <div class="col-md-12">
                        <div class="yes_color" style="border-radius: 5px;" data-toggle="tooltip" title="Nombre de réponses positives">
                            <span class="title">Nombre de OUI</span>
                            <span class="number" id="stat_nbyes">0</span>
                        </div>
                    </div>
                </div>

                <div class="row stat no_color">
                    <div class="col-md-12">
                        <div class="no_color" style="border-radius: 5px;" data-toggle="tooltip" title="Nombre de réponses négatives">
                            <span class="title">Nombre de NON</span>
                            <span class="number" id="stat_nbno">0</span>
                        </div>
                    </div>
                </div>

                        <div class="stat" style="display: none">
                            <span class="title">Historique des réponses</span>
                            <div class="history" id="stat_history">
                                <table class="table">
                                    <tr class="history_yes">
                                        <th class="title">OUI</th>

                                        <td id="yes_1"></td>
                                        <td id="yes_2"></td>
                                        <td id="yes_3"></td>
                                        <td id="yes_4"></td>
                                        <td id="yes_5"></td>
                                        <td id="yes_6"></td>
                                        <td id="yes_7"></td>
                                        <td id="yes_8"></td>
                                        <td id="yes_9"></td>
                                        <td id="yes_10"></td>
                                        <td id="yes_11"></td>
                                        <td id="yes_12"></td>
                                        <td id="yes_13"></td>
                                        <td id="yes_14"></td>
                                        <td id="yes_15"></td>
                                        <th class="total" id="stat_yes">0</th>

                                        <th rowspan="2" class="history_all" id="stat_all">0</th>
                                    </tr>
                                    <tr class="history_no">
                                        <th class="title">NON</th>

                                        <td id="no_1"></td>
                                        <td id="no_2"></td>
                                        <td id="no_3"></td>
                                        <td id="no_4"></td>
                                        <td id="no_5"></td>
                                        <td id="no_6"></td>
                                        <td id="no_7"></td>
                                        <td id="no_8"></td>
                                        <td id="no_9"></td>
                                        <td id="no_10"></td>
                                        <td id="no_11"></td>
                                        <td id="no_12"></td>
                                        <td id="no_13"></td>
                                        <td id="no_14"></td>
                                        <td id="no_15"></td>
                                        <th class="total" id="stat_no">0</th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                </div>
            </div><!-- / row-->
        </div><!-- / Partie stats -->
    </div>


    <!--<hr style="border-top: 3px dotted #777;">-->






</div><!-- container-fluid-->


<div class="container-fluid background_1" style="margin: 0 20px 0 20px; padding: 20px">
    <div class="row">
        <div class="col-xs-6">
            <button class="btn btn-success" id="bt_previous_page"><i class="fa fa-chevron-circle-left"></i> Précédent</button>
            <button class="btn btn-success2" id="bt_init_page"><span class="glyphicon glyphicon-refresh"></span> Recommencer l'apprentissage</button>
        </div>
        <div class="col-xs-6 text-right">
            <button class="btn btn-success" id="bt_next">Finir & Lancer le traitement <i class="fa fa-chevron-circle-right"></i></button>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="modal_filter_title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header background_2" style="color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_filter_title">Ajout de filtres</h4>
            </div>
            <div class="modal-body">
            <form id="form_words">
                <div class="form-group">
                    <label for="columns_filter">Colonne sur laquelle appliquer le filtre : </label>
                    <select class="form-control" id="columns_filter"></select>
                </div><!-- / form-group -->
                <div class="form-group">
                    <label for="text_filter">Filtre : </label>
                    <input type="text" class="form-control" placeholder="Text input" id="text_filter">
                </div><!-- / form-group -->
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-warning" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-xs btn-success2" id="bt_add_filter">Ajouter la valeur</button>
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
          <div class="page_explain">
              <b>
                  Dans la labellisation, l'utilisateur doit informer la machine si des paires de lignes (une de la source, une du référentiel) sont censées correspondre. La labellisation peut être utilisée pour deux utilisations:
                  <ul>
                      <li>Pour apprendre les paramètres optimaux pour effectuer une jointure automatique</li>
                      <li>Pour manuellement apparier un fichier entièrement (ce qui peut être beaucoup plus rapide que le "CTRL+F CTRL+C CTRL+V" dans Excel, par exemple).</li>
                  </ul>
              </b>
          </div>

          <h4>Réponses possibles</h4>
            <ul>
                <li>
                    oui: la paire montrée est un match
                </li>
                <li>
                    non: la paire montrée n'est pas un match
                </li>
                <li>
                    uncertain: je ne sais pas si la paire montrée est un match
                </li>
                <li>
                    oublier: cette ligne de la source ne devrait pas être matchée: ne pas la prendre en compte
                </li>
            </ul>

          <h4>Termes obligatoires / à exclure</h4>
          Ces filtres permettent de restreindre le fichier de référence pour le matching. Les termes obligatoires agissent comme des "ET", c'est à dire que les lignes proposées après le filtrage devront obligatoirement contenir toutes les informations dans les filtres. Les termes à exclure agissent comme des "OU", c'est à dire que les lignes proposées ne contiendront aucun des termes à exclure. Ces filtres peuvent être utiles pour augmenter la précision du matching sur une base beaucoup plus large que ce que l'on recherche. Par exemple, si l'on cherche des lycées dans la base SIRENE, on ajoutera le terme obligatoire "lycee" au champ "NOMEN_LONG"; on pourra aussi exclure le mot "parents" pour ne pas avoir dans les résultats "association de parents du lycée abc", par exemple...

          <h4>Recherche mot par mot. Comment et pourquoi ?</h4>
          Il est possible de rechercher des termes de la source mot à mot en cliquant dessus. Cette recherche annule temporairement les résultats générés par le labellisateur. Cette fonctionnalité peut être utile pour trouver un match plus rapidement qu’en attendant que le labellisateur le propose. Par ailleurs, si l’on constate qu’il n’y a pas de résultat par la recherche mot à mot et que ce mot, cela indique que les mots recherchés ne sont pas présents dans le référentiel; on peut alors “oublier” la ligne de la source.
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success3" data-dismiss="modal" onclick="javascript:introJs().setOption('showBullets', false).start();">Lancer le didacticiel</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                show_api_error(result, "API error - metadata");
            }
            else{
                console.log("success - metadata");console.dir(result);
                ret = result.metadata;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - metadata");
        }
    });// /ajax metadata

    return ret;
}// / get_metadata


function get_column_matches(project_id) {
    var ret = false;

    var tparams = {
        "data_params": {
            "module_name": "es_linker",
            "file_name": "column_matches.json"
        }
    }

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/download_config/link/' + project_id_link + '/',
        data: JSON.stringify(tparams),
        async: false,
        success: function (result) {
            if(result.error){
                show_api_error(result, "API error - download_config");
            }
            else{
                console.log("success - download_config");
                console.dir(result);
                ret = result.result;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - download_config");
        }
    });// /ajax - Download config

    return ret;
} // /get_column_matches()


function create_es_index_api() {

    var tparams = {
        "module_params": {
            "force": false
        }
    }

    $.ajax({
        type: 'POST',
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/create_es_index/' + project_id_link + '/',
        data: JSON.stringify(tparams),
        success: function (result) {

            if(result.error){
                show_api_error(result, "API error - create_es_index");
            }
            else{
                console.log("success - create_es_index_api");
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

                                // Chargement du labeller
                                create_es_labeller_api();
                            }
                            else{
                                console.log("success - job en cours");
                            }
                        },
                        error: function (result, status, error){
                            show_api_error(result, "job error");
                            err = true;
                            clearInterval(handle);
                        }
                    });// /ajax - job
                }, 1000);
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - create_es_index");
            err = true;
        }
    });// /ajax - create_es_labeller
}// create_es_labeller_api()


function create_es_labeller_api(force=false) {
    console.log("create_es_labeller_api");
    var tparams = {
        "module_params": {
            "force": force
        }
    }

    console.log(tparams);

    $.ajax({
        type: 'POST',
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/create_es_labeller/' + project_id_link + '/',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(tparams),
        success: function (result) {
            if(result.error){
                show_api_error(result, "API error - create_es_labeller_api");
            }
            else{
                console.log("success - create_es_labeller_api");
                console.log(result);

                // Appel
                var handle = setInterval(function(){
                    $.ajax({
                        type: 'get',
                        url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
                        success: function (result) {
                            if(result.completed){
                                clearInterval(handle);
                                console.log("success - job create_es_labeller_api");
                                console.log(result);

                                var answer_to_send = {'project_id': project_id_link}

                                load_labeller_api(project_id_link);
                                /*
                                console.log('socket.emit|load_labeller');
                                socket.emit('load_labeller', JSON.stringify(answer_to_send));
                                console.log('done');
                                */

                            }
                            else{
                                console.log("success - job en cours");
                            }
                        },
                        error: function (result, status, error){
                            show_api_error(result, "job error - create_es_labeller_api");
                            err = true;
                            clearInterval(handle);
                        }
                    });// /ajax - job
                }, 1000);
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - create_es_labeller_api");
            err = true;
        }
    });// /ajax - create_es_labeller
}// create_es_labeller_api()


function load_labeller_api(project_id_link) {
    $.ajax({
        type: 'GET',
        url: '<?php echo BASE_API_URL;?>' + '/api/link/labeller/current/' + project_id_link + '/',
        success: function (result) {
            if(result.error){
                show_api_error(result, "API error - load_labeller_api");
            }
            else{
                console.log("success - load_labeller_api");
                console.log(result);

                show_new_proposition(JSON.parse(result.result), "load_labeller");
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - load_labeller_api");
            err = true;
        }
    });// /ajax - load_labeller_api
}// /load_labeller_api()


function disabled_buttons() {
    $("#bt_yes").attr("disabled","disabled");
    $("#bt_no").attr("disabled","disabled");
    $("#bt_previous").attr("disabled","disabled");
    $("#bt_uncertain").attr("disabled","disabled");
    $("#bt_forget").attr("disabled","disabled");
}// /disabled_buttons()


function enabeled_buttons() {
    $("#bt_yes").removeAttr('disabled');
    $("#bt_no").removeAttr('disabled');
    $("#bt_previous").removeAttr('disabled');
    $("#bt_uncertain").removeAttr('disabled');
    $("#bt_forget").removeAttr('disabled');
}// /enabeled_buttons()


function socket_on_message() {
    // Message provenant du serveur

    socket.on('message', function(data) {
        show_new_proposition(JSON.parse(data), "on_message");
    });// / on
}// / socket_on_message()


function socket_answer(user_response) {
    // Envoi de la réponse utilisateur
    // Un nouveau message sera reçu par socket_on_message()

    disabled_buttons();

    $("#message").html('<img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">');

    var response_to_send = {
        "module_params": {
            "project_id": project_id_link,
            "user_input": user_response
        }
    }

    $.ajax({
        type: 'POST',
        url: '<?php echo BASE_API_URL;?>' + '/api/link/labeller/update/' + project_id_link + '/',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(response_to_send),
        success: function (result) {
            if(result.error){
                show_api_error(result, "API error - update");
            }
            else{
                console.log("success - update");
                console.log(result);

                show_new_proposition(JSON.parse(result.result), "labeller_update");

                // BUG Raffraichissement des Tooltips persistents
                hide_tooltips();
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - update");
            err = true;
        }
    });// /ajax - update
} // / socket_answer()


function socket_update_filters(must, must_not) {
    // Envoi de la réponse utilisateur
    // Un nouveau message sera reçu par socket_on_message()
    //must = {'NOMEN_LONG': ['ass', 'association', 'sportive', 'foyer'], 'LIBAPET': ['conserverie']}

    disabled_buttons();

    var response_to_send = {
        "module_params": {
            'must': must,
            'must_not': must_not
        }
    }

    $.ajax({
        type: 'POST',
        url: '<?php echo BASE_API_URL;?>' + '/api/link/labeller/update_filters/' + project_id_link + '/',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(response_to_send),
        success: function (result) {

            if(result.error){
                show_api_error(result, "API error - update_filters");
            }
            else{
                console.log("success - update_filters");
                console.log(result);

                show_new_proposition(JSON.parse(result.result), "update_filters");
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - update_filters");
            err = true;
        }
    });// /ajax - update_filters
} // / socket_update_filters()


function add_user_filters_api(user_filters, num_assoc) {
    // Envoi de la réponse utilisateur
    // {"module_params":
    // {
    // "search_params": [
    //     {"values_to_search":["Cabanis"], "columns":["denomination_principale_uai","patronyme_uai"]},
    //     {"values_to_search":["other", "values"], "columns":["other_column"]}
    //     ]}
    // }
    console.log('add_user_filters_api');

    disabled_buttons();

    var tab_search_params = new Array();
    //var tab_search_params = {};
    for(num_assoc in tab_by_num_assoc){
        //var tab_temp = new Array();
        var tab_temp = {};
        tab_temp["values_to_search"] = tab_by_num_assoc[num_assoc];
        tab_temp["columns"] = column_matches[num_assoc].ref;
        tab_search_params.push(tab_temp)
    }

    console.log(tab_search_params);
    var _to_send = {
        "module_params":
            {
                "search": tab_search_params
            }
        };

    console.log('data_to_send:');
    console.log(_to_send);
    console.log(JSON.stringify(_to_send));

    $.ajax({
        type: 'POST',
        url: '<?php echo BASE_API_URL;?>' + '/api/link/labeller/add_search/' + project_id_link + '/',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(_to_send),
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - add_search");
            }
            else{
                console.log("success - add_search");
                console.log(result);
                show_new_proposition(JSON.parse(result.result), "add_search");
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - add_search");
            err = true;
        }
    });// /ajax - add_search
} // / add_user_filters_api()


function delete_user_filter_api() {
    $.ajax({
        type: 'GET',
        url: '<?php echo BASE_API_URL;?>' + '/api/link/labeller/clear_search/' + project_id_link + '/',
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - clear_search");
            }
            else{
                console.log("success - clear_search");
                console.log(result);
                show_new_proposition(JSON.parse(result.result), "clear_search");
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - clear_search");
            err = true;
        }
    });// /ajax - clear_search
}// /delete_user_filter_api()


function show_new_proposition(message, from) {
    // Affiche les propositions en fonction du fichier column_matches
    console.log('show_new_proposition');
    console.log(message);
    console.log("from:" + from);

    // query_ranking = -1 si filtres utilisateur temporaires en cours
    if(message["query_ranking"] != -1){
        // Reset visuel des filtres utilisateur temporaires
        delete_user_filter_html(from);
    }

    // test du status
    if(!test_status(message["status"])){
        return false;
    }

    var lines_html = "<table>";
    // Parcours des associations faites a la page précédente
    for (var num_assoc = 0; num_assoc < column_matches.length; num_assoc++) {

        // Retours REFERENTIEL
        // Liste des colonnes associées
        var ref_list = column_matches[num_assoc].ref;
        var ref = new Array();
        var ref_keys = new Array();

        // Récupération de la valeur associée dans le message
        for (var k = 0; k < ref_list.length; k++) {
            var key = ref_list[k];
            var value = message["ref_item"]["_source"][key];
            ref.push(value);
            ref_keys.push(key);
        }
        // Concatenation des libellés
        var lib_ref_keys = ref_keys.join(" | ");
        var lib_ref_values = ref.join(" | ");


        // Retours SOURCE
        // Liste des colonnes associées
        var source_list = column_matches[num_assoc].source;
        var source = new Array();
        var source_keys = new Array();

        // Récupération de la valeur associée dans le message
        for (var j = 0; j < source_list.length; j++) {
            var key = source_list[j]; // ex departement
            var value = message["source_item"]["_source"][key];
            source_keys.push(key);

            // Séparation sur l'espace pour faire de chaque mot un lien cliquable
            var value_tab = value.split(' ');
            var value_temp = "";
            for (var k = 0; k < value_tab.length; k++) {
                // Traitement des guillements
                value_tab[k] = value_tab[k].replace('"' , '');
                value_tab[k] = value_tab[k].replace('"' , '');

                if(value_tab[k].indexOf("'") == 1){
                    // Cas quote après article. Ex : l'enseignement => l' ne sera pas cliquable
                    var article = value_tab[k].substr(0,2);
                    var mot_sans_article = value_tab[k].substr(2);
                    value_temp += article;
                    value_temp += '<a class="user_tag" onclick="add_user_filter(\'' + key + '\', \'' + mot_sans_article + '\',\'' + num_assoc + '\')">' + mot_sans_article + '</a> ';
                }
                else{
                    if(value_tab[k].indexOf("'") != -1){
                        // Ex : class'croute => les 2 mots doivent être cliquables
                        var tab_several_quote = value_tab[k].split("'");
                        for (var l = 0; l < tab_several_quote.length; l++) {
                            value_temp += "'";
                            value_temp += '<a class="user_tag" onclick="add_user_filter(\'' + key + '\', \'' + tab_several_quote[l] + '\',\'' + num_assoc + '\')">' + tab_several_quote[l] + '</a> ';
                        }
                    }
                    else{
                        // Cas sans quote
                        value_temp += '<a class="user_tag" onclick="add_user_filter(\'' + key + '\', \'' + value_tab[k] + '\',\'' + num_assoc + '\')">' + value_tab[k] + '</a> ';
                    }
                }
            }
            source.push(value_temp);
        }

        // Concatenation des libellés
        var lib_source_keys = source_keys.join(" | ");
        var lib_source_values = source.join(" | ");

        // Ecriture de la ligne Source
        lines_html += '<tr>';
        lines_html += '<td class="title"><i class="fa fa-table" aria-hidden="true"></i> ' + lib_source_keys + ' <i>(source)</i> :</td><td class="message">' + lib_source_values + '</td>';
        lines_html += '</tr>';


        // Ecriture de la ligne Ref
        lines_html += '<tr>';
        lines_html += '<td class="title"><i class="fa fa-database" aria-hidden="true"></i> ' + lib_ref_keys + ' <i>(referentiel)</i> :</td><td class="message">' + lib_ref_values + '</td>';
        lines_html += '</tr>';
        lines_html += '<tr><td colspan="2" class="hr"></td></tr>';
    }// Fin de parcours des associations

    // Affichage de la proposition
    lines_html += "</table>";

    // Affichage
    $("#message").html(lines_html);
    $("#stat_estimated_precision").html(show_stats(message.estimated_precision));
    $("#stat_estimated_recall").html(show_stats(message.estimated_recall));

    $("#stat_nbyes").html(message.num_pos);
    $("#stat_nbno").html(message.num_neg);

    enabeled_buttons();

    // Disabled du bt previous si pas de précédente proposition
    if(!message["has_previous"]){
        $("#bt_previous").attr("disabled","disabled");
    }

    // Mémorisation de la taille de la DIV pour la fixer
    h_message = $("#message").height();
    $("#message").css("min-height",h_message);
}// / show_new_proposition()


function show_stats(stat) {
    var ret = "";
    if(!stat){
       ret = '<span class="text">0 %</span>';
    }
    else {
        ret = Math.round(stat * 100);
        ret += " %";
    }

    return ret;
} // / show_stats()


function get_columns(metadata) {
    // Renvoie les colonnes présentent dans les métadata

    var all_columns = metadata['column_tracker']['original'];
    return all_columns;
}// / get_columns()


function complete_training() {
    // var _to_send = {'project_id': project_id_link}

    // console.log('socket.emit|complete_training');
    // socket.emit('complete_training', JSON.stringify(_to_send));
    // console.log('done');

    $.ajax({
        type: 'GET',
        url: '<?php echo BASE_API_URL;?>' + '/api/link/labeller/complete_training/' + project_id_link + '/',
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - complete_training");
            }
            else{
                console.log("success - complete_training");
                console.dir(result);

                // Passage à l'étape suivante
                window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + project_id_link;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - complete_training");
            err = true;
        }
    });// /ajax - complete_training
}// / complete_training()


function valid_step() {
    // Validation du training
    complete_training();
}// / valid_step()


function add_columns_filter(columns) {
    // Ajoute les colonnes du référentiel à la modal d'ajout de filtres
    for (var i = 0; i < columns.length; i++) {
        $('#columns_filter').append($("<option></option>")
                            .attr("value",columns[i])
                            .text(columns[i]));
    }
}// / add_columns_filter()


function show_modal_filter() {
    // Affiche la modale des filtres en la personnalisant en fonction de oblig ou excl

    if(modal_filter_sens == "oblig"){
        $("#modal_filter_title").html("Ajout des termes obligatoires");
    }
    else{
        $("#modal_filter_title").html("Ajout des termes à exclure");
    }

    // Affichage de la modale
    $('#modal_filter').modal('show');
}// / show_modal_filter()


function add_filter() {
    // Récupération de la colonne sélectionnée
    var column = $('#columns_filter option:selected').val();

    // Récupération du filtre
    var filter = $("#text_filter").val();

    // Ajout dans le bon tagsinput en fonction du bt cliqué initial (plus/minus)
    if(modal_filter_sens == "oblig"){
        sens = "plus";
    }
    else{
        sens = "minus";
    }

    var input_text = column + ":" + filter;

    // Ajout au tagsInput
    $("#filter_" + sens).tagsinput('add', input_text);

    // Fermeture de la modale
    $('#modal_filter').modal('hide');

    // Validation des filtres
    valid_filters();
}// /add_filter()


function add_buttons() {
    // Ajout des boutons

    $("#bt_start").click(function(){
        $("#entete").css("display", "none");
        $("#tempo").css("display", "none");
        $(".work").fadeToggle();
        $("#bt_next").fadeToggle();
    });

    $("#bt_next").click(function(){
        valid_step();
    });

    $("#bt_add_filter_plus").click(function(){
        modal_filter_sens = "oblig";
        show_modal_filter();
    });

    $("#bt_add_filter_minus").click(function(){
        modal_filter_sens = "excl";
        show_modal_filter();
    });

    $("#bt_add_filter")
        .keypress(function(event) {
            if ( event.which == 13 ) {
                add_filter();
            }
        })
        .click(function(){
            add_filter();
        });

    $("#form_words").submit(function(event) {
        event.preventDefault();
        add_filter();
    });

    $("#bt_yes").click(function(){
        stat_yes += 1;
        stat_all += 1;

        tab_stat_yes.push(1);
        tab_stat_no.push(0);

        update_stat();
    });
    $("#bt_no").click(function(){
        stat_no += 1;
        stat_all += 1;

        tab_stat_yes.push(0);
        tab_stat_no.push(1);

        update_stat();
    });
    $("#bt_previous").click(function(){
        // Récupération du dernier pour décompptes
        if(tab_stat_yes[tab_stat_yes.length - 1]){
            stat_yes -= 1;
        }
        if(tab_stat_no[tab_stat_no.length - 1]){
            stat_no -= 1;
        }

        stat_all -= 1;

        // On efface la "colonne" html correspondante
        $("#yes_" + tab_stat_yes.length).html("");
        $("#no_" + tab_stat_yes.length).html("");

        // Suppression des dernières valeurs comme "bt back"
        tab_stat_yes.pop();
        tab_stat_no.pop();

        // MAJ html
        update_stat();
    });

    $("#bt_help").click(function(){
        $('#modal_help').modal('show');
    });

    $("#bt_previous_page").click(function(){
        to_previous_page();
    });

    $("#bt_init_page").click(function(){
        init_page();
    });

} // / add_buttons()


function init_page() {
    create_es_labeller_api(true);
}


function to_previous_page() {
    // Test du filename, on ne doit pas ecrire sur le MINI
    var file_name_temp = metadata_link['files']['source']['file_name'];
    if(file_name_temp.substr(0,6) === 'MINI__' ){
        file_name_temp = file_name.substr(6);
    }

    // Paramètres API
    // module_name : INIT,add_selected_columns,upload_es_train,es_linker,link_results_analyzer
    tparams = {
        "data_params": {
            "module_name": "add_selected_columns",
            "file_name": file_name_temp
        },
        "module_params": {
            "property": "completed",
            "value": false
        }
    }
    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/set_log_property/link/' + project_id_link,
        data: JSON.stringify(tparams),
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - set_log_property");
            }
            else{
                console.log("success - set_log_property");
                console.log(result);

                // Chargement de la page précédente (rappel du controller)
                location.reload();
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - set_log_property");
        }
    });// /ajax - set_log_property
} // /to_previous_page()


function update_stat() {
    // Compteurs
    $("#stat_yes").html(stat_yes);
    $("#stat_no").html(stat_no);
    $("#stat_all").html(stat_all);

    /*
    $("#stat_nbyes").html(stat_yes);
    $("#stat_nbno").html(stat_no);
    */

    // Avancement
    // var ret = Math.round(stat_all / src_nrows);
    //     ret += " %";
    // $("#stat_real_ratio").html(ret);

    // $("#stat_real").html(stat_all);
    // $("#stat_real_nbrows").html(src_nrows);

    // Historiques
    // Yes
    var max = tab_stat_yes.length;
    if(max >= 15){
        max = 15;
    }
    var first = tab_stat_yes.length - max;
    max = first + max;
    var cpt = 1;

    for (var i = first; i < max; i++) {
        if(tab_stat_yes[i] == 1){
            $("#yes_" + cpt).html('<i class="fa fa-circle" aria-hidden="true"></i>');
            $("#no_" + cpt).html('&nbsp;');
        }
        else{
            $("#no_" + cpt).html('<i class="fa fa-circle" aria-hidden="true"></i>');
            $("#yes_" + cpt).html('&nbsp;');
        }
        cpt ++;
    }

}// /update_stat()


function valid_filters() {
    // Traitement des termes obligatoires
    must = get_obj_filters($("#filter_plus").val());

    // Traitement des termes à exclures
    must_not = get_obj_filters($("#filter_minus").val());

    // Appel
    socket_update_filters(must, must_not);
} // / valid_filters()


function get_obj_filters(filter_list) {
    // Prend une liste string en entrée et retourne un objet structuré par colonne
    //{'NOMEN_LONG': ['ass', 'association', 'sportive', 'foyer'], 'LIBAPET': ['conserverie']}

    var tab_by_columns = new Array();

    // regroupement par colonne
    var tab_input_user = filter_list.split(",");
    for (var i = 0; i < tab_input_user.length; i++) {
        var tab_col_val = tab_input_user[i].split(":");
        var column_name = tab_col_val[0];
        var value = tab_col_val[1];

        if(!(column_name in tab_by_columns)){
            tab_by_columns[column_name] = new Array();
        }
        tab_by_columns[column_name].push(tab_col_val[1]);
    }

    // Parcours du tableau pour renvoyer l'objet
    var obj = new Object();
    for(var key in tab_by_columns){
        obj[key] = tab_by_columns[key];
    }

    if(Object.keys(obj) == ""){
        return {};
    }

    return obj;
}// / get_obj_filters()


function hide_tooltips(){
    $('#bt_previous').tooltip('hide');
    $('#bt_uncertain').tooltip('hide');
    $('#bt_forget').tooltip('hide');
}// / hide_tooltips()

$(function(){// ready
    // Compteurs
    stat_yes = 0;
    stat_no = 0;
    stat_all = 0;

    // Historiques
    tab_stat_yes = new Array();
    tab_stat_no = new Array();

    $("body").css("height", $(window).height());

    modal_filter_sens = ""; // est utlisé pour savoir si l'on est en exclusion ou en label obligatoire (oblig, excl)

    // Ajout des boutons
    add_buttons();

    disabled_buttons();

    project_id_link = "<?php echo $_SESSION['link_project_id'];?>";

    // Récupération des metadata du projet de link en cours
    metadata_link = get_metadata('link', '<?php echo $_SESSION['link_project_id'];?>');

    // MAJ du nom du projet
    // $("#project_name1").html(metadata_link.display_name);
    // $("#project_name2").html(metadata_link.display_name);

    // MAJ du nom du projet
    $("#page_title_project_name").html(metadata_link.display_name + " : ");

    // Récupération des ids des projets de normalisation
    project_id_src = metadata_link['files']['source']['project_id'];
    project_id_ref = metadata_link['files']['ref']['project_id'];

    // Récupérartion des métadata du fichier source
    metadata_src = get_metadata('normalize', project_id_src);

    // Récupérartion des métadata du fichier referentiel
    metadata_ref = get_metadata('normalize', project_id_ref);

    // Récupération des colonnes référentiel
    var columns_ref = get_columns(metadata_ref);

    //Ajoute les colonnes du référentiel à la modal d'ajout de filtres
    add_columns_filter(columns_ref);

    // Récupération du nombre total de lignes
    src_nrows = metadata_src.files[Object.keys(metadata_src.files)].nrows;

    // Récupération des matches
    column_matches = get_column_matches();

    // Connect to socket
    // var socket = io.connect('http://' + document.domain + ':' + location.port + '/');
    //socket = io.connect('<?php echo BASE_API_URL;?>');

    // Création des indexs Elastic Search
    create_es_index_api();

    // Ecoute socket
    //socket_on_message();

    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();
});//ready
</script>
