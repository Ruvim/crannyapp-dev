<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cranny Application - Admin Panel</title>
<link href="<?php echo base_url(); ?>assets/admin/css/dataportal.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.filer.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.filer.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js" type="text/javascript"></script>

<script type="text/javascript">
// go to list page
function backtolist()
{
	window.location.href = "<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>";	
}

/* Function for pagination using AJAX to maintain serch area AND pagesize*/
function show_ajax_cardswith_url(baseurl,fieldname,direction)
{	
	var search_string = $('#search_string').val();
	//var orderType = $('#orderType').val();
	//var fieldName = $('#fieldName').val();
	//var srchisActive = $('#srchisActive').val();
	
	//var startdate = $('#startdate').val();
	//var enddate = $('#enddate').val();
	
	$.ajax({
		url:baseurl,
		//data:"baseurl="+baseurl+"&search_string="+search_string+"&orderType="+orderType+"&fieldName="+fieldName+"&srchisActive="+srchisActive+"&startdate="+startdate+"&enddate="+enddate,
		data:"baseurl="+baseurl+"&search_string="+search_string,
		type:'POST',
		success:function(res)
		{		 
			$('#table_listing').html($(res).find('#table_listing').html());			
		},
		error:function(res) 
		{
			result = false;			
		}
	});	
} 

function delete_data(id)
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
				var base_url = '<?php echo $this->config->item('admin_url'); ?>/<?php echo  $this->uri->segment(2)?>';
				var deleteURL = base_url+"/delete/";
				
				$.ajax({
					type: 'POST',
					url:deleteURL,
					data:{'id': id},
					success:function(data)
					{
						show_ajax_cardswith_url(base_url);
						$('tr[data-id='+id+']').remove();
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

</script>

</head>

<body>
	<header>
		<a href="<?php echo $this->config->item('admin_url')."/dashboard"; ?>"><img src="<?php echo base_url(); ?>assets/admin/images/anilabsinc_hdr_logo.png" title="anilabsinc" /></a>
	</header>
    <nav class="nav">
		<ul class="menu">
			<li><a href="<?php echo $this->config->item('admin_url')."/dashboard"; ?>" <?php if($this->uri->segment(2) == 'dashboard' || $this->uri->segment(2)==""){echo 'class="active"';}?>>Dashboard</a></li>
			<li><a href="<?php echo $this->config->item('admin_url')."/adminuser"; ?>" <?php if($this->uri->segment(2) == 'adminuser'){echo 'class="active"';}?>>Admin Users</a></li>
			<li><a href="<?php echo $this->config->item('admin_url')."/image"; ?>" <?php if($this->uri->segment(2) == 'image'){echo 'class="active"';}?>>Images</a></li>
			<li><a href="#<?php //echo $this->config->item('admin_url')."/settings"; ?>" <?php if($this->uri->segment(2) == 'settings'){echo 'class="active"';}?>>Settings</a></li>
		</ul>
	</nav>
	