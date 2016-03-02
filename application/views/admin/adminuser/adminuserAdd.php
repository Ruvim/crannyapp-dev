	<section>
		<div class="content-wrapper">
			<h1><a href="<?php echo $this->config->item('admin_url'); ?>/dashboard">Home</a> >> Add <a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>"><?php echo ucfirst($this->uri->segment(2));?></a>
			</h1>
			
			<form class="form-horizontal" id="adminuserAdd" name="adminuserAdd" method="post" action="<?php echo $this->config->item('admin_url');?>/<?php echo $this->uri->segment(2);?>/add" enctype="multipart/form-data">
				<?php 
				if(set_value('isActive')=="1") 
					{$isActive = '1';} 
				else if(set_value('isActive')=="0") 
					{$isActive = '0';} 
				else
					{$isActive = '1';}
	
				if(set_value('user_role')=="1") 
					{$user_role = '1';} 
				else if(set_value('user_role')=="2") 
					{$user_role = '2';} 
				else
					{$user_role = '1';}
				?>
				<div class="frm">
    				<div class="frm-row">
						<div class="frm-col-1">
							<label>User Name</label><input type="text" name="user_name" id="user_name" value="<?php echo set_value('user_name'); ?>" maxlength="50" />
							<?php echo form_error('user_name'); ?>
						</div>
						<div class="frm-col-2"> 
							<label>Email</label><input type="text" name="email" id="email" maxlength="100" value="<?php echo set_value('email'); ?>" />
							<?php echo form_error('email'); ?>
						</div>
						<div class="clear-b"></div>
					</div>
					<div class="frm-row">
						<div class="frm-col-1">
							<label>Password</label><input type="password" name="password" id="password" maxlength="20" value="" />
						</div>
						<div class="frm-col-2">
							<label>Role</label>
							<div class="radio">
								<label class="inline-radio"><input type="radio" class="input-radio" id="admin" name="user_role" value="1" <?php if($user_role=='1') {?> checked="checked" <?php }?>><span>Admin</span></label>
								<label class="inline-radio"><input type="radio" class="input-radio" id="subscriber" name="user_role" value="2" <?php if($user_role=='2') {?> checked="checked" <?php }?>><span>Subscriber</span></label>
							</div>
						</div>
						<?php /*?><div class="frm-col-2"><label>Status</label>
							<div class="radio">
								<label class="inline-radio"><input type="radio" class="input-radio" id="published-yes" name="isActive" value="1" <?php if($isActive=='1') {?> checked="checked" <?php }?>><span>Active</span></label>
								<label class="inline-radio"><input type="radio" class="input-radio" id="published-no" name="isActive" value="0" <?php if($isActive=='0') {?> checked="checked" <?php }?>><span>Inactive</span></label>
							</div>
						</div><?php */?>
						<div class="clear-b"></div>
					</div>
				</div>	 
  				<div class="clear-b"></div>
				<button class="btn" type="submit"><i class="fa fa-floppy-o"></i><span>Save</span></button>
				<button class="btn" type="button" onclick="backtolist();"><i class="fa fa-times"></i><span>Cancel</span></button>
			</form>
			<div></div>    
		</div>
	</section>
	<script>
	$.validator.addMethod("CustomEmail", function(value, element) {
		return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
	}, "Email Address is invalid: Please enter a valid email address.");
		
	$("#adminuserAdd").validate({
		ignore:":hidden",
		rules :{
			user_name: {required: true},
			email: {required: true,  CustomEmail:true},				
		},			 			
		messages: {
			user_name :{required :"Please enter user name"},
			email :{required :"Please enter email"},				
		},
		errorElement: "em"
	});
	</script>