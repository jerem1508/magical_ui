<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Jointure</title>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery.dataTables.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/project_link_select_columns.css');?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/style.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/style_fu.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/jquery.fileupload.css');?>">

    <style type="text/css">
        #msg_danger, #create_project_ok, #upload_file_progress, #report{
            /*On masque par défaut*/
            display: none;
        }
        #show_report_ok, #upload_file_ok, #check_file_ok{
            visibility: hidden;
        }
		@media (min-width: 992px) {
		    .modal-lg {
		        width: 1100px;
		    }
		}
        .column{
            width: 100%;
            height: 40px;

            font-size: 1.1em;
            color: white;
            margin-bottom: 10px;
            padding-left: 5px;
            padding-top: 5px;
            border: 1px solid #777;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container">
	<div class="row">
		<div class="col-xs-2" style="margin-top: 20px;">
			<img src="<?php echo base_url('assets/img/logo-RF-3@2x.png');?>" class="img-responsive">
		</div>
		<div class="col-xs-8 text-center">
			<h1>Magical_ui</h1>
		</div>
		<div class="col-xs-2 text-right" style="margin-top: 20px;">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="font-size: 22px; color: #000;">
                    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("index.php/Home");?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Accueil</a></li>
                    <li role="separator" class="divider"></li>
                    <?php
                    if(isset($_SESSION['user'])){
                        echo "<li><a href='".base_url("index.php/User/dashboard")."'><span class='glyphicon glyphicon-th' aria-hidden='true'></span>&nbsp;&nbsp;Tableau de bord</a></li>";
                        echo "<li><a href='".base_url("index.php/User/logout")."'><span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp;&nbsp;Déconnexion</a></li>";
                    }
                    else{
                        echo "<li><a href='".base_url("index.php/User/login/normalize")."'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span>&nbsp;&nbsp;S'identifier</a></li>";
                    }
                    ?>
                    <li role="separator" class="divider"></li>
                    <li><a href="#"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>&nbsp;&nbsp;English</a></li>
                </ul>
            </div><!-- /dropdown-->
		</div>
	</div>

	<hr>

    <div class="text-center">
        <div class="breadcrumb flat">
            <!--<a href="#" class="done">Sélection du fichier</a>-->
            <a href="" class="done">Création du projet</a>
            <a href="#" class="active">Correspondance des colonnes</a>
            <a href="#" class="todo">Apprentissage</a>
            <a href="#" class="todo">Restriction</a>
            <a href="#" class="todo">Téléchargement</a>
        </div>
    </div>
<!--
	<div class="well">
		<h2><span id="project_name"></span> : <i>Mise en correspondance des colonnes</i></h2>
    </div>
-->
</div><!--/container-->

<!--
<div class="container-fluid">
    <div class="well">
        <div class="row">
            <div class="col-xs-2">
                <h3>
                    Fichier source
                </h3>
                <div id="src">init</div>
            </div> 
            <div class="col-xs-8 text-center">
                <h3>
                    Correspondance des colonnes
                </h3>
            </div> 
            <div class="col-xs-2">
                <h3>Fichier referentiel</h3>
                <div id="ref">init</div>
            </div> 
        </div>
    </div>
</div>
-->

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-2">
            <h3>
                <span class="glyphicon glyphicon-file"></span>
                Source
            </h3>
            <div id="src_columns"></div>
        </div>
        <div class="col-xs-8">
            <div class="row">
                <div class="col-xs-12">
                    <h3 style="display: inline-block;">
                        Association des colonnes
                    </h3>
                    <button class="btn btn-success2" id="bt_add_bloc">
                        Nouvelle association&nbsp;
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 text-center" id="blocs"></div>
            </div>
        </div>
        <div class="col-xs-2">
            <h3>
                <span class="glyphicon glyphicon-file"></span>
                Référentiel
            </h3>
            <div id="ref_columns"></div>
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



<script type="text/javascript" src="<?php echo base_url('assets/jquery-3.2.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.ui.widget.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.iframe-transport.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.fileupload.js');?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/project_link_select_columns.js');?>"></script>

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

$(function(){

    // Récupération des metadata du projet de link en cours
    metadata_link = get_metadata('link', '<?php echo $_SESSION['link_project_id'];?>');

    // MAJ du nom du projet
    //$("#project_name").html(metadata_link.display_name);

    // Récupération des ids des projets de normalisation
    project_id_src = metadata_link['current']['source']['project_id'];
    project_id_ref = metadata_link['current']['ref']['project_id'];

    // Récupérartion des métadata du fichier source
    metadata_src = get_metadata('normalize', project_id_src);
    
    // Récupérartion des métadata du fichier referentiel
    metadata_ref = get_metadata('normalize', project_id_ref);

    // Récupération des colonnes sources à ajouter
    columns_src = get_columns(metadata_src);
    columns_ref = get_columns(metadata_ref);

    // Ajout des colonne à l'interface
    $("#src_columns").html(get_columns_html(columns_src, "src"));
    $("#ref_columns").html(get_columns_html(columns_ref, "ref"));



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