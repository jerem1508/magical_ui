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
		<div class="col-md-12 text-right">
			<a href="<?php echo base_url("index.php/Home");?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Accueil</a>
			|
            <?php
            if(isset($_SESSION['user'])){
                echo "<a href='".base_url("index.php/User/dashboard")."'><span class='glyphicon glyphicon-th' aria-hidden='true'></span>&nbsp;&nbsp;Tableau de bord</a>";
                echo "&nbsp;|&nbsp;";
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

