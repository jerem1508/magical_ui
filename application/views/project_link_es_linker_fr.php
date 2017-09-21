<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" id="entete" style="margin-top: 20px;">
    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <h2 style="margin-top: 0;"><span id="project_name1"></span> : <i>Traitement</i></h2>
            </div>
        </div>
        <p>
            
        </p>
    </div><!-- /well-->
</div><!--/container-->

<div class="container">
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

                                //link_results_analyzer(); //schedule

                                // Sample
                                // es_linker. source.csv metatdata/files/source/filename


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
}// / generate_sample()


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

    // Affichage PONG
    

    // Récupération du paramétrage
    var learned_setting_json = get_learned_setting(project_id_link);

    if(learned_setting_json){
        treatment(project_id_link, learned_setting_json);
    }

    // Récupération et affichage du fichier
    //generate_sample();

});//ready
</script>