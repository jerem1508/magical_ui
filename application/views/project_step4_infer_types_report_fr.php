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
            <a href="<?php echo base_url("index.php/Project/load_step2_select_columns");?>" class="done">Sélection des colonnes</a>
            <a href="<?php echo base_url("index.php/Project/load_step3_missing_values");?>" class="done">Valeurs manquantes</a>
            <a href="#" class="active">Détection des types</a>
            <a href="#" class="todo">Téléchargement</a>
        </div>
    </div>

    <div class="well">
        <h2><span id="project_name"></span> : <i>Recherche des valeurs manquantes</i></h2>
    </div><!-- /well-->

    <div class="well" id="report">
        <h2>Rapport : </h2>
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="<?php echo base_url('assets/img/report.png');?>" style="height: 150px;">
            </div>
            <div class="col-md-9">
                <h3>Modifications effectuées</h3>
                <div id="tab_reports"></div>
                <!--
                <a id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier</a>
                -->
            </div>

        </div><!-- /row-->

        <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn btn-success" id="bt_next">Etape suivante : Traitement et téléchargement >></button>
            </div>
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
    
        $("#bt_next").click(function(){
            window.location.href = "<?php echo base_url('index.php/Project/concat_with_init/'.$_SESSION['project_id']);?>";
        });

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
                }
            },
            error: function (result, status, error){
                console.log(result);
                console.log(status);
                console.log(error);
                err = true;
            }
        });// /ajax metadata


        var tparams = {
            "module_name": "recode_types"
        }

        $.ajax({
            type: 'post',
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            url: '<?php echo BASE_API_URL;?>' + '/api/last_written/normalize/<?php echo $_SESSION['project_id'];?>',
            data: JSON.stringify(tparams),
            success: function (result) {

                if(result.error){
                    console.log("API error - last_written");
                    console.log(result.error);
                }
                else{
                    console.log("success - last_written");
                    console.dir(result);

                    // Download config
                    //MINI__source_1.csv__run_info.json
                    //MINI__source_1.csv
                    var tparams = {
                        "data_params": {
                            "module_name": "recode_types",
                            "file_name": result.file_name + "__run_info.json"
                        }
                    }
                    console.dir(tparams);

                    $.ajax({
                        type: 'post',
                        dataType: "json",
                        contentType: "application/json; charset=utf-8",
                        url: '<?php echo BASE_API_URL;?>' + '/api/download_config/normalize/<?php echo $_SESSION['project_id'];?>/',
                        data: JSON.stringify(tparams),
                        success: function (result) {

                            if(result.error){
                                console.log("API error - download_config");
                                console.log(result.error);
                            }
                            else{
                                console.log("success - download_config");
                                console.dir(result);

                                $('#report').css('display', 'inherit');
                                write_report_html(result.result.mod_count, "tab_reports", true);
                            }
                        },
                        error: function (result, status, error){
                            console.log("error");
                            console.log(result);
                            err = true;
                        }
                    });// /ajax - Download config
                }
            },
            error: function (result, status, error){
                console.log("error");
                console.log(result);
                err = true;
            }
        });// /ajax - last_written



    }); // /ready

</script>