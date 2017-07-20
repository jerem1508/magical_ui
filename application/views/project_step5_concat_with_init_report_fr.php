<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Normalisation</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery.dataTables.min.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css');?>">

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
            <a href="<?php echo base_url("index.php/Project/normalize");?>" class="done">Sélection du fichier</a>
            <a href="<?php echo base_url("index.php/Project/add_selected_columns");?>" class="done">Sélection des colonnes</a>
            <a href="<?php echo base_url("index.php/Project/replace_mvs");?>" class="done">Valeurs manquantes</a>
            <a href="<?php echo base_url("index.php/Project/recode_types");?>" class="done">Détection des types</a>
            <a href="#" class="active">Téléchargements</a>
        </div>
    </div>

    <div class="well">
        <h2><span id="project_name"></span> : Traitement & téléchargements - <i>Rapports</i></h2>
    </div><!-- /well-->
</div><!--/container-->

<div class="container">
    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <h4>Etape 1 : Sélection des colonnes</h4>
            </div>
            <div class="row">
                <div class="col-md-6"><b>Colonnes initiales</b></div>
                <div class="col-md-6"><b>Colonnes sélectionnées</b></div>
            </div>
            <div class="row">
                <div class="col-md-6" id="report_original_columns"></div>
                <div class="col-md-6" id="report_selected_columns"></div>
            </div>
        </div><!-- /row-->
    </div><!-- /well /report-->

    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <h4>Etape 2 : Recherche des valeurs manquantes - <i>Modifications effectuées</i></h4>
            </div>
            <div id="report_replace_mvs"></div>
        </div><!-- /row-->
    </div><!-- /well /report-->

    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <h4>Etape 3 : Détection des types - <i>Modifications effectuées</i></h4>
            </div>
            <div id="report_recode_types"></div>
        </div><!-- /row-->
    </div><!-- /well /report-->

    <div class="well">
        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-success2" id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier de configuration</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success2" id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier final</button>
            </div>


        <?php
        if(isset($_SESSION['user']))
        {
        ?>
            <div class="col-md-4 text-right">
                <button class="btn btn-success" id="bt_next" disabled>Voir mon tableau de bord >></button>
            </div>
        <?php
        }
        ?>
        </div><!-- /row-->
    </div><!-- /well /report-->
</div><!--/container-->

<script type="text/javascript" src="<?php echo base_url('assets/jquery-3.2.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.ui.widget.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.iframe-transport.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.fileupload.js');?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/functions.js');?>"></script>

<script type="text/javascript">
    
// Init - Ready
    $(function() {

        $.ajax({
            type: 'get',
            url: '<?php echo BASE_API_URL;?>' + '/api/metadata/normalize/<?php echo $_SESSION['project_id'];?>',
            success: function (result) {

                if(result.error){
                    console.log("API error");
                    console.log(result.error);
                }
                else{
                    console.log("success - metadata");
                    console.dir(result);

                    metadata = result.metadata;

                    $("#project_name").html(metadata.display_name);

                    // Récupération du nom de fichier
                    file_name = Object.keys(metadata.files)[0];

                    write_reports("replace_mvs");
                    write_reports("recode_types");

                }
            },
            error: function (result, status, error){
                console.log(result);
                console.log(status);
                console.log(error);
                err = true;
            }
        });// /ajax metadata


       

    }); // /ready


</script>