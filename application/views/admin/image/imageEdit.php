<div class="main-content">
    <div class="inner-main">
        <div class="head clearfix">
            <div class="title fl">
                <h2>Edit Gym</h2>
            </div>
        </div>
        <?php if($messagetype == 'error'){?>
        <div style="clear:both">
            <div role="alert" class="alert alert-danger" id="alert-danger" style="display:block; ">
                <i class="fa fa-exclamation-triangle"></i>
                <div id="dangermsg"><?php echo $message;?></div>
                <div class="close"><i class="fa fa-times"></i></div>
            </div>
        </div>
        <?php }?>
        <div class="sub-content">
            <form class="form-horizontal" id="gymUpdate" name="gymUpdate" method="post" action="<?php echo $this->config->item('admin_url');?>/gym/update/<?php echo $this->uri->segment(4);?>" enctype="multipart/form-data">
            <span class="mandatory_fields">* Denotes Mandatory Fields</span>
            <div id="tabs">
                <ul class="tabing">
                    <li><a href="#tabs-1" id="generaltab">general Details</a></li>
                    <li><a href="#tabs-2" id="othertab">OTHER Details</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tabs-1">
                        <div class="form">
                            <div class="form-row">
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label"><em>*</em>Gym Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Gym Name" id="gym_name" name="gym_name" value="<?php echo $gym[0]['gym_name']; ?>" maxlength="100">
                                        <?php echo form_error('gym_name'); ?>
                                    </div>
                                </div>                            
                                <div class="form-cell">
                                    <div class="form-row">
                                        <div class="form-cell">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <div class="radio">
                                                <label class="inline-radio"><input type="radio" class="input-radio" id="published-yes" name="isActive" value="1" <?php if($gym[0]['isActive']=='1') {?> checked="checked" <?php }?>><span>Active</span></label>
                                                <label class="inline-radio"><input type="radio" class="input-radio" id="published-no" name="isActive" value="0" <?php if($gym[0]['isActive']=='0') {?> checked="checked" <?php }?>><span>Inactive</span></label>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="form-cell">
                                        <div class="form-group">
                                            <label class="form-label">Approved Status</label>
                                            <div class="radio">
                                                <label class="inline-radio"><input type="radio" class="input-radio" id="published-yes" name="isApproved" value="1" <?php if($gym[0]['isApproved']=='1') {?> checked="checked" <?php }?>><span>Yes</span></label>
                                                <label class="inline-radio"><input type="radio" class="input-radio" id="published-no" name="isApproved" value="0" <?php if($gym[0]['isApproved']=='0') {?> checked="checked" <?php }?>><span>No</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><em>*</em>Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Enter Description"><?php echo $gym[0]['description']; ?></textarea>
                                <?php echo form_error('description'); ?>
                            </div>
                            <div class="form-row">
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label"><em>*</em>Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address" id="address1" name="address1" value="<?php echo $gym[0]['address1']; ?>" maxlength="150">
                                        <?php echo form_error('address1'); ?>
                                    </div>
                                </div>
                                <!--<div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label">Address2</label>
                                        <input type="text" class="form-control" placeholder="Enter Address2" id="address2" name="address2" value="<?php echo $gym[0]['address2']; ?>" maxlength="50">
                                    </div>
                                </div>-->
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label"><em>*</em>City</label>
                                        <input type="text" class="form-control" placeholder="Enter City Name" id="city" name="city" value="<?php echo $gym[0]['city']; ?>" maxlength="50">
                                        <?php echo form_error('city'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">                            
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label"><em>*</em>Country</label>
                                        <select class="form-control" id="country" name="country" onchange="setStates('<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2).'/getStates'; ?>',this.value);">
                                            <option value="">Select Country</option>
                                            <?php if($countries) { for($c=0;$c<count($countries);$c++) { ?>
                                            <option value="<?php echo $countries[$c]['country_id'];?>" <?php if($gym[0]['country']==$countries[$c]['country_id']) { ?> selected="selected"<?php } ?>><?php echo $countries[$c]['name'];?></option>
                                            <?php } } ?>
                                        </select>
                                        <?php echo form_error('country'); ?>
                                    </div>
                                </div>
                                <div class="form-cell">
                                    <div class="form-group" id="sel_states">
                                        <label class="form-label">State</label>
                                        <select class="form-control" id="state" name="state">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">                            
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label"><em>*</em>Zipcode</label>
                                        <input type="text" class="form-control" placeholder="Enter Zipcode" name="zipcode" id="zipcode" value="<?php echo $gym[0]['zipcode']; ?>" maxlength="8" />
                                        <?php echo form_error('zipcode'); ?>
                                    </div>
                                </div>
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label"><em>*</em>Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Enter Contact Number" name="contact_number" id="contact_number" value="<?php echo $gym[0]['contact_number']; ?>" maxlength="15" />
                                        <?php echo form_error('contact_number'); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tabs-2">
                        <div class="form">    
                            <div class="form-row">
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label">Amenities</label>
                                        <div class="form-scroll">                                    
                                        <?php if($amenities) { ?>
                                            <ul>
                                            <?php for($a=0;$a<count($amenities);$a++) { 
                                            ?>
                                                <li>
                                                    <input type="checkbox" class="chkkettlebells" name="amenity[]" <?php if(in_array($amenities[$a]['amenity_id'],$gym_amenities)) { ?> checked="checked" <?php } ?> value="<?php echo $amenities[$a]['amenity_id'];?>">
                                                    <span class="cust_checkbox"></span><?php echo $amenities[$a]['amenity'];?>
                                                </li>
                                            <?php } ?>
                                            </ul>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <div class="msg-label">Recommended Minimum Size : 800x600</div>
                                        <input type="file" name="gymfiles[]" id="filer_input" multiple>
                                        <?php if(count($gym_images)) {
                                            for($i=0;$i<count($gym_images);$i++) {
                                                $imagePath = $this->config->item('image_url').'/gympictures/resized/';
                                                $imgSrc = $imagePath.$gym_images[$i]['imagename'];
                                                $image_id = $gym_images[$i]['image_id'];
                                        ?>
                                            <div id="img<?php echo $image_id;?>">
                                                <img src="<?php echo $imgSrc; ?>" width="100" height="100" /><a class="remove-upload" onclick="deleteImage('<?php echo $image_id;?>','<?php echo $gym_images[$i]['imagename'];?>')" href="javascript:void(0);">Delete</a>
                                            </div>
                                        <?php } } ?>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="form-row resp_form-row">
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label lable-title">Timing</label>
                                        <ul class="timing-list" id="seltiming">
                                            <li class="first_li">
                                                <div class="cell-status">
                                                    <label class="label-block">Status</label>
                                                    <select class="form-control" name="isClosed[]" id="isClosed">
                                                        <option value="0">Open</option>
                                                        <option value="1">Close</option>
                                                    </select>
                                                </div>
                                                <div class="cell-day">
                                                    <label class="label-block">Select start to end day</label>
                                                    <div class="positionrelative">
                                                        <input id="selectedDays1" type="text" class="form-control weekCal" value="" name="selectedDays[]" />
                                                        <div class="week-popup">
                                                            <span id="weekCal1" class="weekDays-dark"></span>	
                                                        </div>
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <div class="cell-time">
                                                    <label class="label-block">Select start to end time</label>
                                                    <div class="time-input fl">
                                                         <div class="start-time fl">
                                                            <input type="text" maxlength="2" tabindex="1" placeholder="00" class="form-control time-valid" value="" id="start_hour" name="start_hour[]" />
                                                            <input type="text" maxlength="2" tabindex="2" placeholder="00" class="form-control time-valid" value="" id="start_minute" name="start_minute[]" />
                                                            <span class="divider">:</span>
                                                         </div> 
                                                         <div class="time-select">
                                                            <select tabindex="3" class="form-control" name="start_meridiem[]" id="start_meridiem">
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                         </div>
                                                      </div>
                                                      <div class="time-input fr">
                                                         <div class="start-time fl">
                                                            <input tabindex="4" type="text" maxlength="2" placeholder="00" class="form-control time-valid" value="" id="end_hour" name="end_hour[]" />
                                                            <input tabindex="5" type="text" maxlength="2" placeholder="00" class="form-control time-valid" value="" id="end_minute" name="end_minute[]" />
                                                            <span class="divider">:</span>
                                                         </div>                                                     
                                                         <div class="end-time fl">                                                        
                                                         </div> 
                                                         <div class="time-select">
                                                            <select tabindex="6" class="form-control" name="end_meridiem[]" id="end_meridiem">
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                         </div>
                                                      </div>
                                                  <?php /*?><div class="form-row inner-row">
                                                     <div class="form-cell">
                                                        <div class="positionrelative">
                                                           <input type="text" class="form-control timepicker" value="" id="start_time1" name="start_time[]" />
                                                           <i class="fa fa-clock-o"></i>
                                                       </div>
                                                     </div>
                                                     <span class="todatetext">to</span>
                                                     <div class="form-cell">
                                                        <div class="positionrelative">
                                                        <input type="text" class="form-control timepicker" value="" id="end_time1" name="end_time[]" />
                                                        <i class="fa fa-clock-o"></i>
                                                       </div>
                                                     </div>
                                                  </div><?php */?>
                                                </div>
                                                <label>&nbsp;</label>
                                                <div class="addrow">
                                                    <a href="javascript:void(0);" id="addTiming"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </li>         
                                            <?php if(count($gym_timings)) { $tc = 8;
                                                for($i=0;$i<count($gym_timings);$i++) {
                                                    $isClosed = $gym_timings[$i]['isClosed'];
                                                    $timing_id = $gym_timings[$i]['timing_id'];
                                                    $start_day = $gym_timings[$i]['start_day'];
                                                    $end_day = $gym_timings[$i]['end_day'];
                                                    if($start_day && $end_day)
                                                        $selectedDays = $start_day.'-'.$end_day;
                                                    else if($start_day && !$end_day)
                                                        $selectedDays = $start_day;
                                                    
                                                    $start_hour = '';
                                                    $start_minute = '';
                                                    $start_meridiem = '';
                                                    $end_hour = '';
                                                    $end_minute = '';
                                                    $end_meridiem = '';
                                                    
                                                    if($gym_timings[$i]['start_time']!='')
                                                    {
                                                        $start_time = ($gym_timings[$i]['start_time']!='') ? strtoupper(date("g:i a", strtotime($gym_timings[$i]['start_time']))) : '';
                                                        $parts = explode(":",$start_time);													
                                                        $start_hour = $parts[0];													
                                                        $subparts = explode(" ",$parts[1]);
                                                        $start_minute = $subparts[0];
                                                        $start_meridiem = $subparts[1];
                                                    }
                                                                                                    
                                                    if($gym_timings[$i]['end_time']!='')
                                                    {
                                                        $end_time = ($gym_timings[$i]['end_time']!='') ? strtoupper(date("g:i a", strtotime($gym_timings[$i]['end_time']))) : '';
                                                        $eparts = explode(":",$end_time);													
                                                        $end_hour = $eparts[0];													
                                                        $esubparts = explode(" ",$eparts[1]);
                                                        $end_minute = $esubparts[0];
                                                        $end_meridiem = $esubparts[1];
                                                    }
                                                    
                                            ?>
                                            <li id="<?php echo $timing_id; ?>">
                                                <input type="hidden" name="timing_id[]" value="<?php echo $timing_id; ?>" />
                                                <div class="cell-status">
                                                    <select class="form-control" name="isClosed[]" id="isClosed">
                                                        <option value="0" <?php if($isClosed==0) { ?> selected="selected" <?php } ?>>Open</option>
                                                        <option value="1" <?php if($isClosed==1) { ?> selected="selected" <?php } ?>>Close</option>
                                                    </select>
                                                </div>
                                                <div class="cell-day">
                                                    <div class="positionrelative">
                                                        <input id="selectedDays<?php echo $tc;?>" type="text" class="form-control weekCal" value="<?php echo $selectedDays; ?>" name="selectedDays[]" onkeypress="return false;" />
                                                        <div class="week-popup">
                                                            <span id="weekCal<?php echo $tc;?>" class="weekDays-dark"></span>	
                                                        </div>
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <div class="cell-time">
                                                    <div class="time-input fl">
                                                         <div class="start-time fl">
                                                            <input type="text" maxlength="2" tabindex="1" placeholder="00" class="form-control time-valid" value="<?php echo $start_hour; ?>" id="start_hour" name="start_hour[]" />
                                                            <input type="text" maxlength="2" tabindex="2" placeholder="00" class="form-control time-valid" value="<?php echo $start_minute; ?>" id="start_minute" name="start_minute[]" />
                                                            <span class="divider">:</span>
                                                         </div> 
                                                         <div class="time-select">
                                                            <select tabindex="3" class="form-control" name="start_meridiem[]" id="start_meridiem">
                                                                <option value="AM" <?php if($start_meridiem=="AM") { ?> selected="selected"<?php } ?>>AM</option>
                                                                <option value="PM" <?php if($start_meridiem=="PM") { ?> selected="selected"<?php } ?>>PM</option>
                                                            </select>
                                                         </div>
                                                      </div>
                                                      <div class="time-input fr">
                                                         <div class="start-time fl">
                                                            <input tabindex="4" type="text" maxlength="2" placeholder="00" class="form-control time-valid" value="<?php echo $end_hour; ?>" id="end_hour" name="end_hour[]" />
                                                            <input tabindex="5" type="text" maxlength="2" placeholder="00" class="form-control time-valid" value="<?php echo $end_minute; ?>" id="end_minute" name="end_minute[]" />
                                                            <span class="divider">:</span>
                                                         </div>                                                     
                                                         <div class="end-time fl">                                                        
                                                         </div> 
                                                         <div class="time-select">
                                                            <select tabindex="6" class="form-control" name="end_meridiem[]" id="end_meridiem">
                                                                <option value="AM" <?php if($end_meridiem=="AM") { ?> selected="selected"<?php } ?>>AM</option>
                                                                <option value="PM" <?php if($end_meridiem=="PM") { ?> selected="selected"<?php } ?>>PM</option>
                                                            </select>
                                                         </div>
                                                      </div>
                                                  <?php /*?><div class="form-row inner-row">
                                                     <div class="form-cell">
                                                        <div class="positionrelative">
                                                           <input type="text" class="form-control timepicker" value="<?php echo $start_time; ?>" id="start_time" name="start_time[]" />
                                                           <i class="fa fa-clock-o"></i>
                                                       </div>
                                                     </div>
                                                     <span class="todatetext">to</span>
                                                     <div class="form-cell">
                                                        <div class="positionrelative">
                                                        <input type="text" class="form-control timepicker" value="<?php echo $end_time; ?>" id="end_time" name="end_time[]" />
                                                        <i class="fa fa-clock-o"></i>
                                                       </div>
                                                     </div>
                                                  </div><?php */?>
                                                </div>
                                                <div class="addrow removerow">
                                                    <!--<a href="javascript:void(0);" onclick="removeTiming(<?php echo $timing_id; ?>);"><i class="fa fa-times"></i></a>-->
                                                    <a href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                                </div>
                                            </li>                                        
                                            <script>										
                                            $("#weekCal<?php echo $tc;?>").weekLine({
                                                mousedownSel: false,
                                                onChange: function () {
                                                    $("#selectedDays<?php echo $tc;?>").val(
                                                        $(this).weekLine('getSelected' ,'descriptive')
                                                    );
                                                }
                                             });
                                             <?php /*?>$("#weekCal<?php echo $tc;?>").weekLine("setSelected", $("#selectedDays<?php echo $tc;?>").val());<?php */?>
                                            </script>
                                            <?php
                                                $tc++;
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-cell">
                                    <div class="form-group">
                                        <label class="form-label lable-title">Fees</label>
                                        <div id="selfees">
                                            <div class="form-row row first_div">
                                                <div class="form-column">
                                                    <label class="label-block">Time period</label>
                                                    <input type="text" class="form-control datetimepicker" value="" placeholder="Enter your time period" name="time_period[]" id="time_period" />
                                                </div>
                                                <div class="form-column">
                                                    <div class="input-relative">
                                                        <label class="label-block">Fees amount</label>
                                                        <span class="doller-sign"><i class="fa fa-usd"></i></span>
                                                        <input type="text" class="form-control datetimepicker valid-fees" value="" placeholder="Enter fees amount" name="fees[]" id="fees" />
                                                    </div>
                                                </div>
                                                <label>&nbsp;</label>
                                                <div class="addrow">
                                                    <a href="javascript:void(0);" id="addFees"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>  
                                        
                                            <?php /*?><div id="addedfees"></div> <?php */?>   
                                            <?php if(count($gym_fees)) {
                                                for($i=0;$i<count($gym_fees);$i++) {
                                                    $time_period = $gym_fees[$i]['time_period'];
                                                    $fees = $gym_fees[$i]['fees'];		
                                                    $fees_id = $gym_fees[$i]['fees_id'];																		
                                            ?>      
                                            <div class="form-row row" id="<?php echo $fees_id; ?>">
                                                <input type="hidden" name="fees_id[]" value="<?php echo $fees_id; ?>" />
                                                <div class="form-column">
                                                    <input type="text" class="form-control datetimepicker" value="<?php echo $time_period; ?>" placeholder="Enter your time period" name="time_period[]" id="time_period" />
                                                </div>
                                                <div class="form-column">
                                                    <div class="input-relative">
                                                        <span class="doller-sign"><i class="fa fa-usd"></i></span>
                                                        <input type="text" class="form-control datetimepicker valid-fees" value="<?php echo $fees; ?>" placeholder="Enter fees amount" name="fees[]" id="fees" />
                                                    </div>
                                                </div>
                                                <div class="addrow removerow">
                                                    <!--<a href="javascript:void(0);" onclick="removeFees(<?php echo $fees_id; ?>);"><i class="fa fa-times"></i></a>-->
                                                    <a href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                                </div>
                                            </div>                                          
                                            <?php }} ?>
                                        </div>                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn">
                    <button class="fr-btn kp-btn" type="submit"><i class="fa fa-floppy-o"></i><span>Save</span></button>
                    <button class="fr-btn cancel-btn kp-btn" type="button" onclick="backtolist();">
                    	<i class="fa fa-times"></i><span>Cancel</span>
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>	
</div>
<script>
$(document).ready(function() {
	setStates('<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2).'/getStates'; ?>','<?php echo $gym[0]['country']; ?>','<?php echo $gym[0]['state']; ?>');
});
	 
$(document).ready(function(){
	$('.kp-btn').click(function(e) {
		$('#generaltab').click();
	});	
	$("#weekCal1").weekLine({
		mousedownSel: false,
		onChange: function () {
			$("#selectedDays1").val(
				$(this).weekLine('getSelected' ,'descriptive')
			);
		}
	});
	//$('.timepicker').wickedpicker();
	 
    var maxField = 7; //Input fields increment limitation
    
    var x = 1; //Initial field counter is 1 for fees
	var y = 1; //Initial field counter is 1 for timings
    
	// For Timings
	$("#addTiming").click(function(){ //Once add button is clicked

        if(y < maxField){ //Check maximum number of input fields
            y++; //Increment field counter
			
			var tfieldHTML = '<li><div class="cell-status"><select class="form-control" name="isClosed[]" id="isClosed"><option value="0">Open</option><option value="1">Close</option></select></div><div class="cell-day"><div class="positionrelative"><input id="selectedDays'+y+'" type="text" class="form-control weekCal" value="" name="selectedDays[]" /><div class="week-popup"><span id="weekCal'+y+'" class="weekDays-dark"></span></div><i class="fa fa-calendar"></i></div></div><div class="cell-time"><div class="time-input fl"><div class="start-time fl"><input type="text" maxlength="2" tabindex="1" placeholder="00" class="form-control time-valid" value="" id="start_hour" name="start_hour[]" /><input type="text" maxlength="2" tabindex="2" placeholder="00" class="form-control time-valid" value="" id="start_minute" name="start_minute[]" /><span class="divider">:</span></div><div class="time-select"><select tabindex="3" class="form-control" name="start_meridiem[]" id="start_meridiem"><option value="AM">AM</option><option value="PM">PM</option></select></div></div><div class="time-input fr"><div class="start-time fl"><input tabindex="4" type="text" maxlength="2" placeholder="00" class="form-control time-valid" value="" id="end_hour" name="end_hour[]" /><input tabindex="5" type="text" maxlength="2" placeholder="00" class="form-control time-valid" value="" id="end_minute" name="end_minute[]" /><span class="divider">:</span></div><div class="end-time fl"></div><div class="time-select"><select tabindex="6" class="form-control" name="end_meridiem[]" id="end_meridiem"><option value="AM">AM</option><option value="PM">PM</option></select></div></div></div><div class="addrow removerow"><i class="fa fa-times"></i></div></li>'; //New input field html 
			
            $("#seltiming .first_li").after(tfieldHTML); // Add field html
			
			$("#weekCal"+y).weekLine({
				mousedownSel: false,
				onChange: function () {
					$("#selectedDays"+y).val(
						$(this).weekLine('getSelected' ,'descriptive')
					);
				}
			 });
			 $(".weekCal").keypress(function(e) {
				$(this).attr('readonly','readonly');
			});
			 //$('.timepicker').wickedpicker();
			 $('select').select2();
			 
			 $(".time-valid").keypress(function (e) {
				 //if the letter is not digit then display error and don't type anything
				 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					//display error message
					return false;
				}
			 });
        }
    });
	
    $("#seltiming").on('click', '.removerow', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('li').remove(); //Remove field html
        y--; //Decrement field counter
    });
	
	
	// For fees
	$("#addFees").click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
			var fieldHTML = '<div class="form-row row"><div class="form-column"><input type="text" class="form-control datetimepicker" value="" placeholder="Enter your time period" name="time_period[]" /></div><div class="form-column"><div class="input-relative"><span class="doller-sign"><i class="fa fa-usd"></i></span><input type="text" class="form-control datetimepicker valid-fees" value="" placeholder="Enter fees amount" name="fees[]" /></div></div><div class="addrow removerow"><i class="fa fa-times"></i></div></div>'; //New input field html 
            $("#selfees .first_div").after(fieldHTML); // Add field html
			
			$(".valid-fees").keypress(function (e) {
				//this.value = this.value.replace(/[^0-9\.]/g,'');
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
						e.preventDefault();
					}
				}
			});
        }
    });
	
    $("#selfees").on('click', '.removerow', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });	
		
});


$.validator.addMethod("NumbersOnly", function(value, element) {
	return this.optional(element) || /^[0-9\-\+\ \(\)]+$/i.test(value);
}, "Phone must contain only numbers +  , - , ( , ) .");

$.validator.addMethod("Checkatleastmindigit", function(value, element) {
	return this.optional(element) || /^(?=([^\d]*\d){8,}[^\d]*$)[\d\(\)\s+-]{8,}$/i.test(value);
}, "Phone must contain 8 digit.");
				
$("#gymUpdate").validate({
	ignore:":hidden",
	rules :{
		gym_name: {required: true},
		address1: {required: true},
		city: {required: true},
		country: {required: true},
		description: {required: true},
		//state: {required: true},
		zipcode: {required: true},
		contact_number: {required: true,minlength:8,NumbersOnly:true,Checkatleastmindigit:true},
	},			 			
	messages: {
		gym_name :{required :"Please enter gym name"},
		address1 :{required :"Please enter address"},
		city :{required :"Please enter city"},
		country :{required :"Please select country"},
		description :{required :"Please enter description"},
		//state :{required :"Please select state"},
		zipcode: {required :"Please enter zipcode"},
		contact_number: {required :"Please enter contact number",minlength:"Contact number should have at least 8 digit."},
	},
	errorElement: "em"		 
});			

function deleteImage(imageid,imagename)
{
	$( "#dialog-confirm" ).dialog
	({
		 height:170,
		 resizable:false,
		 width: 350,
		 modal: true,
		 closeText: "hide",
		 draggable: false,
		 buttons: 
		 {
			"Delete": function() 
			{
				var finalUrl = '<?php echo $this->config->item('admin_url'); ?>/gym/deleteimage';
								
				$.ajax({
					url:finalUrl,
					data:"imagename="+imagename+"&imageid="+imageid,
					type:'POST',
					success:function(res)
					{
						$('#img'+imageid).remove();
					},
					error:function(data) 
					{
					},
				});
				$(this).dialog("close");
			},
			Cancel: function() 
			{				
				$('.chk-style .fa-check').hide();
				$( this ).dialog( "close" );
			}
		}
	});
}

function removeTiming(id) // not needed for now
{
	if(id)
	{
		var baseurl = '<?php echo $this->config->item('admin_url');?>/gym/deleteGymTiming';
		
		$.ajax({
			url: baseurl,
			data:"baseurl="+baseurl+"&timing_id="+id,	
			type:'POST',
			success:function(res)
			{
				if(res) $('li #'+id).remove();
			}
		});
	}
}

function removeFees(id) // not needed for now
{
	if(id)
	{
		var baseurl = '<?php echo $this->config->item('admin_url');?>/gym/deleteGymFees';
		
		$.ajax({
			url: baseurl,
			data:"baseurl="+baseurl+"&fees_id="+id,	
			type:'POST',
			success:function(res)
			{
				if(res) $('div #'+id).remove();
			}
		});
	}
}
$(document).ready(function(e) {
    $("input[type=text]").on('input',function () {
		if($(this).val().length == $(this).attr('maxlength')) {
			$(this).next("input").focus();
		}
	});
});

$(document).ready(function () {
  //called when key is pressed in textbox
  $(".time-valid").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     	return false;
    }
});

$(".valid-fees").keypress(function (e) {
	//this.value = this.value.replace(/[^0-9\.]/g,'');
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
			e.preventDefault();
		}
	}
});
$(".weekCal").keypress(function(e) {
    $(this).attr('readonly','readonly');
});

});
</script>