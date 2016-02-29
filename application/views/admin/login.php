<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to Cranny Application</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.filer.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/media.css">

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.datetimepicker.full.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.filer.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.weekLine.js"></script>

<!--<script type="text/javascript" src="js/jquery.filer.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js"></script>

<link href='https://fonts.googleapis.com/css?family=Archivo+Narrow:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic' rel='stylesheet' type='text/css'>

</head>
<body>
	<div align="center">
		<div class="logo"><img src="<?php echo base_url(); ?>assets/admin/images/logo.png" alt=""></div>
		<?php  
		$email_id = ($this->input->cookie('remember_me')!='') ? $this->input->cookie('remember_me') : '';
		$pass = ($this->input->cookie('remember_pass')!='') ? $this->input->cookie('remember_pass') : '';			
		?>
        <form method="post" class="form-horizontal" id="login" name="login" action="<?php echo $this->config->item('admin_url');?>/login/validate">
			<h2>Login</h2>
			<table align="center">
				<?php
				if(isset($uname_error))
				{
				  echo '<em class="error server">'.$uname_error.'</em>';             
				}
				?>
				<tr><td colspan="2">
					<input type="text" class="input-feild" placeholder="Email Id" id="username" name="username" autocomplete="off" value="<?php if($email_id) {echo $email_id;}?>">
				</td></tr>
				<tr><td colspan="2">
					<input type="password" class="input-feild" placeholder="Password" id="password" name="password" autocomplete="off" value="<?php if($pass) {echo base64_decode($pass);}?>">
				</td></tr>
				<tr><td colspan="2">
					<input type="checkbox" id="checkbox" name="remember_me" <?php if(isset($_COOKIE['remember_me'])) {echo 'checked="checked"';} ?>>
					<label for="checkbox">Remember me</label>
					<a href="<?php echo base_url(); ?>admin/forgot">Forgot Password?</a>
				</td></tr>
				<tr><td>
					<input type="submit" value="Login" /> </td><td>
					<a href="<?php echo $auth; ?>">Login with Google</a>
				</td></tr>
			</table>
		</form>
	</div>
  	<div class="copy-right">2015 Cranny Application</div>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    	$("#login").validate({
			ignore:":hidden",
			rules :{
				username:{required: true,email:true},
				password: {required: true},    
			},			 			
			messages: {
				username: { required :"Please enter email address",email:"Please enter valid email address"},
				password:{required:"Please enter password"},
			},
			errorElement: "label"		 
		});
    </script>
</body>
</html>