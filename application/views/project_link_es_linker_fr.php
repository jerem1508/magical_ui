<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid background_1" id="entete" style="padding-bottom: 20px;margin-left:20px;margin-right:20px;">
    <div class="row">
        <div class="col-md-11">
            <h2 style="margin-top: 5px;">
                <span class="step_numbers"><i class="fa fa-chevron-circle-right"></i></span>
                &nbsp;Résultat de la jointure
            </h2>
        </div>
        <div class="col-md-1 text-right">
            <button type="button" id="bt_help" class="btn btn-success3">AIDE</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11">
            Les résultats sont affichés dans l'ordre du fichier source. Pour chaque ligne on montre les éléments de la source (pour les colonnes qui servent au match) ainsi que les éléments de la ligne de la référence qui sont proposées comme match. Le score indique la confiance de la machine dans le match et le bouton Vrai/Faux indique si la machine pense que la ligne montrée est effectivement un match (en fonction du score).
            <br />
            <br />
            Toutes les modifications seront prises en compte dans le fichier téléchargeable.
        </div>
        <div class="col-md-1 text-right" id="pagination"></div>
    </div>
    <div id="result">
        <div class="row text-center">
            <img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">
            <h3>Le traitement peut prendre quelques minutes, veuillez patienter ...</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-8 col-md-4 text-right" id="pagination2"></div>
    </div>

    <hr style="border-top: 4px dashed #ddd;">

    <div class="row" id="stats">
        <div class="col-xs-offset-3 col-xs-2">
            <div class="stat"
                data-toggle="tooltip"
                title="Nombre de lignes traitées">
                <span class="title">Lignes traitées</span>
                <span class="number" id="stat_nb_lines">0</span>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="stat"
                data-toggle="tooltip"
                title="Pourcentage de lignes traitées">
                <span class="title">Lignes traitées</span>
                <span class="number" id="stat_pct_nb_lines">0 %</span>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="stat"
                data-toggle="tooltip"
                title="Pourcentage de lignes traitées">
                <span class="title">Match problable</span>
                <span class="number" id="stat_pct_nb_match">0 %</span>
            </div>
        </div>
    </div>

    <hr style="border-top: 4px dashed #ddd;">

    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-success" id="bt_previous_page"><i class="fa fa-chevron-circle-left"></i> Précédent</button>
        </div>
        <div class="col-md-10 text-right">
            <button class="btn btn-success2" id="bt_re_treatment" style="visibility: hidden"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Relancer le traitement</button>
            <button class="btn btn-success2" id="dl_file" disabled><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier final</button>
        </div>
    </div>
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
          <h4>Comment lire ?</h4>
            On affiche les lignes dans l'ordre du fichier source. Pour chaque ligne on montre les éléments de la source (pour les colonnes qui servent au match) ainsi que les éléments de la ligne de la référence qui sont proposées comme match. Le score indique la confiance de la machine dans le match et le bouton Vrai/Faux indique si la machine pense que la ligne montrée est effectivement un match (en fonction du score).

          <h4>Score et seuil</h4>
            Les résultats sont renvoyés avec un score correspondant au score Elasticsearch. Le seuil détermine le score à partir duquel la machine estime qu'une paire de lignes est un match

          <h4>Vrai / Faux</h4>
            Les boutons indiquent par défaut si la machine suppose que la paire montrée est un match (quand la machine ne trouve pas de match, elle peut renvoyer ce qu'elle considère comme le meilleur candidat). L'utilisateur peut modifier la valeur Vrai/Faux pour indiquer qu'une paire est effectivement un match (Vrai) ou non (Faux). Cela se retrouvera lors du téléchargement du fichier...

          <h4>Le fichier de sortie</h4>
            Le fichier de sortie présente autant de lignes que votre fichier source. Toutes les colonnes du fichier source sont présentes. Par ailleurs, les colonnes du référentiel sont aussi présentes sous leur nom original suivi du suffix “__REF” (par exemple: “adresse_REF”); pour chaque ligne, lorsqu’un match a été trouvé, les valeurs correspondantes du référentiel se trouvent dans ces colonnes. Par ailleurs nous créons les colonnes suivantes:
          <ul>
              <li>
                <strong>__CONFIDENCE</strong>: La confiance que nous accordons au match présenté. Dans notre machine, les résultats avec une confiance au dessus de 1 sont considérés comme des matchs. Les lignes pour lesquelles la confiance vaut 999 correspondent à des lignes labellisées comme étant des matchs par l’utilisateur.
              </li>
              <li>
                <strong>__IS_MATCH</strong>: Vaut 1 si la machine pense que la paire présentée est une match valide. Si elle vaut 0, c’est que c’est que les valeurs trouvées pour la référence sont les meilleurs à proposer mais que la machine ne pense pas que le match est valide.
              </li>
              <li>
                <strong>__ID_REF</strong>: Identifiant interne associé à la ligne de la référence. Peut être utile pour des jointures croisées de 2 fichiers sales.
              </li>
              <li>
                <strong>__ID_QUERY</strong>: L’identifiant de la methode utilisée pour le match (spécifique à chaque projet de jointure). Peut être utile pour faire des distinctions de cas si vous observez des performances fluctuantes selon cette variable.
              </li>
              <li>
                <strong>__ES_SCORE</strong>: Le score original de la requête Elasticsearch avec la méthode (<strong>__ID_QUERY</strong>) choisie pour la ligne en question.
              </li>
              <li>
                <strong>__THRESH</strong>: Le seuil (relatif au score <strong>__ES_SCORE</strong>) pour la méthode (<strong>__ID_QUERY</strong>) utilisé pour la machine pour déterminer la confiance (<strong>__CONFIDENCE</strong>) et si le match est valide (<strong>__IS_MATCH</strong>)
              </li>
          </ul>
      </div>

      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-success3" data-dismiss="modal" onclick="javascript:introJs().setOption('showBullets', false).start();">Lancer le didacticiel</button> -->
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
                show_api_error(result.error, "API error");
            }
            else{
                console.log("success - metadata");console.log(result);
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
                show_api_error(result.error, "API error - download_config");
            }
            else{
                console.log("success - download_config");
                console.log(result);
                ret = result.result;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - download_config");
        }
    });// /ajax - Download config

    return ret;
} // /get_column_matches()


function get_learned_setting(project_id) {
    var ret = false;

    var tparams = {
        "data_params": {
            "module_name": "es_linker",
            "file_name": "learned_settings.json"
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
                show_api_error(result.error, "API error - download_config");
            }
            else{
                console.log("success - download_config");
                console.log(result);
                ret = result.result;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - download_config");
        }
    });// /ajax - Download config

    return ret;
} // /get_column_matches()


function get_thresh(project_id) {
    // Récupere le contenu d'un fichier runInfo via API
    console.log('get_learned_settings()');

    var ret = 0;

    var tparams = {
        "data_params": {
            "module_name": "es_linker",
            "file_name": "learned_settings.json"
        }
    }

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/download_config/link/' + project_id + '/',
        data: JSON.stringify(tparams),
        async: false,
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - download_config");
            }
            else{
                console.log("success - download_config");
                console.log(result);

                ret = result.result.best_thresh;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - download_config");
        }
    });// /ajax - Download config
    return ret;
} // /get_thresh()


function get_data(from, size) {
    var ret = "get_data()";
    var tparams = {
        "module_params": {
            "size": size,
            "from": from
        }
    }

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/es_fetch_by_id/link/' + project_id_link,
        data: JSON.stringify(tparams),
        async: false,
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - get_data");
            }
            else{
                console.log("success - get_data");
                console.log(result);
                ret = result.responses;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - get_data");
        }
    });// /ajax
    return ret;
}// /get_data()


function show_data_html(data, start) {
    console.log('show_data_html:data');

    var html = '<table class="table">';

    // Entete
    html += '<tr class="table_header">';
    html += '    <td colspan="2"><i class="fa fa-table" aria-hidden="true"></i> (<i>Source</i>)</td>';

    for (var i = 0; i < column_matches.length; i++) {
        var source_list = column_matches[i].source;
        html += '    <th>' + source_list + '</th>';
    }

    html += '    <th rowspan="2" class="text-center">Confiance<br><i>Seuil : ' + precision_Round(thresh,2) + '</i></th>';
    html += '    <th rowspan="2" class="text-center">Correspondances<br>valides</th>';
    html += '</tr>';
    html += '<tr class="table_header">';
    html += '    <td colspan="2"><i class="fa fa-database" aria-hidden="true"></i> (<i>Référentiel</i>)</td>';

    for (var i = 0; i < column_matches.length; i++) {
        var ref_list = column_matches[i].ref;
        html += '    <th>' + ref_list + '</th>';
    }
    html += '</tr>';

    for (var i = 0; i < data.length; i++) {
        if(data[i].hits.hits.length == 0){
            continue;
        }
        // Récupération id_source/id_ref
        var id_source = data[i].hits.hits[0]['_id'];
        var id_ref = data[i].hits.hits[0]['_source']["__ID_REF"];

        var no_line = start + i + 1;
        html += '<tr class="line_' + no_line + '" style="border-top: solid #333 2px;">';
        html += '    <td rowspan="2" class="text-center no_line"><h4 class="value_vcentered ' + no_line + '">' + no_line + '</h4></td>';

        // Récupération de l'indice de confiance
        var confidence = data[i].hits.hits[0]['_source']['__CONFIDENCE'];
        html += '    <td><i class="fa fa-table" aria-hidden="true"></i></td>';

        // Parcours des termes SOURCE ---------------------------------------------
        for (var j = 0; j < column_matches.length; j++) {
            var ch = column_matches[j].source.toString();
            var tab_termes = ch.split(",");

             var tab_values = new Array();

            for (var k = 0; k < tab_termes.length; k++) {
                tab_values.push(data[i].hits.hits[0]['_source'][tab_termes[k]]);
            }

            var values = tab_values.join(", ");
            html += '    <td>' + values + '</td>';
        }

        if(confidence == 999 || confidence == 0){
            html += '<td rowspan="2" class="text-center"><h4 class="confidence_vcentered">';
            html += '<i class="fa fa-user-circle" aria-hidden="true" title="Labellisation manuelle utiisateur" data-toggle="tooltip"></i>';
            html += '<h4></td>';
        }
        else{

            html += '<td rowspan="2" class="text-center"><h4 class="confidence_vcentered" id="confidence_' + no_line + '">' + precision_Round(confidence,2) + '<h4></td>';
        }
        // Affichage du bouton
        html += '<td rowspan="2" class="text-center padding_0"><h4 class="action_vcentered" style="display: inline;">';

        if(confidence != null){
            html += '<input id="chk_' + no_line + '" type="checkbox" class="chk" id_source="' + id_source + '" id_ref="' + id_ref + '"';
            if(confidence >= thresh){
                html += ' checked '
            }
            html += '>';
            html += '&nbsp;&nbsp;';
            html += '<a onclick="delete_line(\'' + no_line + '\');" class="icon" id="del_line_' + no_line + '">';
            html += '<i class="fa fa-times" aria-hidden="true"></i>';
            html += '</a></h4>';
        }
        html += '</td>';
        html += '</tr>';

        // Ligne REF
        html += '<tr class="' + no_line + '">';

        // Parcours des termes du REF --------------------------------------------
        html += '    <td><i class="fa fa-database" aria-hidden="true"></i></td>';
        for (var j = 0; j < column_matches.length; j++) {
            var ch = column_matches[j].ref.toString();
            var tab_termes = ch.split(",");

            var tab_values = new Array();

            for (var k = 0; k < tab_termes.length; k++) {
                tab_values.push(data[i].hits.hits[0]['_source'][tab_termes[k] + '__REF']);
            }

            var values = tab_values.join(", ");
            if(values == ", "){
                values = "";
            }
            html += '    <td>' + values + '</td>';
        }

        html += '</tr>';
    }// /for - parcours data

    html += '</table>';
    //html += '</div>';

    // Affichage des données
    $("#result").html(html);

    // MAJ des boutons on/off (boostrap-toggle)
    for (var i = 0; i < data.length; i++) {
        var no_line = start + i + 1;

        $('.chk').bootstrapToggle({
          on: 'Vrai',
          off: 'Faux',
          onstyle: 'success3',
          offstyle: 'success',
          size: 'small'
        });

        // Action sur changement de la case a cocher
        $('#chk_' + no_line).change(function(){
            // console.log($(this).prop('checked'));
            // console.log($(this).attr('id_source'));
            // console.log($(this).attr('id_ref'));
            update_results_api( $(this).attr('id_source'),
                                $(this).attr('id_ref'),
                                $(this).prop('checked'));
        });
    }// /for


    // Séparation visuelle des lignes
    $(".line").css("border-top","2px solid #ccc");

    // TD plus petit
    $("td").css("padding", "2px");
    $(".padding_0").css("padding-top", "10px");

    // Actions
    $(".chk").change(function() {
        // Récupération des ids
        var _id = $(this);
        var id = _id[0]["id"];
        var id_source = $("#" + id).attr("id_source");
        var id_ref = $("#" + id).attr("id_ref");

        // Vérification de la présence de ses ids dans les exact_pairs
        present_exact_pairs = keys_are_present(id_source, id_ref, learned_setting_json.exact_pairs);

        // Vérification de la présence de ses ids dans les non_matching_pairs
        present_non_matching_pairs = keys_are_present(id_source, id_ref, learned_setting_json.non_matching_pairs);

        // Suivant le sens de la checkbox, on ajoute a non_matching_pairs ou a exact_pairs
        if(_id[0]["checked"]){
            if(!present_exact_pairs){
                // Ajout
                var exact_pairs = learned_setting_json.exact_pairs;
                delete learned_setting_json.exact_pairs;
                exact_pairs[exact_pairs.length] = new Array(id_source, id_ref);
                learned_setting_json['exact_pairs'] = exact_pairs;
            }
            if(present_non_matching_pairs){
                // Suppression
                var non_matching_pairs = learned_setting_json.non_matching_pairs;
                var new_non_matching_pairs = new Array();
                for (var i = 0; i < non_matching_pairs.length; i++) {
                    if(non_matching_pairs[i][0] != id_source && non_matching_pairs[i][1] != id_ref){
                        var item = new Array(non_matching_pairs[i][0], non_matching_pairs[i][1]);
                        new_non_matching_pairs.push(item);
                    }
                }
                delete learned_setting_json.non_matching_pairs;
                learned_setting_json['non_matching_pairs'] = new_non_matching_pairs;
            }
        }
        else{
            if(present_exact_pairs){
                // Suppression
                var exact_pairs = learned_setting_json.exact_pairs;
                var new_exact_pairs = new Array();
                for (var i = 0; i < exact_pairs.length; i++) {
                    if(exact_pairs[i][0] != id_source && exact_pairs[i][1] != id_ref){
                        var item = new Array(exact_pairs[i][0], exact_pairs[i][1]);
                        new_exact_pairs.push(item);
                    }
                }
                delete learned_setting_json.exact_pairs;
                learned_setting_json['exact_pairs'] = new_exact_pairs;
            }
            if(!present_non_matching_pairs){
                // Ajout
                var non_matching_pairs = learned_setting_json.non_matching_pairs;
                delete learned_setting_json.non_matching_pairs;
                non_matching_pairs[non_matching_pairs.length] = new Array(id_source, id_ref);
                learned_setting_json['non_matching_pairs'] = non_matching_pairs;
            }
        }

        // Affichage du logo utilisateur
        var id_temp = parseInt(id_source) + 1;
        $("#confidence_" + id_temp).html('<i class="fa fa-user-circle"></i>');

        // Upload du fichier modifié
        // TODO
        console.log(learned_setting_json);
        // Affichage du bouton de nouveau traitement
        $("#bt_re_treatment").css("visibility", "visible");
    });

    // Boutons de pagination
    set_pagination_html(src_nrows, pas, 1);

    // Bt de telechargement accessible
    $("#dl_file").prop('disabled', false);
}// /show_data_html()


function delete_line(no_line) {
    if($("#del_line_" + no_line).hasClass("delete_line")){
        // undelete
        $("#del_line_" + no_line).removeClass("delete_line");
        $("." + no_line).css("color", "#333");
        $("." + no_line).css("font-style", "normal");
        $("#chk_" + no_line).bootstrapToggle('enable');
        $("#del_line_" + no_line).html('<i class="fa fa-times" aria-hidden="true"></i>');

        // undelete de la ligne API
        // TODO

    }
    else{
        // delete
        $("#del_line_" + no_line).addClass("delete_line");
        $("." + no_line).css("color", "#ccc");
        $("." + no_line).css("font-style", "italic");
        $("#chk_" + no_line).bootstrapToggle('disable');
        $("#del_line_" + no_line).html('<i class="fa fa-undo" aria-hidden="true"></i>');

        // Suppression de la ligne API
        // TODO

    }
}// /delete_line()


function keys_are_present(id_source, id_ref, data) {
    for (var i = 0; i < data.length; i++) {
        if(data[i][0]==id_source && data[i][1]==id_ref){
            return true;
        }
    }
    return false;
}// /keys_are_present()


function action(id_source, id_ref, ele) {
    alert(id_source + "|" + id_ref);
    console.log('action():' + id_source + "|" + id_ref + "" + ele);
}// /action()


function create_es_index_api() {
    console.log('create_es_index_api');
    // Creer pour pouvoir accéder aux données de facon paginée
    var tparams = {
        "module_params": {
            "for_linking": false,
            "force": true
        }
    }

    $.ajax({
        type: 'POST',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/create_es_index/' + project_id_link + '/',
        data: JSON.stringify(tparams),
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - create_es_index_api");
            }
            else{
                console.log("success - create_es_index_api");
                console.log(result);

                // Appel
                var handle = setInterval(function(){
                    $.ajax({
                        type: 'get',
                        url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
                        success: function (result) {
                            if(result.completed){
                                clearInterval(handle);
                                console.log("success - job");
                                console.log(result);

                                // Récupération des données paginées + affichage
                                var start = 0;
                                var data = get_data(start, pas);

                                show_data_html(data, start);
                            }
                            else{
                                console.log("success - job en cours");
                            }
                        },
                        error: function (result, status, error){
                            show_api_error(result, "error job create_es_index_api");
                            err = true;
                            clearInterval(handle);
                        }
                    });// /ajax - job
                }, 1000);
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error create_es_index_api");
            err = true;
        }
    });// /ajax - create_es_labeller
}// create_es_labeller_api()


function update_results_api(source_id, ref_id, is_match) {
    var tparams = {
        "module_params": {
            "labels":  [{'source_id': source_id,  'ref_id': ref_id, 'is_match': is_match}]
        }
    }

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/link/update_results/' + project_id_link + "/",
        data: JSON.stringify(tparams),
        async: false,
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - update_results");
            }
            else{
                console.log("success - update_results");
                console.log(result);
            }// / lastwritten - success
        },
        error: function (result, status, error){
            show_api_error(result, "error - update_results");
            err = true;
        }
    });// /ajax - last_written
}// /update_results_api()


function treatment(project_id_link, learned_setting_json, force) {
    var file_name_src = metadata_link['files']['source']['file_name'];
    var exist_es_linker = metadata_link['log'][file_name_src]['es_linker']['completed'];

    // Test de l'existence du module ES_LINKER
    // Appel du LINKER seulement s'il n'existe pas
    if(!exist_es_linker || force){
        es_linker_api(project_id_link, learned_setting_json);
    }
    else{// Affichage seul
        console.log("Pas de Linker ES");
        var start = 0;

        // Récupération du seuil
        thresh = get_thresh(project_id_link);

        // Récupération des données paginées
        var data = get_data(start, pas);

        // Affichage
        show_data_html(data, start);

        // Statistiques
        get_stats();
    }

}// /treatment()


function es_linker_api(project_id_link, learned_setting_json) {
    var tparams = {
        "module_params": learned_setting_json
    }
    $.ajax({
        type: 'post',
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/es_linker/' + project_id_link + '/',
        contentType: "application/json; charset=utf-8",
        traditional: true,
        data: JSON.stringify(tparams),
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - es_linker");
            }
            else{
                console.log("success - es_linker");
                console.log(result);

                // Appel
                var handle = setInterval(function(){
                    $.ajax({
                        type: 'get',
                        url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
                        success: function (result) {
                            console.log('result :');
                            console.log(result);

                            if(result.completed){
                                clearInterval(handle);
                                console.log("success - job");
                                console.log(result);

                                // Récupération du seuil
                                thresh = get_thresh(project_id_link);

                                // Création de l'index
                                create_es_index_api();

                                // Statistiques
                                get_stats();
                            }
                            else{
                                console.log("es_linker - job en cours");
                            }
                        },
                        error: function (result, status, error){
                            show_api_error(result, "error job - es_linker");
                            err = true;
                            clearInterval(handle);
                        }
                    });// /ajax - job
                }, 1000);
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - es_linker");
            err = true;
        }
    });// /ajax - es_linker

}// /es_linker_api()


function valid_step() {
    // Validation du training
    complete_training();

    // Passage à l'étape suivante
    window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + project_id_link;
}// / valid_step()


function add_buttons() {
    // Ajout des actions sur les boutons

    $("#dl_file").click(function(){
        tparams = {
            "data_params": {
                "module_name": "es_linker",
                "file_name": file_name
            }
        }
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_API_URL;?>' + '/api/download/link/' + project_id_link,
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(tparams),
            success: function (result_dl) {
                if(result_dl.error){
                    show_api_error(result_dl, "API error - dl");
                }
                else{
                    console.log("success - dl");

                    // DL du fichier
                    var blob = new Blob([result_dl]);
                    var link = document.createElement('a');
                    document.body.appendChild(link);
                    link.href = window.URL.createObjectURL(blob);
                    link.download = file_name;
                    link.click();
                }
            },
            error: function (result_dl, status, error){
                show_api_error(result_dl, "error - dl");
                err = true;
                clearInterval(handle);
            }
        });// /ajax
    }); // /dl_file.click()

    $("#bt_re_treatment").click(function(){
        // On vide les data actuelles + affichage du wait
        var html = '<div class="row text-center">';
        html += '<img src="<?php echo base_url('assets/img/wait.gif');?>" style="width: 50px;">';
        html += '<h3>Le traitement peut prendre quelques minutes, veuillez patienter ...</h3>';
        html += '</div>';
        $("#result").html(html);

        // Lancement du traitement avec force = true
        treatment(project_id_link, learned_setting_json, true);
    });

    $("#bt_previous_page").click(function(){
        to_previous_page();
    });

    $("#bt_help").click(function(){
        $('#modal_help').modal('show');
    });
}// /add_buttons()


function set_pagination_html(nrows, pas, current_page) {
    // MAJ de la pagination
    npages = Math.ceil(nrows / pas);

    var html = '';
    html += '<nav aria-label="Page navigation">';
    html += '  <ul class="pagination">';

    // Bouton précédent ------------------
    if(current_page == 1){
        // On disable le bouton précédent
        html += '    <li class="disabled">';
        html += '      <a href="#">';
        html += '        <span>&laquo;</span>';
        html += '      </a>';
        html += '    </li>';
    }
    else{
        var previous = current_page - 1;
        html += '    <li>';
        html += '      <a onclick="load_data(' + nrows + ',' + pas + ',' + previous + ');">';
        html += '        <span>&laquo;</span>';
        html += '      </a>';
        html += '    </li>';
    }

    if(current_page > 1 && current_page < npages){
        // Milieu
        // TODO ???
    }

    // Bouton suivant -------------------------
    if(current_page == npages){
        // On disable le bouton suivant
        html += '    <li class="disabled">';
        html += '      <a href="#">';
        html += '        <span>&raquo;</span>';
        html += '      </a>';
        html += '    </li>';
    }
    else{
        var next = current_page + 1;
        html += '    <li>';
        html += '      <a onclick="load_data(' + nrows + ',' + pas + ',' + next + ');">';
        html += '        <span>&raquo;</span>';
        html += '      </a>';
        html += '    </li>';
    }

    html += '  </ul>';
    html += '</nav>';

    var start = (current_page - 1) * pas + 1;
    var end = start + pas -1;
    var html_1 = html + '<div>De ' + start + ' à ' + end + ' sur ' + nrows + ' lignes</div>';
    var html_2 = '<div>De ' + start + ' à ' + end + ' sur ' + nrows + ' lignes</div>' + html;

    $("#pagination").html(html_1);
    $("#pagination2").html(html_2);
}// /set_pagination_html()


function load_data(nrows, pas, current_page) {
    console.log('load_data()');

    var start = (current_page - 1) * pas;
    console.log('start:' + start);

    var data = get_data(start, pas);

    // Affichage des données
    show_data_html(data, start);

    // Scroll-up
    go_to_speed("pagination", 500);

    // MAJ de la pagination
    set_pagination_html(nrows, pas, current_page);
}// /load_data()


function get_stats() {
    console.log('get_stats()');
    // Récupération ds stats
    var tparams = {
        "data_params": {
            "module_name": "es_linker",
            "file_name": file_name
        }
    }

    $.ajax({
        type: 'POST',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/link_results_analyzer/' + project_id_link + '/',
        data: JSON.stringify(tparams),
        success: function (result) {
            if(result.error){
                show_api_error(result.error, "API error - link_results_analyzer_api");
            }
            else{
                console.log("success - link_results_analyzer_api");
                console.log(result);

                // Appel
                var handle = setInterval(function(){
                    $.ajax({
                        type: 'get',
                        url: '<?php echo BASE_API_URL;?>' + result.job_result_api_url,
                        success: function (result) {
                            if(result.completed){
                                clearInterval(handle);
                                console.log("success - job");
                                console.log(result);

                                // Récupération des données + affichage
                                set_stats_html(result);
                            }
                            else{
                                console.log("success - job en cours");
                            }
                        },
                        error: function (result, status, error){
                            show_api_error(result, "API job error - link_results_analyzer_api");
                            err = true;
                            clearInterval(handle);
                        }
                    });// /ajax - job
                }, 1000);
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - link_results_analyzer_api");
            err = true;
        }
    });// /ajax - link_results_analyzer
}// /get_stats()


function set_stats_html(stats) {
    // MAJ des stats
    $("#stat_pct_nb_lines").html(Math.round(stats.result.perc_match) + " %");
    $("#stat_pct_nb_match").html(Math.round(stats.result.perc_match_thresh) + " %");
    $("#stat_nb_lines").html(stats.result.num_match);
}// /set_stats_html()


function set_log_property_api(module_name) {
    // Test du filename, on ne doit pas ecrire sur le MINI
    var file_name_temp = metadata_link['files']['source']['file_name'];
    if(file_name_temp.substr(0,6) === 'MINI__' ){
        file_name_temp = file_name.substr(6);
    }

    // Paramètres API
    // module_name : INIT,add_selected_columns,upload_es_train,es_linker,link_results_analyzer
    tparams = {
        "data_params": {
            "module_name": module_name,
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
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - set_log_property");
        }
    });// /ajax - set_log_property
}


function to_previous_page() {
    set_log_property_api("upload_es_train");
    set_log_property_api("es_linker");
    set_log_property_api("link_results_analyzer");

    // Chargement de la page précédente (rappel du controller)
    location.reload();
} // /to_previous_page()


$(function(){// ready

    npages = 0;
    pas = 50;

    project_id_link = "<?php echo $_SESSION['link_project_id'];?>";

    // Récupération des metadata du projet de link en cours
    metadata_link = get_metadata('link', '<?php echo $_SESSION['link_project_id'];?>');

    file_name = metadata_link.files.source.file_name;

    // MAJ du nom du projet
    //$("#project_name1").html(metadata_link.display_name);
    // MAJ du nom du projet
    $("#page_title_project_name").html(metadata_link.display_name + " : ");

    // Récupération des matches
    column_matches = get_column_matches();

    // Récupération du nombre total de lignes -------------------------
    // Id du fichier source
    project_id_src = metadata_link['files']['source']['project_id'];

    // Récupérartion des métadata du fichier source
    metadata_src = get_metadata('normalize', project_id_src);

    src_nrows = metadata_src.files[Object.keys(metadata_src.files)].nrows;
    // ----------------------------------------------------------------

    // Récupération du paramétrage
    learned_setting_json = get_learned_setting(project_id_link);
    if(learned_setting_json){
        treatment(project_id_link, learned_setting_json, false)
    }
    else{
        console.log('pas de learned_setting_json');
    }

    // Actions des boutons
    add_buttons();
});//ready

</script>
