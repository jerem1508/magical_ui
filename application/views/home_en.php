<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Accueil-En</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css');?>">

	<script type="text/javascript" src="<?php echo base_url('assets/jquery-3.2.1.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js');?>"></script>
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
                    <?php
                    if(isset($_SESSION['user'])){
                        echo "<li><a href='".base_url("index.php/User/dashboard")."'><span class='glyphicon glyphicon-th' aria-hidden='true'></span>&nbsp;&nbsp;Dashboard</a></li>";
                        echo "<li><a href='".base_url("index.php/User/logout")."'><span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp;&nbsp;Logout</a></li>";
                    }
                    else{
                        echo "<li><a href='".base_url("index.php/User/login")."'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span>&nbsp;&nbsp;Login</a></li>";
                    }
                    ?>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo base_url("index.php/Config/change_language/fr/Home");?>"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>&nbsp;&nbsp;Français</a></li>
                </ul>
            </div><!-- /dropdown-->
		</div>
	</div>

	<hr>


	<div class="jumbotron">
	<h1>Magical_ui</h1> 
	<p>Bootstrap is the most popular HTML, CSS, and JS framework for developing
	responsive, mobile-first projects on the web.</p> 
	</div>

	<div class="well">
		<h2>Create a new project</h2>
		<div class="row">
			<div class="col-xs-6" style="padding-right: 10px;">
				<h3>File normalization</h3>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Nullam cursus, lorem tincidunt cursus gravida, magna lacus egestas nulla, at aliquet nunc mi non est. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
				<button class="btn btn-lg btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/normalize');?>';">Start a normalization project</button>
			</div><!--/col-xs-6-->
			<div class="col-xs-6" style="padding-left: 10px;border-left: 1px solid #999;">
				<h3>Joining files</h3>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Nunc nec eros luctus, malesuada nulla quis, molestie felis. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Nullam cursus, lorem tincidunt cursus gravida, magna lacus egestas nulla, at aliquet nunc mi non est. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Nunc eleifend est ut erat cursus pellentesque. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>
				<button class="btn btn-lg btn-success" onclick="window.location.href='<?php echo base_url('index.php/Project/link');?>';">Start a joining project</button>
			</div><!--/col-xs-6-->
		</div><!--/row-->
	</div><!--/well-->

	<?php
	if(!isset($_SESSION['user'])){
	?>
	<div class="well">
		<h2>Create an account</h2>
		
		<div class="row">
			<div class="col-xs-6">
				<h3>Why become a member ?</h3>
				<p>
					Proin est neque, mattis a venenatis et, accumsan sagittis dui. Proin vitae lectus erat. Morbi iaculis non mi a lacinia. Proin eros mi, tempor in ex in, sagittis consequat urna. Pellentesque quis faucibus mi. Praesent vel leo congue, porttitor ipsum eget, euismod felis. Nullam imperdiet posuere volutpat. Fusce dolor erat, pulvinar non faucibus sit amet, faucibus vitae tellus. Suspendisse consequat tellus dui, quis fermentum urna pulvinar at. Nunc lacus eros, varius sit amet sapien vulputate, viverra vestibulum magna. Donec sed enim velit.
				</p>

				<a href='<?php echo base_url("index.php/User/login");?>' class="btn btn-success">Already a member ?</a>
			</div><!--/col-xs-6-->
			<div class="col-xs-6">
				<form>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Email adress</label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Password</label>
				    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				    <label for="exampleInputPassword1">Confirm</label>
				    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				  </div>
				  <div class="text-right">
				  	<button type="submit" class="btn btn-success">Submit</button>
				  </div>
				</form>
			</div><!--/col-xs-6-->

		</div><!--/row-->
	</div><!--/well-->
	<?php
	}
	?>

</div><!--/container-->

</body>
</html>