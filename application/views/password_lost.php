
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
            <form class="form-horizontal" role="form" method="post" action="index.php">
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Votre email</label>
                    <div class="col-sm-7">
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
                    </div>
                    <div class="col-sm-3">
                        <input id="submit" name="submit" type="submit" value="Envoyer nouveau mot de passe" class="btn btn-success">
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
</script>
