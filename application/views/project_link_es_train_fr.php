<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid" id="entete" style="margin-top: 20px;">
    <div class="well">
        <div class="row">
            <div class="col-md-10">
                <h2 style="margin-top: 0;"><span id="project_name1"></span> : <i>Apprentissage</i></h2>
            </div>
            <div class="col-md-2 text-right">
                <a href="<?php echo base_url('index.php/Project/load_step4_infer_types');?>">Passer cette étape</a>
            </div>
        </div>
        <p>
            L'étape d'apprentissage va permettre à la machine de s'adapter au mieux à vos données. Des exemples vont vous être présentés,il vous suffira de répondre par "OUI" ou par "NON" en fonction de leur concordance.
            <br><br>
            Plusieurs indices vous donneront le taux de réussite estimé du traitement finale.
            <br>
            Indice de pécision :
            <br>
            Indice de rappel : Pourcentage de lignes considérée justes par rapport au nombre de lignes totales du fichier
        </p>
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" id="bt_start">Commencer l'apprentissage</button>
            </div>
        </div>
    </div><!-- /well-->
</div><!--/container-->


<div class="container-fluid" id="work" style="margin-top: 20px;">
    <div class="well">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-md-9">
                        <h2 style="margin-top: 0;display: inline-block;">
                            <span id="project_name2"></span> : <i>Apprentissage</i>
                        </h2>

                        <h2>
                            <span class="step_numbers">1</span>
                            .Champ d'apprentissage
                        </h2>
                        <div class="row">
                            <div class="col"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-right">
                        <a>Aide</a>
                        &nbsp;|&nbsp;
                        <a href="<?php echo base_url('index.php/Project/link');?>">Passer cette étape</a>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-xs-12 text-center" id="blocs"></div>
                </div>
            </div>
        </div>    
    </div>
</div>


<script type="text/javascript">

function get_metadata(project_type, project_id) {
    // Récupere les métadata via API

    var metadata = "";

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
                metadata = result.metadata;
            }
        },
        error: function (result, status, error){
            console.log(result);
            console.log(status);
            console.log(error);
            err = true;
        }
    });// /ajax metadata

    return metadata;
}// / get_metadata


function create_es_index_api() {

    var tparams = {
        "module_params": {
            "force": true
        }
    }

    $.ajax({
        type: 'POST',
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

                                // Chargement du labeller
                                create_es_labeller_api();
                               
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

}// create_es_labeller_api


function create_es_labeller_api() {

    $.ajax({
        type: 'GET',
        url: '<?php echo BASE_API_URL;?>' + '/api/schedule/create_es_labeller/' + project_id_link + '/',
        success: function (result) {

            if(result.error){
                console.log("API error - create_es_labeller_api");
                console.dir(result.error);
            }
            else{
                console.log("success - create_es_labeller_api");
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
                               
                                var answer_to_send = {'project_id': project_id_link}

                                console.log('socket.emit|load_labeller');
                                socket.emit('load_labeller', JSON.stringify(answer_to_send));
                                console.log('done');

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

}// create_es_labeller_api


function socket_on_message() {
    // Message provenant du serveur

    socket.on('message', function(data) {
        console.log('message|data: ');
        console.dir(data);

        show_new_proposition(data);
    });// / on
}// / socket_on_message


function socket_answer(user_response) {
    // Envoi de la réponse utilisateur
    // Un nouveau message sera reçu par socket_on_message()

    var response_to_send = {
        'project_id': project_id_link,
        'user_input': user_response
    }

    console.log('socket.emit|answer');
    socket.emit('answer', JSON.stringify(response_to_send));
    console.log('done'); 
} // /socket_answer


function show_new_proposition(data) {
    // Affiche les propositions en fonction du fichier column_matches


}// /show_new_proposition

$(function(){// ready
    
    $("body").css("height", $(window).height()) ;

    $("#bt_start").click(function(){
        $("#entete").css("display", "none");
        $("#work").fadeToggle();
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

/*
    // Récupération des colonnes sources à ajouter
    columns_src = get_columns(metadata_src);
    columns_ref = get_columns(metadata_ref);

    // Renseignement des noms de fichiers
    var src_file_name = get_filename(metadata_src.last_written.file_name); 
    var ref_file_name = get_filename(metadata_ref.last_written.file_name);
  
    $("#src_file_name").html(src_file_name);
    $("#ref_file_name").html(ref_file_name);
    
    // Ajout des colonne à l'interface
    $("#src_columns").html(get_columns_html(columns_src, infer_src, "src"));
    $("#ref_columns").html(get_columns_html(columns_ref, infer_ref, "ref"));
*/

    column_matches = get_column_matches();

    // Connect to socket
    // var socket = io.connect('http://' + document.domain + ':' + location.port + '/');
    socket = io.connect('<?php echo BASE_API_URL;?>');

    // Création des indexs ES
    create_es_index_api();

    socket_on_message();
    


});//ready
</script>