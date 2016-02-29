<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Welcome to Cranny Application</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.datetimepicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.filer.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/wickedpicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/tooltipster.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/media.css">

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.datetimepicker.full.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.filer.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.weekLine.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/wickedpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.tooltipster.js"></script>

<!--<script type="text/javascript" src="js/jquery.filer.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/ckeditor/ckeditor.js"></script>

<link href='https://fonts.googleapis.com/css?family=Archivo+Narrow:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic' rel='stylesheet' type='text/css'>


<script type="text/javascript">
    var unitDataArr;
function fun_hide_msg()
{
	/*setTimeout(function() {   //calls click event after a certain time
	   $(".close").click();
	}, 5000);*/
	$(".alert-success").delay(5000).fadeOut("slow");
	$(".alert-danger").delay(5000).fadeOut("slow");
}

$(document).ready(function() {
	fun_hide_msg();
});

// show star ratings
$.fn.stars = function() {
	return $(this).each(function() {
		// Get the value
		var val = parseFloat($(this).html());
		//alert(val);
		// Make sure that the value is in 0 - 5 range, multiply to get width
		var size = Math.max(0, (Math.min(5, val))) * 16;
		// Create stars holder
		var $span = $('<span />').width(size);
		// Replace the numerical value with stars
		$(this).html($span);
	});
}

// go to list page
function backtolist()
{
	window.location.href = "<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>";	
}

// set states based on country
//function setStates(baseurl,countryid,selId='')
function setStates(baseurl,countryid,selId)
{
	$.ajax({
		url: baseurl,
		data:"baseurl="+baseurl+"&countryid="+countryid+"&selId="+selId,
	
		type:'POST',
		success:function(res)
		{
			$('#sel_states').html(res);
			$('select').select2();
		}
	});
}

/* Function to pagination using AJAX while change page size*/
//function changepagesize(limit,isThirdlevel='')
function changepagesize(limit,isThirdlevel)
{
	if(isThirdlevel!='')
	{
		var eventurl = '<?php echo $this->config->item('admin_url'); ?>/<?php echo $this->uri->segment(2)?>/<?php echo $this->uri->segment(3)?>/<?php echo $this->uri->segment(4)?>'+'/1'; 
		var baseURL = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>/<?php echo $this->uri->segment(3)?>/<?php echo $this->uri->segment(4)?>/chagepagesize';
	}
	else
	{
		var eventurl = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>'+'/1'; 
		var baseURL = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>/chagepagesize';
	}
	var param = limit; // $(this).val(); // get selected value	
	var finalUrl = '';		
	if (param) 
	{ 
		finalUrl = eventurl+'/pagesize/'+param; // redirect
	}
	
	$.ajax({
		url:baseURL,
		data:"limit="+limit,
		type:'POST',
		success:function(res)
		{
			
		}		
	});	
	show_ajax_cardswith_url(finalUrl);
}

// search on all list pages
$(document).on("submit", "#frm_search", function(e){
    e.preventDefault();
    show_ajax_cardswith_url('<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>');
    return  false;
});

/* all for gym review page - starts */
// search on gym review list pages
$(document).on("submit", "#frm_search_review", function(e){
    e.preventDefault();
    show_ajax_cardswith_url('<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4); ?>');
    return  false;
});

// clear search text
function fun_clear_singlesearch_review()
{	  
	$('#search_string').val('');
	$('#frm_search_review').submit();
	return false;
} 

// filter by status
function fun_changestatus_review()
{
	$('#frm_search_review').submit();
	return false;
}

/* Function to select search area */
function fun_clear_review()
{	  
	$('#search_string').val('');
	$('#srchisActive').val('');
	$('#startdate').val('');
	$('#enddate').val('');
	$('#frm_search_review').submit();
	return false;
}

/* all for gym review page - ends */

// clear search text
function fun_clear_singlesearch()
{	  
	$('#search_string').val('');
	$('#frm_search').submit();
	return false;
} 	

// filter by status
function fun_filter()
{
	$('#frm_search').submit();
	return false;
}

/* Function to select search area */
function fun_clear()
{	  
	$('#search_string').val('');
	$('#srchisActive').val('');
	$('#startdate').val('');
	$('#enddate').val('');
	$('#frm_search').submit();
	return false;
}

/* Function for pagination using AJAX */
function show_ajax_cards(obj)
{
	var finalUrl;
	var param = $('.pagesize').val();
		
	var baseurl = obj.id;
	
	if(param) 
	{ 
		finalUrl = baseurl+'/pagesize/'+param; // redirect
	}
	else
	{
		finalUrl = baseurl; // redirect
	}
	var search_string = $('#search_string').val();
	var orderType = $('#orderType').val();
	var fieldName = $('#fieldName').val();
	var srchisActive = $('#srchisActive').val();
	
	var startdate = ($('#startdate').val()!='undefined') ? $('#startdate').val() : '';
	var enddate = $('#enddate').val();
		
	$.ajax({
		url:finalUrl,
		data:"baseurl="+finalUrl+"&search_string="+search_string+"&orderType="+orderType+"&fieldName="+fieldName+"&srchisActive="+srchisActive+"&startdate="+startdate+"&enddate="+enddate,
	
		type:'POST',
		success:function(res)
		{			
			$('.table_listing').html($(res).find('.table_listing').html());
            $('span.stars').stars();
			$('select').select2();
		}
	});
}

/* Function for pagination using AJAX to maintain serch area AND pagesize*/
function show_ajax_cardswith_url(baseurl,fieldname,direction)
{	
	var search_string = $('#search_string').val();
	var orderType = $('#orderType').val();
	var fieldName = $('#fieldName').val();
	var srchisActive = $('#srchisActive').val();
	
	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	
	$.ajax({
		url:baseurl,
		data:"baseurl="+baseurl+"&search_string="+search_string+"&orderType="+orderType+"&fieldName="+fieldName+"&srchisActive="+srchisActive+"&startdate="+startdate+"&enddate="+enddate,
		type:'POST',
		success:function(res)
		{		 
			$('.table_listing').html($(res).find('.table_listing').html());	
            $('span.stars').stars();
			$('#myclear').val('');
			//	name
			if(fieldname!=null)
			{			
				var newfield = fieldname;
				if(newfield.indexOf(".")!= -1)
				{
					fieldname=newfield.replace('.', '_');
				}
				else
				{
					fieldname=fieldname;
				}
				 
				//alert(country.replace('india', 'japan'));
				
				$("#"+fieldname+"_sorting").css('display','none');
				if(direction=="asc")
				{
					$("#"+fieldname).html('<div class="arrow"><span data-toggle="tooltip" data-placement="top" title="Ascending"><i class="fa fa-sort-asc"></i></span></div>');
				}
				else
				{
					$("#"+fieldname).html('<div class="arrow"><span data-toggle="tooltip" data-placement="top" title="Descending"><i class="fa fa-sort-desc"></i></span></div>');				
				}			
			}	  
			$('select').select2();
		},
		error:function(res) 
		{
			// alert(data);
			result = false;			
		}
	});	
} 

/**** Function For Change Order of Display Data in Lising Page **************/
//function changeOrderType(fieldName,isThirdlevel='')
function changeOrderType(fieldName,isThirdlevel)
{
	//alert(isThirdlevel);
	$('#fieldName').val(fieldName);
	if($('#orderType').val()=="desc")
	{
		$('#orderType').val("asc");
		var direction=$('#orderType').val();
	}
	else
	{
		$('#orderType').val("desc");
		var direction=$('#orderType').val();
	}	
	if(isThirdlevel=='1')
	{
		var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>/<?php echo  $this->uri->segment(3)?>/<?php echo  $this->uri->segment(4)?>';
	}
	else
	{
		var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>';
	}
	show_ajax_cardswith_url(base_url,fieldName,direction);
}

//function fun_chagestatus(id,isThirdlevel='')
function fun_chagestatus(id,isThirdlevel)
{
	if(isThirdlevel=='1')
	{
		var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>/<?php echo  $this->uri->segment(3)?>/<?php echo  $this->uri->segment(4)?>';
	}
	else
	{
		var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo $this->uri->segment(2)?>';
	}
	$.ajax({
		url: base_url+'/changestatus',
		data:'id='+id,
		type: 'POST',
		success: function(data) {
			if(data == 1)
			{
				$('#status'+id).html('Active');
				$('#status'+id).addClass('active');
			}
			else
			{
				$('#status'+id).html('Inactive');
				$('#status'+id).removeClass('active');
			}
			
			document.getElementById('alert-success').style.display = 'block';
			$('#successmsg').html('Status Changed Successfully.');
			fun_hide_msg();
		}	
	});
}

/* Function to chnage status for all selected record using AJAX */
function fun_sel_chagestatus(isThirdlevel,statuscode)
{	
	var itemId = [];
	var sitems = document.getElementsByName('itemId[]');
	//var sitems = window.document.listFrm.itemId;
	for (var i=0;i<sitems.length;i++) 
	{
		//alert(sitems[i].checked);
		if (sitems[i].checked)
		{
			itemId.push(sitems[i].value);
		}
	}
	
	//if($(".checkbox1:checked").length == 0) 
	if($( "input:checked" ).length == 0)
	{
		$( "#delete-alert" ).dialog
		({
			height:160,
			resizable:false,
			width: 250,
			modal: true,
			closeText: "hide",
			draggable: false,
			buttons: 
			{
				Ok: function() 
				{
					$( this ).dialog( "close" );
				}
			}
		});
		return false;
	}
	
	$( "#dialog-status" ).dialog
	({
		 height:170,
		 resizable:false,
		 width: 350,
		 modal: true,
		 closeText: "hide",
		 draggable: false,
		 buttons: 
		 {
			"Change": function() 
			{
				if(isThirdlevel!='')
				{
					var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo $this->uri->segment(2)?>/<?php echo $this->uri->segment(3)?>/<?php echo $this->uri->segment(4)?>';
				}
				else
				{
					var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>';
				}
				$.ajax({
					url: base_url+'/changeallstatus',
					data:"itemId="+itemId+"&status="+statuscode,
					type: 'POST',
					success:function(res)
					{
						show_ajax_cardswith_url(base_url);
						document.getElementById('alert-danger').style.display = 'none';
						document.getElementById('alert-success').style.display = 'block';
						$('#successmsg').html(res+' Status Changed Successfully.');
						fun_hide_msg();
					},
					error:function(data) 
					{
						result = false;
						document.getElementById('alert-success').style.display = 'none';
						document.getElementById('alert-danger').style.display = 'block';
						$('#dangermsg').html('Error While Changing Status Data.');
						fun_hide_msg();
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

/* Function to selsect all record */
function selectall()
{	
	if(!$("#selectAll").hasClass('checked'))
	{
		$('.checkbox1').prop('checked', true);
		$('input[type="checkbox"]').addClass('checked');
	}
	else
	{
		$('.checkbox1').prop('checked', false);
		$('input[type="checkbox"]').removeClass('checked');
	}
}

/* Function to delect all selected record using AJAX */
//function deleteall(isThirdlevel='')
function deleteall(isThirdlevel)
{	
	var itemId = [];
	var sitems = document.getElementsByName('itemId[]');
	//var sitems = window.document.listFrm.itemId;
	for (var i=0;i<sitems.length;i++) 
	{
		//alert(sitems[i].checked);
		if (sitems[i].checked)
		{
			itemId.push(sitems[i].value);
		}
	}
	
	//if($(".checkbox1:checked").length == 0) 
	if($( "input:checked" ).length == 0)
	{
		$( "#delete-alert" ).dialog
		({
			height:160,
			resizable:false,
			width: 250,
			modal: true,
			closeText: "hide",
			draggable: false,
			buttons: 
			{
				Ok: function() 
				{
					$( this ).dialog( "close" );
				}
			}
		});
		return false;
	}
	
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
				if(isThirdlevel!='')
				{
					var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo $this->uri->segment(2)?>/<?php echo $this->uri->segment(3)?>/<?php echo $this->uri->segment(4)?>';
					var finalUrl = '<?php echo $this->config->item('admin_url'); ?>/<?php echo $this->uri->segment(2)?>/deleteSelectedreview/';
				}
				else
				{
					var finalUrl = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>'+'/deleteSelected';
					var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>';
				}
								
				$.ajax({
					url:finalUrl,
					data:"itemId="+itemId,
					type:'POST',
					success:function(res)
					{
						show_ajax_cardswith_url(base_url);
						document.getElementById('alert-danger').style.display = 'none';
						document.getElementById('alert-success').style.display = 'block';
						$('#successmsg').html(res+' Deleted Successfully.');
						fun_hide_msg();
					},
					error:function(data) 
					{
						result = false;
						document.getElementById('alert-success').style.display = 'none';
						document.getElementById('alert-danger').style.display = 'block';
						$('#dangermsg').html('Error While Deleting Data.');
						fun_hide_msg();
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

/* Function to delete single record using AJAX */
//function delete_data(id,isThirdlevel='')
function delete_data(id,isThirdlevel)
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
				if(isThirdlevel!='')
				{
					var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo $this->uri->segment(2)?>/<?php echo $this->uri->segment(3)?>/<?php echo $this->uri->segment(4)?>';
					var deleteURL = '<?php echo $this->config->item('admin_url'); ?>/<?php echo $this->uri->segment(2)?>/deletereview/';
				}
				else
				{
					var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>';
					var deleteURL = base_url+"/delete/";
				}
				$.ajax({
					type: 'POST',
					url:deleteURL,
					data:{'id': id},
					success:function(data)
					{
						//alert(data);
						//alert("Yes===>"+data);
						show_ajax_cardswith_url(base_url);
						$('.table_saller tr[data-id='+id+']').remove();
						document.getElementById('alert-danger').style.display = 'none';
						document.getElementById('alert-success').style.display = 'block';
						$('#successmsg').html(data+' Deleted Successfully.');
						fun_hide_msg();
					},
					error:function(data) 
					{
						//alert("No===>"+data);
						result = false;
						document.getElementById('alert-success').style.display = 'none';
						document.getElementById('alert-danger').style.display = 'block';
						$('#dangermsg').html('Error While Deleting Data.');
						fun_hide_msg();
					},
				});
				$( this ).dialog( "close" );		
			},
			Cancel: function() 
			{
				$( this ).dialog( "close" );
			}
	  	}
	});		
}

// function to remove set parameter accordion
function removesetparam(id)
{
	$("#param-"+id).remove();
}

// function to remove textbox for new parameter
function removeParam(id)
{
	$("#addparameter"+id).html('');
	var $example = $("#selParam"+id).select2();
	$example.val("").trigger("change");
	getUnitsByParam(id,'0');
}

// function to add new unit to unit table and its listing
function addnewunit(id)
{
	//var selp = '';
	var selp = '0';
	var selPVal = $("#selParam"+id).val();
	if(selPVal!='' && selPVal!='other')
	{
		selp = selPVal;
	}
	var nunit = $("#newunit"+id).val();
	if(nunit!='')
	{
		/*var finalUrl = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>'+'/addNewUnit';
		$.ajax({
			url:finalUrl,
			data:"selp="+selp+"&nunit="+nunit,
			type:'POST',
			success:function(res)
			{
				if(res>0)
				{
					var uvalue = '<li><label class="unit-item"><input type="checkbox" class="chk" checked="checked" id="unit-'+id+'" value="'+res+'" name="units'+id+'[]">'+nunit+'<span class="check-icon"></span></label></li>';				
					$("#unitlist"+id).append(uvalue);
					$("#newunit"+id).val('');
				}
			},
			error:function(data) 
			{
				
			},
		});*/
		
		$("#nounits"+id).css('display','none');
		var res = selp+'#'+nunit;
		var uvalue = '<li><label class="unit-item"><input type="checkbox" class="chk" checked="checked" id="unit-'+id+'" value="'+res+'" name="units'+id+'[]">'+nunit+'<span class="check-icon"></span></label></li>';				
		$("#unitlist"+id).append(uvalue);
		$("#newunit"+id).val('');
	}
	else
	{
		$("#unit-error"+id).addClass("error");
	}
}

// function to clear the text box to add new unit
function clearnewunit(id)
{
	$("#newunit"+id).val('');
}

// function to show units for selected parameter
function getUnitsByParam(id,pid)
{
    	var finalUrl = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>'+'/getUnitsByParam';
		$.ajax({
			url:finalUrl,
			data:"id="+id+"&pid="+pid,
			type:'POST',
			success:function(res)
			{
                            	if(res && id)
				{
                                        $('.nounits').css('display','none');
					$("#unitlist"+id).html(res);
				}
				else
				{
					$("#unitlist"+id).html('');
					$("#nounits"+id).css('display','block');
				}
			},
			error:function(data) 
			{
				
			},
		});
}

// function to search units for selected parameter
function searchUnit(id)
{
    var name = $("#searchUnit"+id).val();
//    var id = $("#searchUnit").attr('paramId');
    var pid = $("#selParam"+id).val();
     if(pid == '')
         pid = '0';
    var finalUrl = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>'+'/getUnitsSearchData';
		$.ajax({
			url:finalUrl,
			data:"id="+pid+"&name="+name,
			type:'POST',
			success:function(res)
			{
//                            console.log(res);
                            	if(res && id)
				{
                                        $('.nounits').css('display','none');
                                        $("#noresult"+id).css('display','none');
					$("#unitlist"+id).html(res);
				}
				else
				{
					$("#unitlist"+id).html('');
					$("#noresult"+id).css('display','block');
				}
			},
			error:function(data) 
			{
				
			},
		});
}

// function to remove add new parameter error
function removeParamError(id)
{
	$("#new-param-error"+id).removeClass("error");
}

// function to remove add new parameter error
function removeUnitError(id)
{
	$("#unit-error"+id).removeClass("error");
}



// function to select paramter
function selParam(id)
{
	$("#nounits"+id).css('display','none');
	// to add other parameter show textbox to add new param
	var parameterfieldHTML = '<div class="form-group"><div class="addrow removerow"><a href="javascript:void(0);" onclick="removeParam('+id+')"><i class="fa fa-times"></i></a></div><div class="parameter-input"><input type="text" class="form-control" placeholder="Enter parameter" name="new_param'+id+'" id="new_param'+id+'" onkeypress="removeParamError('+id+');"></div><em id="new-param-error'+id+'" class="hide">Please add parameter</em></div>';
	var str = 'other';
	
	var selPVal = $("#selParam"+id).val();
	
	if(selPVal!='') $("#param-error"+id).removeClass('error');
	
	if( selPVal == str){
		$("#addparameter"+id).append(parameterfieldHTML);	
		$("#unitlist"+id).html('');
		$("#nounits"+id).css('display','block');
	}
	else {
		$("#addparameter"+id).html('');
		var selp = '';
		if(selPVal!='' && selPVal!='other')
		{
			selp = selPVal;
			getUnitsByParam(id,selp);
		}
		else
		{
			getUnitsByParam(id,'0');
			$("#nounits"+id).css('display','none');
		}
	}
}

// function to set parameter on done
function setParameterName(id)
{
	var selPV = $("#selParam"+id).val();
	var selP = $("#selParam"+id+" option:selected").text();
	var newP = $("#new_param"+id).val();
	
	if(selPV=='other') selP = newP;	
	
	if(selPV!='' && selP!='')
	{
		var finalP = (selP!='') ? selP : newP;
		$("#pname"+id).text(finalP);
		$('.acrodian-content').hide();
		$("#param-"+id+" .acrodian-title").removeClass('active');
	}
	else
	{
		if(selPV=='other')
			$("#new-param-error"+id).addClass("error");
		else
			$("#param-error"+id).addClass("error");
	}	
}
function clearsearchunit(id)
{
    $('#searchUnit'+id).val('');
    $("#noresult"+id).css('display','none');
     var pid = $("#selParam"+id).val();
     if(pid == '')
         pid = '0';
    getUnitsByParam(id,pid);
}
$(window).load(function(){
	$(".form-scroll").mCustomScrollbar();
	$(".table-content").mCustomScrollbar({
		axis:"x",
	});
});

</script>

</head>
<body>
	<div class="sticky_page">
		<div class="inner-container">
    		<div class="wraper">
            	<div class="header clearfix">
                	<div class="logo fl"><a href="<?php echo $this->config->item('admin_url')."/dashboard"; ?>"><img src="<?php echo base_url(); ?>assets/admin/images/logo.png" alt=""></a></div>	
                	<div class="admin-user fr">
                        <a href="#" class="user-dropmenu">
                            <span class="user-image"><img src="<?php echo base_url(); ?>assets/admin/images/user-image.png" alt=""></span>
                            <strong>Welcome,</strong><?php echo ucfirst($this->session->userdata("username")); ?><span class="drop-icon"><img src="<?php echo base_url(); ?>assets/admin/images/droparrow.png" alt=""></span>
                        </a>
                        <div class="user-popup clearfix">
                          <ul>
                            <li><a href="#<?php //echo $this->config->item('admin_url')."/settings"; ?>"> <i class="fa fa-cog"></i> Setting </a></li>
                            <li><a href="<?php echo $this->config->item('admin_url')."/logout"; ?>"> <i class="fa fa-power-off"></i> logout </a></li>
                          </ul>
                        </div>
                	</div>
            	</div>
                <nav class="nav">
                    <ul class="menu">
                        <li><a href="<?php echo $this->config->item('admin_url')."/dashboard"; ?>" <?php if($this->uri->segment(2) == 'dashboard' || $this->uri->segment(2)==""){echo 'class="active"';}?>>Dashboard</a></li>
                        <li><a href="<?php echo $this->config->item('admin_url')."/category"; ?>" <?php if($this->uri->segment(2) == 'category'){echo 'class="active"';}?>>Workout Categories</a></li>
                        <?php /*?><li><a href="#<?php //echo $this->config->item('admin_url')."/workout"; ?>" <?php if($this->uri->segment(2) == 'workout'){echo 'class="active"';}?>>Workout</a></li><?php */?>
                        <li><a href="<?php echo $this->config->item('admin_url')."/gym"; ?>" <?php if($this->uri->segment(2) == 'gym'){echo 'class="active"';}?>>Gym</a></li>
                        <li><a href="<?php echo $this->config->item('admin_url')."/amenity"; ?>" <?php if($this->uri->segment(2) == 'amenity'){echo 'class="active"';}?>>Amenities</a></li>
                        <li><a href="<?php echo $this->config->item('admin_url')."/movement"; ?>" <?php if($this->uri->segment(2) == 'movement'){echo 'class="active"';}?>>Movements</a></li>
                        <?php /*?><li><a href="#<?php //echo $this->config->item('admin_url')."/video"; ?>" <?php if($this->uri->segment(2) == 'video'){echo 'class="active"';}?>>Videos</a></li>                        
                        <li><a href="#<?php //echo $this->config->item('admin_url')."/package"; ?>" <?php if($this->uri->segment(2) == 'package'){echo 'class="active"';}?>>Packages</a></li><?php */?>
                    </ul>
                </nav>
	