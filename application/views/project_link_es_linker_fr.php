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

    // Récupération du paramétrage
    var learned_setting_json = get_learned_setting(project_id_link);

    if(learned_setting_json){
        treatment(project_id_link, learned_setting_json);
    }

/*
    $("body").css("height", $(window).height()) ;

    $("#bt_start").click(function(){
        $("#entete").css("display", "none");
        $("#work").fadeToggle();
        $("#bt_next").fadeToggle();
    });

    $("#bt_next").click(function(){
        valid_step();
    });    

    project_id_link = "<?php echo $_SESSION['link_project_id'];?>";

    // Récupération des metadata du projet de link en cours
    console.log('Projet de LINK');
    metadata_link = get_metadata('link', '<?php echo $_SESSION['link_project_id'];?>');

    // MAJ du nom du projet
    $("#project_name1").html(metadata_link.display_name);
    $("#project_name2").html(metadata_link.display_name);

    // Récupération des ids des projets de normalisation
    project_id_src = metadata_link['files']['source']['project_id'];
    project_id_ref = metadata_link['files']['ref']['project_id'];

    // Récupérartion des métadata du fichier source
    console.log('Projet de normalisation SOURCE');
    metadata_src = get_metadata('normalize', project_id_src);

    // Récupérartion des métadata du fichier referentiel
    console.log('Projet de normalisation REFERENTIEL');
    metadata_ref = get_metadata('normalize', project_id_ref);

    column_matches = get_column_matches();

    console.log('column_matches');
    console.log(column_matches);

    // Connect to socket
    // var socket = io.connect('http://' + document.domain + ':' + location.port + '/');
    socket = io.connect('<?php echo BASE_API_URL;?>');

    // Création des indexs ES
    create_es_index_api();

    socket_on_message();
    

*/
});//ready
</script>