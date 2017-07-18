<style type="text/css">
	#panel_comment{
		border-radius:  5px 5px 0 0;
		position: fixed;
		bottom: -370px;
		right: 20px;
		width: 350px;
	}
	#panel_comment .row{
		margin-bottom: 10px;
		margin-top: 10px;
	}
	#panel_comment .panel-title{
		color: #777;
		cursor: pointer;
	}

	#panel_comment .title_comment{
		font-weight: bolder;
		display: inline-block;
		margin-right: 15px;
		margin-left: 15px;
	}
	#panel_comment .txt_comment{
		color: #777;
		font-weight: bolder;
		font-style: italic;
	}
	body{
		margin-bottom: 50px;
	}
	footer .txt{
		color: #777;
		font-weight: bolder;		
	}
</style>

<footer>
    <div class="row">
        <div class="col-md-12 text-center txt">
            EIG 2017 - MESRI
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
  			<span class="txt_comment">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<input type="text" class="form-control" placeholder="Votre nom">
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<input type="email" class="form-control" placeholder="Votre email">
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12">
  			<textarea class="form-control" rows="4" placeholder="Votre message"></textarea>
  		</div>
  	</div>
    <div class="row">
  		<div class="col-md-12 text-right">
  			<button type="submit" class="btn btn-success" id="bt_submit">Envoyer</button>
  		</div>
  	</div>
  	</form>
  </div>
</div>

<script type="text/javascript">
	$("#bt_comment").click(function(){
		if($('#panel_comment').hasClass("maximised")){
			panel_minimize();
		}
		else{
			panel_maximize();
		}
	});

	$("#bt_submit").click(function(e){
		e.preventDefault();
		send_comment();

		// on replie
		panel_minimize();
	});

	function send_comment() {
		alert("envoi du commentaire")
	}

	function panel_minimize() {
		$('#panel_comment')
			.removeClass("maximised")
			.addClass("minimised")
			.css('bottom','-20px')
			.animate({
			  bottom : '-370px'
		});
		ch = '<span class="glyphicon glyphicon-chevron-up"></span><span class="title_comment">Commentaires ?</span><span class="glyphicon glyphicon-chevron-up"></span>';
		$("#panel_comment .panel-title").html(ch);
	}

	function panel_maximize() {
		$('#panel_comment')
			.removeClass("minimised")
			.addClass("maximised")
			.css('bottom','-370px')
			.animate({
				bottom : '-20px'
		});
		ch = '<span class="glyphicon glyphicon-chevron-down"></span><span class="title_comment">Commentaires ?</span><span class="glyphicon glyphicon-chevron-down"></span>';
		$("#panel_comment .panel-title").html(ch);
	}
</script>