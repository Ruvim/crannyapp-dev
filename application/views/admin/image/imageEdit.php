	<section>
		<div class="content-wrapper">
			<h1><a href="<?php echo $this->config->item('admin_url'); ?>/dashboard">Home</a> >> Add <a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>"><?php echo ucfirst($this->uri->segment(2));?></a>
			</h1>
			
			<form class="form-horizontal" id="imageUpdate" name="imageUpdate" method="post" action="<?php echo $this->config->item('admin_url');?>/<?php echo $this->uri->segment(2);?>/update/<?php echo $this->uri->segment(4);?>" enctype="multipart/form-data">
				<?php 
				if(set_value('isActive')=="1") 
					{$isActive = '1';} 
				else if(set_value('isActive')=="0") 
					{$isActive = '0';} 
				else
					{$isActive = '1';}
				?>
				<div class="frm">
    				<div class="frm-row">
						<div class="frm-col-1">
							<label>Image Title</label><input type="text" name="image_title" id="image_title" value="<?php echo $image[0]['image_title']; ?>" maxlength="50" />
							<?php echo form_error('image_title'); ?>
						</div>
						<div class="frm-col-2"> 
							<label>Images</label><input type="file" name="imagefiles[]" id="filer_input" /><!--multiple-->
							<?php if($image[0]['imagename']) { $imgpath = $this->config->item('base_url').'/assets/uploads/pictures/resized/'.$image[0]['imagename']; ?>
							<div>
								<img src="<?php echo $imgpath; ?>" height="100" width="100" />
							</div>
							<?php } ?>
						</div>
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
	/*$("#imageUpdate").validate({
		ignore:":hidden",
		rules :{
			image_title: {required: true}
		},			 			
		messages: {
			image_title :{required :"Please enter image title"}	
		},
		errorElement: "em"
	});*/
	</script>