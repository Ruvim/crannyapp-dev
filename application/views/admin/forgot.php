<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to Outperform Fitness</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.filer.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style.css">

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

<script type="text/javascript" language="javascript">
 window.history.forward(1);
 function noBack()
 {
   window.history.forward();
 }
</script>
</head>
<body>
	<div class="sticky_page">
		<div class="login-container">
    		<div class="login-header">
        		<div class="wraper">
                	<div class="logo"><img src="<?php echo base_url(); ?>assets/admin/images/logo.png" alt=""></div>	
            	</div>
    		</div>
        	<div class="wraper">
            	<form method="post" class="form-horizontal" id="forgotpassword" name="forgotpassword" action="<?php echo $this->config->item('admin_url');?>/forgot/validate">      	                     <!-- server side velidation-->                      
				<?php
                if(isset($uname_error))
                {
                  echo '<em class="error server">'.$uname_error.'</em>';             
                }
				if(isset($succ_msg))
                {
                  echo '<em class="success server">'.$succ_msg.'</em>';             
                }
                ?>
	            <div class="login-contain">
                	<div class="login-innercontain">
                    	<h2>Login</h2>
                    	<div class="login-frm">
                        	<div class="frm">
                            	<span class="input-icon"><i class="fa fa-envelope"></i></span>
                        		<input type="text" class="input-feild" placeholder="Email Id" id="email_id" name="email_id" autocomplete="off" value="">
                        	</div>
                            <div class="frm">
                                <a href="<?php echo base_url(); ?>admin/login" class="forgot-pass fr">Back to Login</a>
                            </div>
                            <div class="frm">
                                <button type="submit" class="btn btn-1 btn-1e">Send Password</button>
                            </div>
                    	</div>
                	</div>
            	</div>
            	</form>
        	</div>
    	</div>
  	</div> 
  	<div class="copy-right">2015 Outperform Fitness LLC</div>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js" type="text/javascript"></script>
	<script type="text/javascript">
    $("#forgotpassword").validate({
        ignore:":hidden",
            rules :{
                email_id:{required: true, email: true}
        },			 			
            messages: {
                email_id: { required :"Please enter email address",email: 'Enter valid email address'},
        },
        errorElement: "label"		 
        });
    </script>
</body>
</html>