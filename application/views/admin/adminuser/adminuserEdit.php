<div class="container">
    <div style="clear:both">
		<?php if($messagetype == 'success'){?>
		<div role="alert" class="alert alert-success">
			<i class="fa fa-check"></i>
			<?php echo $message;?>
            <div class="close">X</div>
		</div>
		<?php }if($messagetype == 'error'){?>
		<div role="alert" class="alert alert-danger">
			<i class="fa fa-exclamation-triangle"></i>
			<?php echo $message;?>
            <div class="close">X</div>
		</div>
		<?php }?>
	</div>     	
	<!-- Breadcrumb -->
	<ol class="breadcrumb">
    	<li><a href="<?php echo $this->config->item('admin_url'); ?>/dashboard">Home</a></li>
    	<li><a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>"><?php echo ucfirst($this->uri->segment(2));?></a></li>
    	<li class="active">Edit Adminuser</li>
 	</ol>
    <!-- Breadcrumb -->

    <div class="page-title-header">
 	<h2 class="page-title">Edit Adminuser  <!--<a class="dark-blue-button"><i class="fa fa-search"></i>View Preview</a>--></h2>
 	<label class="infodenotes denotes"><b>*</b> Denotes Mandatory Fields</label> 
    </div> 
	<section id="addAdminuser">        
		<!-- row of columns -->
      	<form class="form-horizontal" id="adminuserEdit" name="adminuserEdit" method="post" action="<?php echo $this->config->item('admin_url');?>/adminuser/update/<?php echo $this->uri->segment(4);?>" enctype="multipart/form-data">        	                                           
            <div class="form-group">
				<label for="adminusername" class="col-sm-3 control-label denotes"><strong>*</strong> Name</label>
                <div class="col-sm-7">
                	<input type="text" class="form-control" id="adminusername" name="name" value="<?php echo $adminuser[0]['name']; ?>" maxlength="50" placeholder="Enter Name">
                    <?php echo form_error('name'); ?>   
                </div>
            </div>
           
            <div class="form-group">
                <label for="email" class="col-sm-3 control-label denotes"><strong>*</strong>Email</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" placeholder="Enter Email" name="email" id="email" maxlength="100" value="<?php echo $adminuser[0]['email']; ?>"  />
                    <?php echo form_error('email'); ?>  
                </div>
            </div>
			 <div class="form-group">
                <label for="password" class="col-sm-3 control-label denotes"><strong>*</strong> Password</label>
                <div class="col-sm-7">
                    <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" maxlength="50" value="<?php echo base64_decode($adminuser[0]['password']); ?>"  />
                    <?php echo form_error('password'); ?>  
                </div>
            </div>
           
            <div class="form-group">
                <label class="col-sm-3 control-label"> Publish</label>
                <div class="col-sm-7" style="height:40px;">
                    <input type="radio" id="published-yes" name="isActive" value="1" <?php if($adminuser[0]['isActive'] == 1){echo 'checked';}?>>
                    <label for="published-yes" class="radio-label"> Yes </label>
                    <input type="radio" id="published-no" name="isActive" value="0" <?php if($adminuser[0]['isActive'] == 0){echo 'checked';}?>>
                    <label for="published-no" class="radio-label"> No </label>
                </div>
            </div> 
             			
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-7">
                	<button type="submit" class="btn btn-default dark-blue-button" id="addAuthorsButton"><i class="fa fa-save"></i>Save</button>
                  	<a href="<?php echo $this->config->item('admin_url')."/".$this->uri->segment(2);?>" class="dark-blue-button" id="reset"><i class="fa fa-remove"></i>Cancel</a>
					
                </div>
            </div>
		</form>                                 
    </section>
</div> <!-- /container -->

<script>	 

$.validator.addMethod("NumbersOnly", function(value, element) {
        return this.optional(element) || /^[0-9\-\+\(\)]+$/i.test(value);
	    }, "Phone must contain only numbers, + and -.");
 $.validator.addMethod("CustomEmail", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
            }, "Email Address is invalid: Please enter a valid email address.");		
$("#adminuserEdit").validate({
	 rules :{
		name: {required: true},
		email:{required: true, CustomEmail:true},
		password: {required: true,minlength:6},
	 },			 			
	 messages: {
		name: {required :"Please enter user name"},	
		email:{ required :"Please enter email address"},			
		password:{required:"Please enter password",minlength:"Password should have at least 6 characters."},		
	 },
	 errorElement: "em"		 
});	
	
	
</script>

