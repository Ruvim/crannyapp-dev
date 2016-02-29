<div class="container">   
    <div style="clear:both">
		<div role="alert" class="alert alert-success" id="alert-success" style="display:none; ">
			<i class="fa fa-check"></i>
			<div id="successmsg"></div>
            <div class="close">X</div>
		</div>
		<div role="alert" class="alert alert-danger" id="alert-danger" style="display:none; ">
			<i class="fa fa-exclamation-triangle"></i>
			<div id="dangermsg"></div>
            <div class="close">X</div>
		</div>
	</div>  	
	<!-- Breadcrumb -->
    <div class="search-box">
    	<form name="frm_search" id="frm_search" action="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>" method="post">
			<div class="relative-serch">
            <input type="text" class="search-icon" placeholder="Search" value="" id="search_string" name="search_string">
			<!--=============================common sorting fields======================== -->
			<input type="hidden"   value="id" id="fieldName" name="fieldName">
			<input type="hidden"   value="desc" id="orderType" name="orderType">
			<!--=============================common sorting fields======================== -->
           	<button type="reset" class="o-cancle" id="my-closre" onclick="fun_clear_singlesearch();" name="myclose">
            <i class="fa fa-times"></i></button>
            </div>
            <button type="submit" class="o-button" id="mysearch" name="mysearch">
            <i class="fa fa-search"></i></button>
        </form>
	</div>
    <!-- Breadcrumb -->
    <h2 class="page-title">Adminuser </h2>
	<div class="filter">
      <label class="sr-publabel">Filter</label>
      <div class="sr-publish">
      <select name="srchisActive" id="srchisActive" onChange="fun_changestatus(this.value)">
        <option value="">---SELECT---</option>
        <option value="1">Published</option>
        <option value="0">Unpublished</option>
      </select>
      <input type="hidden" value="" id="myclear" name="myclear">
      <input type="hidden" value="" id="srchcompany_string" name="srchcompany_string">
      </div>
      <div class="list-button">
        <a class="dark-blue-button" href="javascript:void(0);" onclick="fun_clear();"><i class="fa fa-remove"></i>Reset</a>
      </div>
    </div>
	
    <div id="record-list">        
    <div class="pagination-block top">     
		<div class="list-button">
        	<a class="dark-blue-button" href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>/add"><i class="fa fa-plus"></i>Add Admin User</a>
        	<a class="dark-blue-button" onclick="deleteall();"><i class="fa fa-remove"></i>Delete Selected</a>
			<a class="dark-blue-button" href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>/exportToexcel"><i class="fa fa-file-excel-o"></i>Export To Excel</a>
        </div>
        <nav class="pull-right">
	        <?php echo $this->pagination->create_links_ajax();?>
		</nav>
        <div class="record-box">
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
					$limit = $this->adminuserModel->get_pagesize('adminuser'); // new added by chirag
				}
			?>
			<label>Total Records :<?php echo $count_adminuser;?></label>
            <label>Records Per Page</label>
            <select name="pagesize" class="pagesize" onchange="changepagesize(this.value);">
                <option <?php if($limit == 20){?> selected <?php } ?>>20</option>
                <option <?php if($limit == 40){?> selected <?php } ?>>40</option>
                <option <?php if($limit == 60){?> selected <?php } ?>>60</option>
                <option <?php if($limit == 80){?> selected <?php } ?>>80</option>
                <option  value="0" <?php if($limit == 0){?> selected <?php } ?>>All</option>
            </select>    
        </div>
	</div>
    <section id="dataListing">        
		<!-- row of columns -->
      	<div class="table-responsive">
			<table class="table">
				<thead>
                	<tr>
                        <th width="50"><input type="checkbox" id="selectAll"  name="selecctall" value="" onClick="selectall()"></th>
						<th width="30%">
                           <a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('name')">Name</a>
                            
                            <div id="name_sorting" class="arrow_sorting">
                                <a  class="sortcolumn" ><span data-toggle="tooltip" data-placement="top"><i class="fa fa-sort-asc"></i></span></a>
                                <a class="sortcolumn" ><span data-toggle="tooltip" data-placement="top"><i class="fa fa-sort-desc"></i></span></a>
                            </div>
                            <div id="name" class="arrow_sorting"></div>
						</th>
						<th>
                            <a href="javascript:void(0);" data-id="1" onclick="changeOrderType('email')">Email</a>
							 <div id="email_sorting" class="arrow_sorting">
                                <a  class="sortcolumn" ><span data-toggle="tooltip" data-placement="top"><i class="fa fa-sort-asc"></i></span></a>
                                <a class="sortcolumn" ><span data-toggle="tooltip" data-placement="top"><i class="fa fa-sort-desc"></i></span></a>
                            </div>
                            <div id="email" class="arrow_sorting"></div>
						</th>
						<th>Password</th>
						<th width="10%">
                            <a href="javascript:void(0);" data-id="1"  onclick="changeOrderType('isActive')">Published</a>
                             <div id="isActive_sorting" class="arrow_sorting">
                                <a  class="sortcolumn" ><span data-toggle="tooltip" data-placement="top"><i class="fa fa-sort-asc"></i></span></a>
                                <a class="sortcolumn" ><span data-toggle="tooltip" data-placement="top"><i class="fa fa-sort-desc"></i></span></a>
                            </div>
                            <div id="isActive" class="arrow_sorting"></div>
							<!--
							<a href="#" class="deleteListItem" data-id="1" onclick="check_publish('0','isActive')"><span data-toggle="tooltip" data-placement="top" title="Unpublished"><i class="fa fa-sort-asc"></i></span></a>
							<a href="#" class="deleteListItem" data-id="2" onclick="check_publish('1','isActive')"><span data-toggle="tooltip" data-placement="top" title="Published"><i class="fa fa-sort-desc"></i></span></a>
							-->
						</th>
						<th style="text-align:center;" width="150">Actions</th>
                  	</tr>
                </thead>                
                <tbody>
                <?php
                if(count($adminuser) > 0)
		   		{	
              		foreach($adminuser as $row)
              		{
					$published = ($row['isActive'] == '1') ? '<span class="published" id="status'.$row['id'].'" onClick="fun_chagestatus('.$row['id'].');">Published</span>' : '<span class="unpublished" id="status'.$row['id'].'" onClick="fun_chagestatus('.$row['id'].');">Unpublished</span>';
                    ?>
					<tr>
                       <th scope="row" data-id="<?php $row['id']; ?>"><input type="checkbox" class="checkbox1" name="itemId[]" value="<?php echo $row['id']; ?>" /></th>
                       	<td>
							<?php echo $row['email'];?>
						</td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo base64_decode($row['password']); ?></td>
						<td><?php echo $published; ?></td>
                        <td>
							<div class="action-tab">
                        		<a href="<?php echo $this->config->item('admin_url').'/adminuser/update/'.$row['id']; ?>" class="editListItem"><span data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></span></a>
                        		<a href="javascript:void(0);" class="deleteListItem" data-id="<?php echo $row['id']; ?>" onclick="delete_data('<?php echo $row['id']; ?>')"><span data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></span></a>
                        	</div>
						</td>            
                  	</tr>
					<?php               
			  		}
				}
				else
				{
				?>
					<tr>
						<td colspan="4" align="center">No records found</td>
					</tr>				
                <?php
				}
				?>  
                </tbody>
      		</table>
    	</div> 
        <div class="pagination-block">      
            <nav class="pull-right">
				<?php echo $this->pagination->create_links_ajax();?>
    		</nav>
            <div class="record-box">
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
					$limit = $this->adminuserModel->get_pagesize('adminuser'); // new added by chirag
				}
			?>
			<label>Total Records :<?php echo $count_adminuser;?></label>
            <label>Records Per Page</label>
            <select name="pagesize" class="pagesize" onchange="changepagesize(this.value);">
                <option <?php if($limit == 20){?> selected <?php } ?>>20</option>
                <option <?php if($limit == 40){?> selected <?php } ?>>40</option>
                <option <?php if($limit == 60){?> selected <?php } ?>>60</option>
                <option <?php if($limit == 80){?> selected <?php } ?>>80</option>
                
                <option  value="0" <?php if($limit == 0){?> selected <?php } ?>>All</option>
            </select>    
        </div>
            <div class="list-button">
            	<a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>/add" class="dark-blue-button"><i class="fa fa-plus"></i>Add Adminuser</a>
            	<a onclick="deleteall();" class="dark-blue-button"><i class="fa fa-remove"></i>Delete Selected</a>
                <a class="dark-blue-button" href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>/exportToexcel"><i class="fa fa-file-excel-o"></i>Export To Excel</a>
            </div>
        </div>                
	</section>
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
</script>