<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid" id="entete" style="margin-top: 20px;">
    <div class="well">
        <div class="row">
            <div class="col-md-10">
                <h2 style="margin-top: 0;"><span id="project_name1"></span> : <i>Association des colonnes</i></h2>
            </div>
            <div class="col-md-2 text-right">
                <a href="<?php echo base_url('index.php/Project/load_step4_infer_types');?>">Passer cette étape</a>
            </div>
        </div>
        <p>
            Cette étape vous permet d'associer des colonnes de votre fichier source à des colonne du référentiel cible. Une bonne association améliorera considérablement les résultats de la jointure.<br>
            Pour associer des colonnes, vous devez ajouter une nouvelle association (<button class="btn btn-xs btn-success2">Nouvelle association&nbsp;<span class="glyphicon glyphicon-plus"></span></button>) et glisser/déposer la ou les colonnes souhaitées dans la zone corespondante.
            <br>
            Les colonnes possédant une <span class="glyphicon glyphicon-star"></span> sont des colonnes où le type a été détecté lors de la normalisation.
            <br>
            <br>
            Bien que cela soit déconseillé, vous pouvez choisir de passer cette étape.
        </p>
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" id="bt_start">Commencer l'association des colonnes</button>
            </div>
        </div>
    </div><!-- /well-->
</div><!--/container-->

<div class="container-fluid" id="work" style="margin-top: 20px;">
    <div class="well">
        <div class="row">
            <div class="col-xs-2 titre">
                <h3>
                    Source
                </h3>
                <div class="filename">
                    <span class="glyphicon glyphicon-file"></span>
                    <span id="src_file_name"></span>
                </div>
                <div id="src_columns"></div>
            </div>
            <div class="col-xs-8">
                <div class="row">
                    <div class="col-md-9">
                        <h2 style="margin-top: 0;display: inline-block;">
                            <span id="project_name2"></span> : <i>Association des colonnes</i>
                        </h2>
                        <button class="btn btn-xs btn-success2" id="bt_add_bloc" style="margin-bottom: 4px">
                            Nouvelle association&nbsp;
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </div>
                    <div class="col-md-3 text-right">
                        <a>Aide</a>
                        &nbsp;|&nbsp;
                        <a href="<?php echo base_url('index.php/Project/load_step4_infer_types');?>">Passer cette étape</a>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-xs-12 text-center" id="blocs"></div>
                </div>
            </div>
            <div class="col-xs-2 titre">
                <h3>
                    <span class="glyphicon glyphicon-file"></span>
                    Référentiel
                </h3>
                <div id="ref_file_name" class="filename"></div>
                <div id="ref_columns"></div>
            </div>
        </div>    
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-right">
            <button class="btn btn-success" id="bt_next">Etape suivante : Apprentissage >></button>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_bloc">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Changement du libellé de l'association</h4>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" placeholder="Libellé de l'association" id="lib_bloc">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-success" id="bt_valid_add_bloc">Modifier</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



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
}

function get_runinfo(project_type, project_id, module_name, file_name) {
    // Récupere le contenu d'un fichier runInfo via API
    console.log('get_runinfo()');

    var runinfo = "";

    var tparams = {
        "data_params": {
            "module_name": module_name,
            "file_name": file_name + "__run_info.json"
        }
    }

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/download_config/' + project_type + '/' + project_id + '/',
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

                return result.result.params.column_types;
            }
        },
        error: function (result, status, error){
            console.log("error - download_config");
            console.log(result);
        }
    });// /ajax - Download config

} // /get_runinfo


function get_columns(metadata) {
    // Renvoie les colonnes présentent dans les métadata

    var all_columns = metadata['column_tracker']['original'];
    return all_columns;
}

function write_columns_html(target, columns) {
    // Ajoute les colonnes à l'interface

    var html = "";
    $.each(columns, function( i, name) {
      html+= '<div class="column color_' + target + '" draggable="true">' + name + '</div>' + "\n";
    });

    $("#" + target).html(html);
}

function get_filename(filename) {
    // On retire prefix "MINI__" si existant
    if(filename.substr(0, 4) == 'MINI'){
        filename = filename.substr(6, filename.length);
    }

    return filename;
}

function valid_associations() {
    // Teste la validité des associations effectuées
    // cad : au moins un champ de chaque coté

    // TODO

    return true;
}

function add_column_certain_matches_api() {
    // Appel API de MAJ associations

    // Récupération des associations
    var tab_json = new Array();
    $(".blocs_analysis").each(function( index ) {
      tab_json.push($(this).text());
    });

    var chaine_json = tab_json.join(); // , par défaut

    var tparams = {
        "column_certain_matches": [chaine_json]
        }

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/link/add_column_certain_matches/' + project_id_link + '/',
        data: JSON.stringify(tparams),
        async: false,
        success: function (result) {

            if(result.error){
                console.log("API error - add_column_certain_matches");
                console.log(result.error);
            }
            else{
                console.log("success - add_column_certain_matches");
                console.dir(result);

                
            }
        },
        error: function (result, status, error){
            console.log("error - add_column_certain_matches");
            console.log(result);
        }
    });// /ajax

}// /add_column_certain_matches_api


function add_column_matches_api() {
    // Appel API de MAJ associations

    // Récupération des associations
    var tab_json = new Array();
    $(".blocs_analysis").each(function( index ) {
      tab_json.push($(this).text());
    });

    var chaine_json = tab_json.join(); // , par défaut

    var tparams = "{\"column_matches\": ["+chaine_json+"]}";

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/link/add_column_matches/' + project_id_link + '/',
        data: tparams,
        async: false,
        success: function (result) {

            if(result.error){
                console.log("API error - add_column_matches");
                console.log(result.error);
            }
            else{
                console.log("success - add_column_matches");
                console.dir(result);

                
            }
        },
        error: function (result, status, error){
            console.log("error - add_column_matches");
            console.log(result);
        }
    });// /ajax

}// /add_column_matches_api

function valid_step(link_project_id){
    console.log('valid_step');

    // Appel de l'étape suivante
    window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + link_project_id;
    
}

$(function(){// ready
    
    $("body").css("height", $(window).height()) ;

    $("#bt_start").click(function(){
        $("#entete").css("display", "none");
        $("#work").fadeToggle();
    });

    $("#bt_next").click(function(){
        // Appel de l'API pour enregistrer les associations utilisateur
        if(valid_associations()){
            //add_column_certain_matches_api();
            add_column_matches_api();
        }

        valid_step('<?php echo $_SESSION['link_project_id'];?>');
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

    // Récupération des colonnes sources à ajouter
    columns_src = get_columns(metadata_src);
    columns_ref = get_columns(metadata_ref);

    // Renseignement des noms de fichiers
    var src_file_name = get_filename(metadata_src.last_written.file_name); 
    var ref_file_name = get_filename(metadata_ref.last_written.file_name);
    $("#src_file_name").html(src_file_name);
    $("#ref_file_name").html(ref_file_name);

    // Récupération des types inférés
    var infer_src = get_runinfo('normalize', project_id_src, 'recode_types', src_file_name);
    var infer_ref = get_runinfo('normalize', project_id_ref, 'recode_types', ref_file_name);

    // Ajout des colonne à l'interface
    $("#src_columns").html(get_columns_html(columns_src, infer_src, "src"));
    $("#ref_columns").html(get_columns_html(columns_ref, infer_ref, "ref"));


    cpt_bloc = 0; // Compteur de blocs
    id_bloc_to_change = 0; // Identifiant du bloc en cours pour modification de libellé

    $("#bt_add_bloc").click(function(){
        // Incrementation du numéro de bloc
        cpt_bloc++;
        // Création du nouveau bloc
        new_bloc(cpt_bloc);
    });

    $("#bt_valid_add_bloc").click(function(){
        $('#modal_bloc').modal('hide');

        // Changement du libellé du bloc en cours
        $("#lib_bloc_" + id_bloc_to_change).html($("#lib_bloc").val());

    });


});//ready
</script>