<!DOCTYPE html>
<html>
<head>
	<title>Erreur</title>
</head>
<body>
	<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">
	<div id="corps">
		<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
			<div class="well text-center">
				Erreur interne sur le serveur<br>
				Les administrateurs ont été prévenus de cette erreur.<br><br>
				Veuillez réessayer plus tard
				<br><br>
				<a href="../Home">Retour Accueil</a>
			</div>	
		</div>
	</div>

	<script type="text/javascript">
		$(function(){
			set_height('corps');
		});
	</script>
</body>
</html>