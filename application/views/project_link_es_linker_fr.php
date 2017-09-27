<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid" id="entete" style="margin-top: 20px;">
    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <h2 style="margin-top: 0;"><span id="project_name1"></span> : <i>Résultats</i></h2>
            </div>
        </div>
        <p>

        </p>
        <div id="result"></div>
    </div><!-- /well-->
</div><!--/container-->

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-right">
            <button class="btn btn-success" id="bt_next">Analyse des résultats >></button>
        </div>
    </div>
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


function get_tresh(project_id) {
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

                ret = result.result.tresh;
                ret = 14;
            }
        },
        error: function (result, status, error){
            console.log("error - download_config");
            console.log(result);
        }
    });// /ajax - Download config
    return ret;
} // /get_runinfo()


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


function show_data(data, start) {
    var html = '<div class="table-responsive">';
        html += '<table class="table table-bordered table-condensed">';

    // Entete
    html += '<tr >';
    html += '    <th>SOURCE</th>';

    for (var i = 0; i < column_matches.length; i++) {
        var source_list = column_matches[i].source;
        html += '    <th>' + source_list + '</th>';
    }

    html += '    <th rowspan="2">Confiance</th>';
    html += '    <th rowspan="2">Action</th>';
    html += '</tr>';
    html += '<tr>';
    html += '    <th>REF</th>';
    
    for (var i = 0; i < column_matches.length; i++) {
        var ref_list = column_matches[i].ref;
        html += '    <th>' + ref_list + '</th>';
    }
    html += '</tr>';


    for (var i = 0; i < data.length; i++) {
        html += '<tr>';
        var no_line = start + i + 1;
        html += '    <td rowspan="2" class="text-center no_line"><h3>' + no_line + '</h3></td>';

        // Récupération de l'indice de confiance
        var confidence = Math.round(data[i].hits.hits[0]['_source']['__CONFIDENCE']);

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

        html += '    <td rowspan="2" class="text-center"><h3>' + confidence + '<h3></td>';

        // Affichage du bouton
        if(confidence < tresh){
            html += '    <td rowspan="2"><h3><input type="checkbox" id="chk_' + no_line + '"></h3></td>';            
        }
        else{
            html += '    <td rowspan="2"><h3><input type="checkbox" checked id="chk_' + no_line + '"></h3></td>';
        }

        html += '</tr>';
        html += '<tr>';

        // Parcours des termes du REF --------------------------------------------
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
    html += '</div>';

    $("#result").html(html);
}// /show_data()


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
                                var data = get_data(start, 50);
                                show_data(data, start);

                                // MAJ des boutons on/off
                                for (var i = 0; i < data.length; i++) {
                                    var no_line = start + i + 1;
                                    $('#chk_' + no_line).bootstrapToggle({
                                      on: 'Vrai',
                                      off: 'Faux',
                                      onstyle: 'success3',
                                      offstyle: 'danger',
                                      size: 'small'
                                    });
                                }// /for

                                // Alterance des couleurs
                                var cpt = 0;
                                $("tr").each(function(){
                                    if(Math.floor(cpt/2)%2){
                                        $(this).addClass("active");
                                        $(this).css("background-color","#777");
                                    }
                                    cpt ++;
                                });

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
                                tresh = get_tresh(project_id_link);

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


$(function(){// ready

    project_id_link = "<?php echo $_SESSION['link_project_id'];?>";

    // Récupération des metadata du projet de link en cours
    console.log('Projet de LINK');
    metadata_link = get_metadata('link', '<?php echo $_SESSION['link_project_id'];?>');

    // MAJ du nom du projet
    $("#project_name1").html(metadata_link.display_name);

    // Récupération des matches
    column_matches = get_column_matches();

    // Récupération du paramétrage
    var learned_setting_json = get_learned_setting(project_id_link);

    if(learned_setting_json){
        treatment(project_id_link, learned_setting_json);
    }


});//ready
</script>