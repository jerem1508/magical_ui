<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid" id="entete" style="margin: 10px;">
    <div class="well" style="margin: 0;">
        <div class="row">
            <div class="col-md-8">
                <h2>
                    <span class="step_numbers">1</span>
                    &nbsp;Présentation du résultat de la jointure
                </h2>
            </div>
            <div class="col-md-4 text-right" id="pagination"></div>
        </div>
        <div id="result"></div>
    </div><!-- /well-->
</div><!--/container-->

<div class="container-fluid" style="margin: 10px;">
    <div class="well" style="margin: 0;">
        <div class="row">
            <div class="col-md-12">
                <h2>
                    <span class="step_numbers">2</span>
                    &nbsp;Statistiques
                </h2>
            </div>
        </div>
        <div class="row" id="stats">
            <div class="col-xs-2">
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
        </div>
    </div><!-- /well-->
</div><!--/container-->

<div class="container-fluid" style="margin: 10px;">
    <div class="well" style="margin: 0;">
        <div class="row">
            <div class="col-md-12">
                <h2>
                    <span class="step_numbers">3</span>
                    &nbsp;Télechargement
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success2" id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier final</button>
            </div>
        </div>
    </div><!-- /well-->
</div><!--/container-->


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
                console.log("API error - download_config");
                console.log(result.error);
            }
            else{
                console.log("success - download_config");
                console.dir(result);
                ret = result.result;
            }
        },
        error: function (result, status, error){
            console.log("error - download_config");
            console.log(result);
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
                console.log("API error - download_config");
                console.log(result.error);
            }
            else{
                console.log("success - download_config");
                console.dir(result);
                ret = result.result;
            }
        },
        error: function (result, status, error){
            console.log("error - download_config");
            console.log(result);
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
                console.log("API error - download_config");
                console.log(result.error);
            }
            else{
                console.log("success - download_config");
                console.dir(result);

                ret = result.result.best_thresh;
                //ret = 14;
            }
        },
        error: function (result, status, error){
            console.log("error - download_config");
            console.log(result);
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
                console.log("API error - get_data");
                console.log(result.error);
            }
            else{
                console.log("success - get_data");
                console.dir(result);
                ret = result.responses;
            }
        },
        error: function (result, status, error){
            console.log("error - get_data");
            console.log(result);
        }
    });// /ajax
    return ret;
}// /get_data()


function show_data_html(data, start) {
    var html = '<table class="table">';

    // Entete
    html += '<tr class="table_header">';
    html += '    <td colspan="2"><i class="fa fa-table" aria-hidden="true"></i> (<i>Source</i>)</td>';

    for (var i = 0; i < column_matches.length; i++) {
        var source_list = column_matches[i].source;
        html += '    <th>' + source_list + '</th>';
    }

    html += '    <th rowspan="2" class="text-center">Confiance<br><i>Seuil : ' + Math.floor(tresh) + '</i></th>';
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
        // Récupération id_source/id_ref
        var id_source = data[i].hits.hits[0]['_id'];
        var id_ref = data[i].hits.hits[0]['_source']["__ID_REF"];


        var no_line = start + i + 1;
        html += '<tr class="line ' + no_line + '">';
        html += '    <td rowspan="2" class="text-center no_line"><h4 class="value_vcentered ' + no_line + '">' + no_line + '</h4></td>';

        // Récupération de l'indice de confiance
        var confidence = Math.round(data[i].hits.hits[0]['_source']['__CONFIDENCE']);
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
            html += '<td rowspan="2" class="text-center"><h4 class="value_vcentered">';
            html += '<i class="fa fa-user-circle" aria-hidden="true" title="Labellisation manuelle utiisateur" data-toggle="tooltip"></i>';
            html += '<h4></td>';
        }
        else{
            html += '<td rowspan="2" class="text-center"><h4 class="confidence_vcentered">' + confidence + '<h4></td>';
        }

        // Affichage du bouton
        html += '<td rowspan="2" class="action_vcentered text-center"><h4 style="display: inline;"><input id="chk_' + no_line + '" type="checkbox" class="chk" id_source="' + id_source + '" id_ref="' + id_ref + '"';
        if(confidence >= tresh){
            html += ' checked '
        }
        html += '>&nbsp;&nbsp;<a onclick="delete_line(\'' + no_line + '\');" class="icon" id="del_line_' + no_line + '"><i class="fa fa-times" aria-hidden="true"></i></a></h4>';

        html += '</td>';
        html += '</tr>';
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
        //$('#chk_' + no_line).bootstrapToggle({
        $('.chk').bootstrapToggle({
          on: 'Vrai',
          off: 'Faux',
          onstyle: 'success3',
          offstyle: 'danger',
          size: 'small'
        });
    }// /for

    // Séparation visuelle des lignes
    $(".line").css("border-top","2px solid #ccc");

    // TD plus petit
    $("td").css("padding", "2px");

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

        // Upload du fichier modifié
        // TODO
        console.log(learned_setting_json);
    });
}// /show_data_html()


function delete_line(no_line) {
    if($("#del_line_" + no_line).hasClass("delete_line")){
        // undelete
        $("#del_line_" + no_line).removeClass("delete_line");
        $("." + no_line).css("color", "#333");
        $("." + no_line).css("font-style", "normal");
        $("#del_line_" + no_line).html('<i class="fa fa-times" aria-hidden="true"></i>');

        // undelete de la ligne API
        // TODO

    }
    else{
        // delete
        $("#del_line_" + no_line).addClass("delete_line");
        $("." + no_line).css("color", "#ccc");
        $("." + no_line).css("font-style", "italic");

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
    var tparams = {
        "module_params": {
            "for_linking": false
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
                console.log("API error - create_es_index_api");
                console.dir(result.error);
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

                                // Récupération des données paginées + affichage
                                var start = 0;
                                var data = get_data(start, 20);

                                show_data_html(data, start);
                            }
                            else{
                                console.log("success - job en cours");
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
    });// /ajax - create_es_labeller
}// create_es_labeller_api()


function treatment(project_id_link, learned_setting_json) {

    var tparams = {
        "module_params": learned_setting_json
    }
    console.log('tparams:');
    console.log(tparams);

    $.ajax({
        type: 'post',
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/es_linker/' + project_id_link + '/',
        contentType: "application/json; charset=utf-8",
        traditional: true,
        data: JSON.stringify(tparams),
        success: function (result) {

            if(result.error){
                console.log("API error - es_linker");
                console.dir(result.error);
            }
            else{
                console.log("success - es_linker");
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

                                // Permettre le téléchargement du fichier

                                // Récupération du seuil
                                tresh = get_thresh(project_id_link);

                                // Création de l'index ElasticSearch + Affichage
                                create_es_index_api();

                            }
                            else{
                                console.log("success - job en cours");
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
            console.log("error schedule");
            console.log(result);
            err = true;
        }
    });// /ajax - create_es_labeller
}// create_es_labeller_api()


function valid_step() {
    // Validation du training
    complete_training();

    // Passage à l'étape suivante
    window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + project_id_link;
}// / valid_step()


function get_file_name(project_id) {
    console.log('get_file_name()');
    var ret = "";

    var tparams = {
        "module-name": "es_linker"
    }

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/last_written/link/' + project_id,
        data: JSON.stringify(tparams),
        async: false,
        success: function (result) {
            if(result.error){
                console.log("API error - get_file_name");
                console.log(result.error);
            }
            else{
                console.log("success - get_file_name");
                console.dir(result);

                ret = result.file_name;
            }// / lastwritten - success
        },
        error: function (result, status, error){
            console.log("error - get_file_name");
            console.log(result);
            err = true;
        }
    });// /ajax - last_written
    return ret;
}// /get_file_name()


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
    }); // /dl_file.click()
}// /add_buttons()


function set_pagination_html(nrows, pas, current_page) {
    // MAJ de la pagination
    npages = Math.ceil(nrows / pas);

    var html = '';
    html += '<nav aria-label="Page navigation">';
    html += '  <ul class="pagination">';

    // Bouton précédent ------------------
    if(current_page == 1){
        // On desable le bouton précédent
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

    }

    // Bouton suivant -------------------------
    if(current_page == npages){
        // On desable le bouton suivant
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
    html += '<div>De ' + start + ' à ' + end + ' sur ' + nrows + ' lignes</div>';

    $("#pagination").html(html);
}// /set_pagination_html()


function load_data(nrows, pas, current_page) {
    console.log('load_data()');

    var start = (current_page - 1) * pas;
    console.log('start:' + start);

    var data = get_data(start, pas);

    show_data_html(data, start);

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
                console.log("API error - link_results_analyzer_api");
                console.dir(result.error);
            }
            else{
                console.log("success - link_results_analyzer_api");
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

                                // Récupération des données + affichage
                                set_stats_html(result);
                            }
                            else{
                                console.log("success - job en cours");
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
    });// /ajax - link_results_analyzer
}// /get_stats()


function set_stats_html(stats) {
    // MAJ des stats
    $("#stat_pct_nb_lines").html(stats.result.perc_match + " %");
    $("#stat_nb_lines").html(stats.result.num_match);
}// /set_stats_html()


$(function(){// ready

    npages = 0;

    project_id_link = "<?php echo $_SESSION['link_project_id'];?>";

    // Récupération du nom de fichier à DL
    file_name = get_file_name(project_id_link);

    // Récupération des metadata du projet de link en cours
    metadata_link = get_metadata('link', '<?php echo $_SESSION['link_project_id'];?>');

    // MAJ du nom du projet
    $("#project_name1").html(metadata_link.display_name);

    // Récupération des matches
    column_matches = get_column_matches();

    // Récupération du paramétrage
    learned_setting_json = get_learned_setting(project_id_link);
    if(learned_setting_json){
        treatment(project_id_link, learned_setting_json);
    }

    // Actions des boutons
    add_buttons();

    // Récupération du nombre total de lignes -------------------------
        // Id du fichier source
        project_id_src = metadata_link['files']['source']['project_id'];

        // Récupérartion des métadata du fichier source
        console.log('Projet de normalisation SOURCE');
        metadata_src = get_metadata('normalize', project_id_src);

        src_nrows = metadata_src.files[Object.keys(metadata_src.files)].nrows;
    // ----------------------------------------------------------------

    // Pagination
    var pas = 20;
    set_pagination_html(src_nrows, pas, 1);

    // Statistiques
    get_stats();
});//ready
</script>