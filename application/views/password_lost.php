
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<style type="text/css">
	h3{
		color: #777;
		/*text-transform: uppercase;*/
	}
	h3::first-letter{
		color: #E00612;
		font-size: 1.5em;
		font-weight: bold;
	}
</style>

<div class="container-fluid" id="body">
	<div class="well text-justify">
		<!-- <div class="row text-center">
			<h1 style="color: #262626">Mot de passe perdu ?</h1>
		</div> -->
        <div class="container" style="padding-top: 40px;">
			<div class="row" style="margin-bottom: 20px;">
				<div class="col-sm-offset-2 col-sm-10">
					Votre mot de passe va être réinitialisé et envoyer sur votre adresse email.
				</div>
			</div>
            <form class="form-horizontal" role="form" method="post" action="index.php">
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Votre email</label>
                    <div class="col-sm-7">
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
                    </div>
                    <div class="col-sm-3">
                        <input id="bt_send" type="button" value="Envoyer nouveau mot de passe" class="btn btn-success">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <! Will be used to display an alert to the user>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(function(){ // ready
        set_height('body');
    });// /ready

	$("#bt_send").click(function(){
		var email = $("#email").val();

		$.ajax({
	        type: 'post',
			url: '<?php echo base_url('index.php/Save_ajax/send_password/');?>',
	        data: "email=" + email,
	        success: function (result) {
				console.log("send_email SUCCESS");
				console.log(result);
				if(result == 'email_ko'){
					alert("Cet email n'est pas connu");
					$("#email").val("");
				}

				document.location.href = "<?php echo base_url('index.php/Home');?>";
	        },
	        error: function (result, status, error){
				console.log("send_email ERROR");
				console.log(result);
				$("#email").val("");
	        }
		});// /ajax
	});
</script>
