
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container" style="margin-top: 20px;">
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
        <!--
            <div class="col-md-4">
                <button class="btn btn-success2" id="dl_cfg_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier de configuration</button>
            </div>
        -->
            <div class="col-md-8">
                <button class="btn btn-success2" id="dl_file"><span class="glyphicon glyphicon-download"></span>&nbsp;Téléchargement du fichier final</button>
            </div>


        <?php
        if(isset($_SESSION['user']))
        {
        ?>
            <div class="col-md-4 text-right">
                <button class="btn btn-success" id="bt_next">Voir mon tableau de bord >></button>
            </div>
        <?php
        }
        ?>
        </div><!-- /row-->
    </div><!-- /well /report-->
</div><!--/container-->

<script type="text/javascript">
    function write_reports(module_name) {
        // Download config
        //MINI__source_1.csv__run_info.json
        //MINI__source_1.csv
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
            url: '<?php echo BASE_API_URL;?>' + '/api/download_config/normalize/<?php echo $_SESSION["project_id"];?>/',
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
                    write_report_html(result.result.mod_count, "report_" + module_name, true);
                }
            },
            error: function (result, status, error){
                console.log("error");
                console.log(result);
                err = true;
            }
        });// /ajax - Download config
    }
    
// Init - Ready
    $(function() {

        $("#dl_file").click(function(){
            tparams = {
                "data_params": {
                    "module_name": "concat_with_init",
                    "file_name": file_name
                }
            }

            $.ajax({
                type: 'post',
                url: '<?php echo BASE_API_URL;?>' + '/api/download/normalize/<?php echo $_SESSION['project_id'];?>',
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