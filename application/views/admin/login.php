<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<title>Cranny Application - Admin Panel</title>
<!--[if lt IE 9]>
<![endif]-->

<!--[if lt IE 9]>
<![endif]-->
<link href="<?php echo base_url(); ?>assets/admin/css/dataportal.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/admin/css/media-queries.css" rel="stylesheet" type="text/css">

</head>
<body>
	<div id="login-wrapper">
	<header>
		<div><img src="<?php echo base_url(); ?>assets/admin/images/spacer.gif" title="a16z" /></div>
	</header>
	<section>
		<div class="login-wrapper">
    		<div id="login-content">
				<h1>Welcome to the <br/>Cranny App</h1>
				<form method="post" class="form-horizontal" id="login" name="login" action="<?php echo $this->config->item('admin_url');?>/login/validate">
    				<div class="login-frm">
    					<p><input type="text" placeholder="Email Address" id="username" name="username" autocomplete="off"></p>
        				<div class="clear-b"></div>
        				<p><input type="password" placeholder="Password" id="password" name="password" autocomplete="off"></p>
    					<p>
							<input type="submit" class="btn" value="LOGIN" />
							<label class="lbl-or">Or</label>
							<a href="<?php echo $authUrl; ?>" class="google-btn">Login with Google</a>
						</p>
        				<div class="clear-b"></div>
        			</div>
			       <p class="forgot-link"> <a href="<?php echo $this->config->item('admin_url');?>/forgot">Forgot Your Password?</a></p>
	   			</form>
    		</div>
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
		 	<footer>
            	<p><a href="http://www.a16z.com" target="_blank">a16z.com</a></p>
        	</footer>
		</div>
	</section>
	<div class="clear-b"></div>
</div>
</body>
</html>