<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid background_1" id="work" style="padding-bottom: 20px;margin-left:20px;margin-right:20px;">
<!--
    <div class="row">
        <div class="col-md-12 text-right">
            <div style="padding-top: 20px;">
                <a href="#" onclick="javascript:introJs().setOption('showBullets', false).start();">Aide</a>
            </div>
        </div>
    </div>
-->
    <div class="row">
        <div class="col-sm-11">
            <div class="page_explain">
                <strong>Pour associer des colonnes</strong>, vous devez ajouter une <button class="btn btn-xs btn-success2">Nouvelle association&nbsp;<span class="glyphicon glyphicon-plus"></span></button> puis <strong>cliquer</strong> sur la ou les colonnes souhaitées de la <strong>source ET du référentiel</strong>.<br>
                Répétez cette opération autant de fois que nécessaire.
            </div>
        </div>
        <div class="col-sm-1 text-right">
            <button type="button" id="bt_help" class="btn btn-success3">AIDE</button>
        </div>
    </div><!-- /row-->

    <div class="row">
        <div class="col-xs-3">
            <h3 style="margin-top: 0;margin-bottom: 0;">
                <i class="fa fa-table" aria-hidden="true"></i>
                &nbsp;
                Source
            </h3>
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-2 text-center">
                    <i class="fa fa-info-circle info" aria-hidden="true"></i>
                </div>
                <div class="col-md-10">
                    <div id="info_src">
                        <div>
                            <span class="keys"></span><span id="src_file_name" class="filename key_numbers"></span>
                        </div>
                        <div>
                            <span class="keys">Nombre de lignes : </span><span id="src_nrows" class="key_numbers"></span>
                        </div>
                        <div>
                            <span class="keys">Nombre de colonnes : </span><span id="src_ncols" class="key_numbers"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
                <div style="background-color: #262626;color:#ccc;padding:5px;border-radius:5px;margin-bottom:10px;">
                    <span style="font-weight:bold;display:inline-block;margin-bottom:5px;">Légende : </span>
                    <div class="row">
                        <div class="col-md-4">
                            <span class="badge" style="background-color: #e6ccff">&nbsp;</span>&nbsp;Catégorie "<strong>personnes</strong>"
                        </div>
                        <div class="col-md-4">
                            <span class="badge" style="background-color: #ffcccc">&nbsp;</span>&nbsp;Catégorie "<strong>institutions</strong>"
                        </div>
                        <div class="col-md-4">
                            <span class="badge" style="background-color: #ffff80">&nbsp;</span>&nbsp;Catégorie "<strong>identifiants</strong>"
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                        <div class="col-md-4">
                            <span class="badge" style="background-color: #ff80bf">&nbsp;</span>&nbsp;Catégorie "<strong>date</strong>"
                        </div>
                        <div class="col-md-4">
                            <span class="badge" style="background-color: #66c2ff">&nbsp;</span>&nbsp;Catégorie "<strong>géographie</strong>"
                        </div>
                        <div class="col-md-4">
                            <span class="badge" style="background-color: #b3e6b3">&nbsp;</span>&nbsp;Catégorie "<strong>autres</strong>"
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-xs-3">
            <h3 style="margin-top: 0;margin-bottom: 0;">
                <i class="fa fa-database" aria-hidden="true"></i>
                &nbsp;
                Référentiel
            </h3>
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-2 text-center">
                    <i class="fa fa-info-circle info" aria-hidden="true"></i>
                </div>
                <div class="col-md-10">
                    <div id="info_ref">
                        <div>
                            <span class="keys"></span><span id="ref_file_name" class="filename key_numbers"></span>
                        </div>
                        <div>
                            <span class="keys">Nombre de lignes : </span><span id="ref_nrows" class="key_numbers"></span>
                        </div>
                        <div>
                            <span class="keys">Nombre de colonnes : </span><span id="ref_ncols" class="key_numbers"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="body">
        <div class="col-xs-3 titre left" data-intro="Faites glisser les colonnes de votre source pouvant servir à l'association...">
            <div id="src_columns"></div>
        </div>
        <div class="col-xs-6 center">
            <div class="col-xs-12 text-center" id="blocs"></div>

            <div class="col-xs-12 text-right" style="padding-right: 5px;">
                <button class="btn btn btn-success2" id="bt_add_bloc" data-intro="Ajoutez une nouvelle association de colonnes ici">
                    Ajouter une association&nbsp;
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
        </div>
        <div class="col-xs-3 titre right" data-intro="... puis les colonnes correspondantes du référentiel">
            <div id="ref_columns"></div>
        </div>
    </div>

</div>

<div class="container-fluid" style="margin-top: 20px;min-height: 250px;">
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


<div class="modal fade" tabindex="-1" role="dialog" id="modal_help">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
            <i class="fa fa-question-circle"></i>
            Aide
        </h4>
      </div>
      <div class="modal-body">
          <p class="well">

              L'appariement de colonne décrit les colonnes qui partagent des informations qui peuvent servir au matching. Il est possible de spécifier plusieurs colonnes à matcher (par exemple on apparie en utilisant simultanément un champ "NOM_ETABLISSEMENT" et un champ "VILLE"). Par ailleurs, l'appariement de colonnes n'est pas nécessairement 1 à 1 mais peut aussi impliquer plusieurs colonnes de la source ou du référentiel; les différents comportements sont décrits ci-dessous:

              ### Ajout de paires multiples
              Les appariements sont des indications pour l'algorithme d'apprentissage. L'algorithme va probablement sélectionner un sous-ensemble des paires indiquées pour le matching. Les paires sélectionnées agiront comme un "ET". Ajouter autant de paires que possible pour couvrir toutes les possibilités peut être tentant (peut-être que matcher e-mail et pays peut être utile...), cela risque de rendre les calculs plus lents et lourds pour notre serveur et risque aussi d'ajouter du bruit qui peut nuire à l'apprentissage. L'appariement idéal est généralement l'ensemble minimal de colonnes qui permettrait à un humain de décider si une paire de lignes est un match ou non.


              #### Colonnes multiples pour la source dans l'appariement
              Quand plusieurs colonnes sont sélectionnées pour la source, les valeurs de celles-ci seront concaténées (avec un espace) et le résultat sera recherché comme un tout dans le référentiel. Cela peut être utile quand deux champs de la source correspondent à un champ du référentiel, mais aussi quand les données à matcher se trouvent alternativement dans un champ ou dans l'autre de la source.

              #### Colonnes multiples pour la référence dans l'appariement
              Quand plusieurs colonnes sont sélectionnée pour la référence, les valeurs de la source seront recherchées dans ces deux colonnes et des résultats seront renvoyées s'il y a un match dans l'une ou dans l'autre des colonnes (agissant comme un "OU").


          </p>
          <div>
              <h4>Exemples :</h4>
          </div>
          <div>
              <h4>Association(s) classique(s) :</h4>
              <span class="keyword">lycees source</span> <span class="exemple">Lycée Jean Moulin</span>
              <br>
              avec
              <br>
              <span class="keyword">denomination_principale_uai</span> <span class="exemple">LYCEE GENERAL</span> et <span class="keyword">patronyme_uai</span> <span class="exemple">JEAN MOULIN</span>
          </div>
          <div>
              <br>
              <h4>Association parfaite :</h4>
              <br>
              <span class="keyword">Numéro UAI</span> <span class="exemple">0080040A</span>
              <br>
              avec
              <br>
              <span class="keyword">UAI</span> <span class="exemple">0080040A</span>
              <br>
              <br>
              <i class="fa fa-exclamation-circle"></i> Attention : <span class="exemple">075</span> ne correspond pas à une association parfaite avec <span class="exemple">75</span>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success3" data-dismiss="modal" onclick="javascript:introJs().setOption('showBullets', false).start();">Lancer le didacticiel</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>
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
                show_api_error(result, "API error - metadata");
            }
            else{
                console.log("success - metadata");console.dir(result);
                metadata = result.metadata;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - metadata");
            err = true;
        }
    });// /ajax metadata

    return metadata;
}// /get_metadata()


function get_runinfo(project_type, project_id, module_name, file_name, metadata) {
    // Récupere le contenu d'un fichier runInfo via API
    /*
    console.log('get_runinfo('+project_type+','+project_id+','+module_name+','+file_name+',metadata)');
    console.log('metadata:');
    console.log(metadata);
    */
    var runinfo = "";

    // Parametres
    var tparams = {
        "data_params": {
            "module_name": module_name,
            //"file_name": file_name + "__run_info.json"
            "file_name": "infered_config.json"
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
                show_api_error(result, "API error - download_config");
            }
            else{
                console.log("success - download_config");
                console.log(result);

                //runinfo = result.result.params.column_types;
                runinfo = result.result.column_types;
            }
        },
        error: function (result, status, error){
             if(result.status != 404) {
                 show_api_error(result, "error - download_config");
             }
        }
    });// /ajax - Download config
    return runinfo;
} // /get_runinfo()


function get_columns(metadata) {
    // Renvoie les colonnes présentent dans les métadata

    var all_columns = metadata['column_tracker']['original'];
    return all_columns;
}// /get_columns()


function get_filename(filename) {
    // On retire prefix "MINI__" si existant
    if(filename.substr(0, 4) == 'MINI'){
        filename = filename.substr(6, filename.length);
    }

    return filename;
}// /get_filename()


function valid_associations() {
    // Teste la validité des associations effectuées
    // cad : au moins un champ de chaque coté
    $(".blocs_analysis").each(function( index ) {
        var content_text = $(this).text();
        if(content_text == ""){
            return false;
        }
        else {
            var content_json = JSON.parse( $(this).text() );
            if(content_json["ref"][0] === ""){
                return false;
            }
            if(content_json["source"][0] === ""){
                return false;
            }
        }
    });
    return true;
}// /valid_associations()


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
                show_api_error(result, "API error - add_column_certain_matches");
            }
            else{
                console.log("success - add_column_certain_matches");
                console.log(result);
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - add_column_certain_matches");
        }
    });// /ajax
}// /add_column_certain_matches_api()


function add_column_matches_api() {
    // Appel API de MAJ associations

    // Récupération des associations
    var tab_json = new Array();
    $(".blocs_analysis").each(function( index ) {
        if($(this).text() != ""){
            tab_json.push($(this).text());
        }
    });

    var chaine_json = tab_json.join(); // , par défaut

    var tparams = "{\"column_matches\": ["+chaine_json+"]}";
    console.log('tparams_column_matches:');
    console.log(tparams);

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/link/add_column_matches/' + project_id_link + '/',
        data: tparams,
        async: false,
        success: function (result) {
            if(result.error){
                show_api_error(result, "API error - add_column_matches");
            }
            else{
                console.log("success - add_column_matches");
                console.log(result);
            }
        },
        error: function (result, status, error){
            show_api_error(result, "error - add_column_matches");
        }
    });// /ajax
}// /add_column_matches_api()


function valid_step(link_project_id){
    console.log('valid_step');

    // Appel de l'étape suivante
    window.location.href = "<?php echo base_url('index.php/Project/link/');?>" + link_project_id;
}// /valid_step()


function get_buttons_actions() {
    // $("#bt_start").click(function(){
    //     $("#entete").css("display", "none");
    //     $("#tempo").css("display", "none");
    //     $("#bt_next").css("visibility", "visible");
    //     $("#work").fadeToggle();
    //
    //     // Association vide par défaut
    //     $("#bt_add_bloc").click();
    // });

    $("#bt_next").click(function(){
        // Appel de l'API pour enregistrer les associations utilisateur
        if(valid_associations()){
            //add_column_certain_matches_api();
            add_column_matches_api();
            valid_step('<?php echo $_SESSION['link_project_id'];?>');
        }

    });

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

    $("#bt_help").click(function(){
        $('#modal_help').modal('show');
    });


}// /get_buttons_actions()


function set_scroll(cible, ncols, limit) {
    if(ncols >= limit){
        var height = 40 * limit;
        $("#" + cible).css("height", height);
        $("#" + cible).css("overflow", "scroll");
    }
}// /set_scroll()


function get_sample(file_name, project_id){
    // Récupère un échantillon du fichiers
    console.log("get_sample(" + file_name + "," + project_id + ")");

    var tparams = {
        "data_params": {
            "module_name": "INIT",
            "file_name": file_name
        },
        "module_params":{
            "sampler_module_name": "standard",
            "sample_params": {
                "num_rows": 20
            }
        }
    }
    var ret = [];

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>/api/sample/normalize/' + project_id,
        data: JSON.stringify(tparams),
        async: false,
        success: function (result) {

            if(result.error){
                show_api_error(result, "API error - get_sample()");
            }
            else{
                // console.log("success sample");
                // console.log(result.sample);
                ret = result.sample;
            }
        },
        error: function (result, status, error){
            show_api_error(result, "Error - get_sample()");
        }
    });// /ajax

    return ret;

}// /get_sample()


$(function(){// ready
    cpt_bloc = 0; // Compteur de blocs
    id_bloc_to_change = 0; // Identifiant du bloc en cours pour modification de libellé

    $("body").css("height", $(window).height()) ;

    // Chargement des actions des boutons
    get_buttons_actions();

    project_id_link = "<?php echo $_SESSION['link_project_id'];?>";

    // Récupération des metadata du projet de link en cours
    console.log('Projet de LINK');
    metadata_link = get_metadata('link', '<?php echo $_SESSION['link_project_id'];?>');

    // MAJ du nom du projet
    $("#page_title_project_name").html(metadata_link.display_name);

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

    // Nombre de lignes
    $("#src_nrows").html(metadata_src.files[Object.keys(metadata_src.files)].nrows);
    $("#ref_nrows").html(metadata_ref.files[Object.keys(metadata_ref.files)].nrows);

    // Nombre de colonnes
    $("#src_ncols").html(columns_src.length);
    $("#ref_ncols").html(columns_ref.length);

    // Scrolls des colonnes si trop de données
    set_scroll("src_columns", columns_src.length, 15);
    set_scroll("ref_columns", columns_ref.length, 15);

    // Récupération des types inférés si existants
    var infer_src = get_runinfo('normalize', project_id_src, 'recode_types', src_file_name, metadata_src);
    var infer_ref = get_runinfo('normalize', project_id_ref, 'recode_types', ref_file_name, metadata_ref);

    // Récupération des 2 échantillons
    sample_src = get_sample(src_file_name, project_id_src);
    sample_ref = get_sample(ref_file_name, project_id_ref);

    // Ajout des colonne à l'interface
    $("#src_columns").html(get_columns_html(columns_src, infer_src, "src", sample_src));
    $("#ref_columns").html(get_columns_html(columns_ref, infer_ref, "ref", sample_ref));

    // Association vide par défaut
    $("#bt_add_bloc").click();

    $("#bt_next").css("visibility", "visible");
});//ready
</script>
