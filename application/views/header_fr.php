</head>

<body>
<!-- ENTETE -->
<div class="container-fluid entete">
	<div class="row" >
		<div class="col-xs-2 logo_mesri">
			<img src="<?php echo base_url('assets/img/logo-RF-3@2x.svg');?>" class="img-responsive">
		</div>
		<div class="col-xs-8 text-center logo_site">
			<img src="<?php echo base_url('assets/img/logo_beta4.png');?>"
				 onclick="return_to_homepage();"
				 style="cursor: pointer;">
			<script type="text/javascript">
				function return_to_homepage() {
					window.location.href = '<?php echo base_url("index.php/Home");?>';
				}
			</script>

		</div>
		<div class="col-xs-2 text-right logo_eig">
			<img src="<?php echo base_url('assets/img/une-eig-300x133.png');?>" class="img-responsive">
		</div>
	</div>
</div>
<div class="container-fluid entete2">
	<div class="row">
		<div class="col-md-6 page_title">
			<span id="page_title_project_name"></span>
			<?php echo $title;?>
		</div>
		<div class="col-md-6 text-right">
			<?php
            if(isset($_SESSION['user'])){
				echo '<span style="color:#ccc;font-style: italic;">'.$_SESSION['user']['email'].'</span>';
				echo '<span style="display:inline-block;width:20px;"></span>';
			}
			?>
			<a href="<?php echo base_url("index.php/Home");?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Accueil</a>
			<span style="display:inline-block;width:10px;"></span>
            <?php
            if(isset($_SESSION['user'])){
                echo "<a href='".base_url("index.php/User/dashboard_home")."'><span class='glyphicon glyphicon-th' aria-hidden='true'></span>&nbsp;&nbsp;Tableau de bord</a>";
                echo '<span style="display:inline-block;width:10px;"></span>';
                echo "<a href='".base_url("index.php/User/logout")."'><span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp;&nbsp;Déconnexion</a>";
            }
            else{
                echo "<a href='".base_url("index.php/User/new")."'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span>&nbsp;&nbsp;S'identifier</a>";
            }
            ?>
            <!--
			|
			<a href="<?php echo base_url("index.php/Config/change_language/en/Home");?>"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>&nbsp;&nbsp;English</a>
			-->
		</div>
	</div>
</div>
<!-- /ENTETE -->

<!-- Modal error-->
<div class="modal fade" id="modal_error_api" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #262626">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color: #ddd">Erreur(s) !</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-1">
                <h2 style="margin-top:0;color: #E00612;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></h2>
            </div>
            <div class="col-xs-11" id="api_error_title"></div>
        </div>
		<div class="row">
            <div class="col-xs-12" id="api_error"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<?php
// Affichage eventuel d'un message d'erreur
if(@$server_error){
?>
<div class="container-fluid">
	<div class="alert alert-danger my_alert" role="alert"><?php echo $server_error; ?></div>
</div>
<?php
}
?>
