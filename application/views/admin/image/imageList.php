<style type="text/css">
	span.stars, span.stars span {
		display: block;
		background: url(<?php echo base_url(); ?>/assets/admin/images/stars.png) 0 -16px repeat-x;
		width: 80px;
		height: 16px;
	}
	span.stars span {
		background-position: 0 0;
	}
</style>
<div class="main-content">
    <div class="inner-main">
        <div class="head_filter">
            <form name="frm_search" id="frm_search" action="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>" method="post">
                <div class="head">
                    <div class="clearfix">
                        <div class="title fl">
                            <h2>Gym</h2>
                        </div>
                        <div class="right_head">            	
                            <div class="input-search">
                                <i class="icon-search"></i>
                                <input type="text" class="search-feild" placeholder="Search by name" id="search_string" name="search_string">
                                <!--=============================common sorting fields======================== -->
                                <input type="hidden" value="g.gym_id" id="fieldName" name="fieldName">
                                <input type="hidden" value="desc" id="orderType" name="orderType">
                                <!--=============================common sorting fields======================== -->
                                <a href="#" class="clear_search" onclick="fun_clear_singlesearch();"></a>
                            </div>	
                            <div class="input-search">
                                <input type="submit" class="btn-search" value="Search">
                            </div>
                            <div class="filter">
                               <span class="filter-toggle" title="Filter">
                                    <i class="fa fa-filter"></i>
                                    <i class="fa fa-times"></i>
                               </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter-toggleslide">
                  <div class="filter-frm">
                    <div class="filter-item">
                        <input type="text" placeholder="Select start date" class="input-feild" onchange="fun_filter();" name="startdate" id="startdate" readonly style="cursor:pointer;" maxlength="50" value="">
                    </div>
                    <div class="filter-item">
                        <input type="text" placeholder="Select end date" class="input-feild" onchange="fun_filter();" name="enddate" id="enddate" readonly style="cursor:pointer;" maxlength="50" value="">
                    </div>
                    <div class="filter-item">
                        <select class="input-feild" name="srchisActive" id="srchisActive" onChange="fun_filter();">
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <input type="hidden" value="" id="myclear" name="myclear">
                        <input type="hidden" value="" id="srchgym_string" name="srchgym_string">
                    </div>
                    <div class="filter_action"><a class="filter_search dark-blue-button kp-btn" title="Refresh" href="javascript:void(0);" onclick="fun_clear();"><i class="fa fa-refresh"></i></a></div>
               	  </div>
                </div>
                <div style="clear:both">
                    <div role="alert" class="alert alert-success" id="alert-success" style="display:none;">
                        <i class="fa fa-check"></i>
                        <div id="successmsg">successfully!</div>
                        <div class="close" id="closemsg">X</div>
                    </div>
                    <div role="alert" class="alert alert-danger" id="alert-danger" style="display:none;">
                        <i class="fa fa-exclamation-triangle"></i>
                        <div id="dangermsg">Danger</div>
                        <div class="close" id="closemsg">X</div>
                    </div>
                </div>
            </form>
        </div>
        <div class="table_listing">
            <div class="table-header clearfix">
                <div class="btn-perform fl">
                    <a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>/add" class="btn-add kp-btn"> <i class="fa fa-plus"></i> Add Gym</a>
                    <a onclick="deleteall('');" class="btn-delete kp-btn"> <i class="fa fa-times"></i> DELETE</a>
                    <a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>/exportToexcel" class="btn-export kp-btn"><i class="fa fa-file-excel-o"></i>EXPORT</a>
                    <a onclick="fun_sel_chagestatus('','1');" class="btn-delete kp-btn"> <i class="fa fa-check"></i> Active All</a>
                    <a onclick="fun_sel_chagestatus('','0');" class="kp-btn"> <i class="fa fa-times"></i> Inactive All</a>
                </div>
                <div class="table-headerRt fr">
                    <div class="disply-record">
                        <span class="lable-text">Records Per Page</span>
                        <?php 			
							if($this->uri->segment(5)!='')
							{
								$limit = $this->uri->segment(5);
							}
							elseif($this->uri->segment(4)!='')
							{
								$limit = $this->uri->segment(4);
							}
							else
							{
								$limit = $this->Gymmodel->get_pagesize('gym'); // new added by chi
							}
						?>
                        <div class="record-select">
                            <select name="pagesize" class="input-feild pagesize" onchange="changepagesize(this.value,'');">
                            	<option <?php if($limit == 5){?> selected <?php } ?>>5</option>
                                <option <?php if($limit == 20){?> selected <?php } ?>>20</option>
                            	<option <?php if($limit == 40){?> selected <?php } ?>>40</option>
                            	<option <?php if($limit == 60){?> selected <?php } ?>>60</option>
                            	<option <?php if($limit == 80){?> selected <?php } ?>>80</option>                            
                            	<option  value="0" <?php if($limit == 0){?> selected <?php } ?>>All</option>
                            </select> 
                        </div>
                    </div>
                    <div class="pagination">
                        <?php echo $this->pagination->create_links_ajax();?>
                    </div>
                </div>
            </div>
            <div class="table-content">
                <table class="table_saller">
                    <tr>
                        <th style="width:40px;padding:0;" align="center"><label class="chk-style"><input type="checkbox" id="selectAll"  name="selecctall" value="" onClick="selectall()"> <i class="fa fa-check"></i></label></th>
                        <th align="left"><a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('gym_name','')">Gym Name <i class="fa fa-sort"></i></a></th>
                        <th style="width:100px;" align="center">Ratings</th>
                        <th style="width:100px;"><a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('state','')">State <i class="fa fa-sort"></i></a></th>
                        <th style="width:145px;"><a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('contact_number','')">Contact No. <i class="fa fa-sort"></i></a></th>                        <th style="width:100px;"><a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('u.first_name','')">Added By <i class="fa fa-sort"></i></a></th>
                        <th style="width:90px;"><a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('spam_count','')">Spam <i class="fa fa-sort"></i></a></th>
                        <th style="width:130px;"><a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('g.isApproved','')">Approved <i class="fa fa-sort"></i></a></th>
                        <th style="width:110px;"><a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('g.isActive','')">Status <i class="fa fa-sort"></i></a></th>
                        <th style="width:110px;">Actions</th>
                    </tr>
                    <?php
					if(count($gym) > 0)
					{	
						foreach($gym as $row)
						{
							if($row['isActive'] == '1')
							{
								$published = '<a id="status'.$row['gym_id'].'" class="chk_status active" onClick="fun_chagestatus(\''.$row['gym_id'].'\',\'\');">Active</a>';
							}
							else
							{
								$published = '<a id="status'.$row['gym_id'].'" class="chk_status" onClick="fun_chagestatus(\''.$row['gym_id'].'\',\'\');">Inactive</a>';
							}
							
							$userName = ($row['user_id']!='0') ? ucfirst($row['first_name'].' '.$row['last_name']) : 'Admin';
						?>
                        <tr data-id="<?php echo $row['gym_id']; ?>">
                            <td style="width:40px;padding:0;" align="center"class="gym-check" ><label class="chk-style"><input type="checkbox" class="checkbox1" name="itemId[]" value="<?php echo $row['gym_id']; ?>" /> <i class="fa fa-check"></i></label></td>
                            <td class="gym-name"><?php echo $row['gym_name'];?></td>
                            <td style="width:100px;" class="gym-rating">
                            	<span class="stars"><?php echo $row['overall_ratings']; ?></span>                                
                            </td>
                            <td style="width:100px;" class="gym-time" align="center"><?php echo $row['state_name'];?></td>
                            <td style="width:145px;" class="gym-contact" align="center"><?php echo $row['contact_number'];?></td>
                            <td style="width:145px;" class="gym-contact" align="center">
                            	<?php if($row['user_id']!='0') { ?>
                            	<div id="tooltip" class="tooltip">
                             		<div class="tooltiop-hover">
										<?php 
                                        if($row['profile_pic']!='')
                                            $profilePic = base_url().'assets/uploads/profilepictures/resized/'.$row['profile_pic']; 
                                        else if($row['social_profile_pic']!='')
                                            $profilePic = $row['social_profile_pic'];
                                        else
                                            $profilePic = base_url().'assets/admin/images/tooltip-image.png';								
                                        ?>
                                        <span class="tooltiop-img"><img src="<?php echo $profilePic; ?>" /></span>
                                        <span class="tooltiop-title"><?php echo $userName;?></span>
                               		</div>
                                    <div id="tooltip-info" class="tooltip-info" style="display:none">
                                        <div class="tooltip-row">
                                            <span class="tooltip-label">Email</span>
                                            <div class="tooltip-value"><?php echo $row['email']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php } else { ?>
                                <div class="tooltiop-hover">
                                	<span class="tooltiop-img"><img src="<?php echo base_url().'assets/admin/images/user-image.png'; ?>" /></span>
                                    <span class="tooltiop-title"><?php echo $userName;?></span>
                                </div>
                                <?php } ?>
                             </td>                            
                            <td style="width:90px;" class="gym-contact" align="center"><?php echo $row['spam_count'];?></td>
                            <td style="width:120px;" class="gym-contact" align="center"><?php if($row['isApproved']) {echo "Yes";} else {echo "No";} ?></td>
                            <td style="width:100px;" class="gym-status" align="center"><?php echo $published; ?></td>
                            <td style="width:110px;" class="gym-action" align="center">
                                <a href="<?php echo $this->config->item('admin_url').'/gym/update/'.$row['gym_id']; ?>" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                <a onclick="delete_data('<?php echo $row['gym_id']; ?>','')" title="Delete"><i class="fa fa-trash"></i></a>
                                <a href="<?php echo $this->config->item('admin_url').'/gym/review/'.$row['gym_id']; ?>" title="Review">
                                <i><img src="<?php echo base_url(); ?>/assets/admin/images/star2.png" alt=""></i></a>
                            </td>
                        </tr>
                    <?php 
						} 
					}
					else
					{
					?>
                    <tr><td colspan="8"><center>No gym found.</center></td></tr>
                    <?php } ?>
                </table>
            </div>
            <div class="table-footer clearfix">
                <div class="table-headerRt fr">
                    <div class="disply-record">
                        <span class="lable-text">Records Per Page</span>
                        <?php 			
							if($this->uri->segment(5)!='')
							{
								$limit = $this->uri->segment(5);
							}
							elseif($this->uri->segment(4)!='')
							{
								$limit = $this->uri->segment(4);
							}
							else
							{
								$limit = $this->Gymmodel->get_pagesize('gym'); // new added by chi
							}
						?>
                        <div class="record-select">                        
                            <select name="pagesize" class="input-feild pagesize" onchange="changepagesize(this.value,'');">
                            	<option <?php if($limit == 5){?> selected <?php } ?>>5</option>
                                <option <?php if($limit == 20){?> selected <?php } ?>>20</option>
                            	<option <?php if($limit == 40){?> selected <?php } ?>>40</option>
                            	<option <?php if($limit == 60){?> selected <?php } ?>>60</option>
                            	<option <?php if($limit == 80){?> selected <?php } ?>>80</option>                            
                            	<option  value="0" <?php if($limit == 0){?> selected <?php } ?>>All</option>
                            </select>    
                        </div>
                    </div>
                    <div class="pagination">
                        <?php echo $this->pagination->create_links_ajax();?>
                    </div>
                </div>
                <div class="btn-perform fl">
                	<a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>/add" class="btn-add kp-btn"> <i class="fa fa-plus"></i> Add Gym</a>
                    <a onclick="deleteall('');" class="btn-delete kp-btn"> <i class="fa fa-times"></i> DELETE</a>
                    <a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>/exportToexcel" class="btn-export kp-btn"><i class="fa fa-file-excel-o"></i>EXPORT</a>
                    <a onclick="fun_sel_chagestatus('','1');" class="btn-delete kp-btn"> <i class="fa fa-check"></i> Active All</a>
                    <a onclick="fun_sel_chagestatus('','0');" class="kp-btn"> <i class="fa fa-times"></i> Inactive All</a>
                </div>
            </div>	
        </div>
    </div>	
</div>
<script type="text/javascript">
	<?php if($this->session->flashdata("flash_type") == 'success'){?>
		document.getElementById('alert-danger').style.display = 'none';
		document.getElementById('alert-success').style.display = 'block';
		$('#successmsg').html('<?php echo $this->session->flashdata("flash_message");?>');
	<?php }if($this->session->flashdata("flash_type") == 'error'){?>
		document.getElementById('alert-success').style.display = 'none';
		document.getElementById('alert-danger').style.display = 'block';
		$('#dangermsg').html('<?php echo $this->session->flashdata("flash_message");?>');
	<?php }?>	
	$(function() {
		$('span.stars').stars();
	});
	
	jQuery(function(){
		jQuery('#startdate').datetimepicker({
			format:'Y/m/d',
			onShow:function( ct ){
			this.setOptions({
			maxDate:jQuery('#enddate').val()?jQuery('#enddate').val():false
			})
		},
			timepicker:false
		});
		jQuery('#enddate').datetimepicker({
			format:'Y/m/d',
			onShow:function( ct ){
				this.setOptions({
				minDate:jQuery('#startdate').val()?jQuery('#startdate').val():false
			})
		},
		timepicker:false
		});		
	});
	
	
	$(document).ready(function() {
		
		$('.tooltip').tooltipster({
			contentAsHTML: true,
			functionInit: function(){
				return $(this).find('.tooltip-info').html();
			},
			functionReady: function(){
				$(this).find('.tooltip-info').attr('aria-hidden', false);
			},
			functionAfter: function(){
				$(this).find('.tooltip-info').attr('aria-hidden', true);
			}
		});
		
	});
	
</script>

