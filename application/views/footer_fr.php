<style type="text/css">
	#panel_comment{
		border-radius:  5px 5px 0 0;
		position: fixed;
		bottom: -360px;
		left: 20px;
		width: 350px;
		border: 1px solid #777;
		background-color: #262626;
	}
	#panel_comment .row{
		margin-bottom: 10px;
		margin-top: 10px;
	}
	#panel_comment .panel-title{
		color: #fff;
		cursor: pointer;
	}
	#panel_comment .title_comment{
		font-weight: bolder;
		display: inline-block;
		margin-right: 15px;
		margin-left: 15px;
	}
	#panel_comment .txt_comment{
		color: #fff;
		font-weight: bolder;
		font-style: italic;
	}
	#bt_comment{
		background-color: #25368C;
		border-bottom-width: 0;
	}
	body{
		height: 100%;
	}

	footer{
		background-color: #182023;
		padding-top: 20px;
		padding-bottom: 20px;
		height: 120px;
	}
		footer .txt{
			color: #aaa;
			/*font-weight: bolder;*/
		}
		footer .title{
			text-transform: uppercase;
			display: inline-block;
			padding-bottom: 10px;
		}
		footer li{
			list-style: none;
		}
		footer .col-right{
			border-left: 3px dotted #333;
		}
		footer a,a:hover{
			color: #aaa;
			text-decoration: none;
		}
</style>

<footer class="container-fluid" style="background-color: #262626;padding-top: 20px;">
	<div class="row" style="background-color: #262626;color:#fff;">
		<div class="col-md-offset-1 col-md-5">
			<img src="https://dataesr.enseignementsup-recherche.pro/images/dataESR.svg" alt="Logo dataESR" class="logo_dataesr" style="height:60px;">
			<br>
			<br>
			<span itemprop="name">
				<a target="_blank" href="http://www.enseignementsup-recherche.gouv.fr/" itemprop="url">
					Ministère de l'Enseignement supérieur, de la Recherche et de l'Innovation
				</a>
			</span>
			<br>
			<br>
			<p itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
				<span itemprop="streetAddress">1 rue Descartes</span><br>
				<span itemprop="postalCode">75231</span> <span itemprop="addressLocality">Paris</span> <span itemprop="postOfficeBoxNumber">cedex 05</span><br> <span itemprop="addressCountry">France</span><br>
				<a href="<?php echo base_url("index.php/Home/contact");?>" target="_blank">
					<i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Contact
				</a>
			</p>
		</div>
		<div class="col-md-offset-1 col-md-5">
			<br>
			<strong>Plan du site :</strong>
			<br>
			<br>
			<ul>
				<li>
					<a href="<?php echo base_url("index.php/Home");?>" target="_blank">
					Accueil
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("index.php/User/new");?>" target="_blank">
					Identification
					</a>
				</li>
				<li	>
					<a href="<?php echo base_url("index.php/Home/referentials");?>" target="_blank">
					Référentiels à disposition
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("index.php/Home/cgu");?>" target="_blank">
					Conditions Générales d'Utilisation
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("index.php/Home/about");?>" target="_blank">
					A propos
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("index.php/Home/faq");?>" target="_blank">
					Foire Aux Questions
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("index.php/Home/contact");?>" target="_blank">
						<i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Contact
					</a>
				</li>
			</ul>

			<!-- <hr style="border-top-color: #333;">
			<div class="alert alert-success alert-dismissible fade in" style="display:none" id="alert_newsletter">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  Adresse enregistrée avec succès !
			</div>
			<div id="input_newsletter">
				<form class="form-inline">
					<input type="email" class="form-control" id="email_newsletter" placeholder="Abonnez-vous à la newsletter" style="width: 70%;"/>
					<button type="button" id="bt_newsletter" class="btn btn-success2">S'inscrire</button>
				</form>
				<br>
			</div> -->

		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<br>
			<strong style="color: #ccc;">Les sites publics :</strong>
			<a target="_blank" href="http://www.service-public.fr" title="Accèder au site service-public.fr (nouvelle fenêtre)" style="color: #777674;">service-public.fr</a>
			| <a target="_blank" href="http://legifrance.gouv.fr/" title="Accèder au site legifrance.gouv.fr (nouvelle fenêtre)" style="color: #777674;">legifrance.gouv.fr</a>
			| <a target="_blank" href="http://www.gouvernement.fr/" title="Accèder au site gouvernement.fr (nouvelle fenêtre)" style="color: #777674;">gouvernement.fr</a>
			| <a target="_blank" href="http://data.gouv.fr/" title="Accèder au site data.gouv.fr (nouvelle fenêtre)" style="color: #777674;">data.gouv.fr</a>
			| <a target="_blank" href="http://france.fr/" title="Accèder au site france.fr (nouvelle fenêtre)" style="color: #777674;">france.fr</a>
		</div>
	</div>
</footer>

<div class="panel panel-default" id="panel_comment">
  <div class="panel-heading" id="bt_comment">
    <h3 class="panel-title text-center">
		<span class="glyphicon glyphicon-chevron-up"></span>
	    <span class="title_comment">Commentaires ?</span>
		<span class="glyphicon glyphicon-chevron-up"></span>
	</h3>
  </div>
  <div class="panel-body">
  <form name="form_comment">
  	<div class="row">
  		<div class="col-md-12">
  			<span class="txt_comment">Un bug, un comportement inatendu, une suggestion...</span>
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<input type="text" class="form-control" placeholder="Votre nom" id="name">
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<input type="text" class="form-control" placeholder="Votre email" id="email2" value="<?php echo @$_SESSION['user']['email']; ?>">
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<textarea class="form-control" rows="4" placeholder="Votre message" id="message_footer"></textarea>
  		</div>
  	</div>
    <div class="row">
    	<div class="col-md-12">
    		<div class="alert alert-danger" role="alert" style="margin-bottom: 0;" id="error_box">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span id="error_msg_comment"></span>
			</div>
    	</div>
    </div>
    <div class="row">
  		<div class="col-md-12 text-right">
  			<button type="submit" class="btn btn-success2" id="bt_submit">Envoyer</button>
  		</div>
  	</div>
  	</form>
  </div>
</div>


<script type="text/javascript">
	$("#error_box").toggle();

	$("#bt_comment").click(function(){
		if($('#panel_comment').hasClass("maximised")){
			panel_minimize();
			delete_errors();
		}
		else{
			panel_maximize();
		}
	});


	$("#bt_submit").click(function(e){
		e.preventDefault();
		send_comment();
	});


	$("#bt_newsletter").click(function(e){
		e.preventDefault();

		email_newsletter();
	});


	function email_newsletter() {
		const email = $("#email_newsletter").val();

		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(!re.test(String(email).toLowerCase())){
			$("#email_newsletter").val("");
			return false;
		}

		// Envoi du commentaire
		$.ajax({
			type: 'post',
			url: '<?php echo base_url('index.php/Save_ajax/save_email_newsletter');?>',
			data: '&email=' + email,
			success: function (result) {
				console.log('Adresse enregistrée');
				$("#email_newsletter").val("");

				$("#alert_newsletter").css("display", "inherit");
				$("#input_newsletter").css("display", "none");

				setTimeout(function(){
					$("#alert_newsletter").css("display", "none");
					$("#input_newsletter").css("display", "inherit");

				}, 2000);

			},
			error: function (result, status, error){
				console.log('save_email_newsletter_ajax - ERREUR :');
			}
		});
	}// /email_newsletter()


	function delete_errors() {
		// Suppression des erreurs
		if($("#error_box").is(":visible")){
			$("#error_box").slideToggle();
		}
	}// /delete_errors()


	function send_comment() {
		// Test des champs
		var msg = "";

		if($("#name").val() == ''){
			msg +=  "Vous devez renseigner votre nom";
		}
		if($("#email2").val() == ''){
			if(msg != ""){
				msg += "<br>";
			}
			msg +=  "Vous devez renseigner votre email";
		}
		if($("#message_footer").val() == ''){
			if(msg != ""){
				msg += "<br>";
			}
			msg +=  "Vous devez renseigner un message";
		}

		if(msg != ""){
			$("#error_msg_comment").html(msg);
			if($("#error_box").is(":hidden")){
				$("#error_box").slideToggle();
			}
			return false;
		}

		// Envoi du commentaire
		send_comment_ajax($("#name").val(), $("#email2").val(), $("#message_footer").val());

		// Suppression de l'alert si existante
		if($("#error_box").is(":visible")){
			$("#error_box").slideToggle();
		}

		// Suppression du message, on garde les autres infos
		$("#message_footer").val("");

		// on replie
		panel_minimize();
	}// /send_comment()


	function panel_minimize() {
		$('#panel_comment')
			.removeClass("maximised")
			.addClass("minimised")
			.css('bottom','-20px')
			.animate({
			  bottom : '-360px'
		});
		ch = '<span class="glyphicon glyphicon-chevron-up"></span><span class="title_comment">Commentaires ?</span><span class="glyphicon glyphicon-chevron-up"></span>';
		$("#panel_comment .panel-title").html(ch);
	}// /panel_minimize()


	function panel_maximize() {
		$('#panel_comment')
			.removeClass("minimised")
			.addClass("maximised")
			.css('bottom','-360px')
			.animate({
				bottom : '-20px'
		});
		ch = '<span class="glyphicon glyphicon-chevron-down"></span><span class="title_comment">Commentaires ?</span><span class="glyphicon glyphicon-chevron-down"></span>';
		$("#panel_comment .panel-title").html(ch);
	}// /panel_maximize()


	function send_comment_ajax(name, email, message) {
		// Récupération de l'URL
		var url = window.location.href;

		if (typeof project_id == "undefined") {
			var project_id = 'NC';
		}
		if (typeof project_type == "undefined") {
			var project_type = 'NC';
		}

		// Envoi du commentaire
        $.ajax({
            type: 'post',
            url: '<?php echo base_url('index.php/Save_ajax/comment');?>',
            data: 'name=' + name + '&email=' + email + '&message=' + message + '&url=' + url + '&project_id=' + project_id + '&project_type=' + project_type,
            async: false,
            success: function (result) {
            	console.log('send_comment_ajax - SUCCESS :');
                console.log("result : ",result);
            },
            error: function (result, status, error){
            	console.log('send_comment_ajax - ERREUR :');
                console.log(result);
                console.log(status);
                console.log(error);
                return false;
            }
        });
	}
</script>

<!-- stats -->
<noscript><img src="https://piwik.enseignementsup-recherche.pro/piwik.php?idsite=24&rec=1" style="border:0;" alt="" /></noscript>
<script type="text/javascript">
	<!--
	xtnv = document;
	xtsd = "https://logs4";
	xtsite = "124090";
	xtn2 = "";
	xtpage = "75";
	xtdi = "";
	xt_multc = "";
	xt_an = "";
	xt_ac = "";

	if (window.xtparam!=null){
		window.xtparam+="&ac="+xt_ac+"&an="+xt_an+xt_multc;
	}
	else{
		window.xtparam="&ac="+xt_ac+"&an="+xt_an+xt_multc;
	}
	-->
</script>

<script type="text/javascript" src="<?php echo base_url("assets/xtcore.js");?>"></script>

<noscript>
	<img width="1" height="1" alt="" src="https://logs4.xiti.com/hit.xiti?s=124090&s2=&p=75&di=&an=&ac=" >
</noscript>

</body>
</html>
