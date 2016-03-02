	<section>
		<div class="content-wrapper">
  			<h1>Admin Users</h1>
   			<form name="frm_search" id="frm_search" action="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>" method="post">	
				<div class="search-wrapper"><label>Search</label><span class="icon-search4"></span>				
					<input type="text" class="" value="" id="search_string" name="search_string" />
				</div>
			</form>
			<h3><a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2).'/add'; ?>">Add Admin User</a></h3>
   			<p>&nbsp;</p>
			<table cellpadding="0" cellspacing="0" border="0" id="table_listing">
				<tr>
					<th valign="top">User Name</th>
					<th valign="top">Email</th>
					<th valign="top">Role</th>
					<th valign="top">Status</th>
					<th valign="top"></th>
				</tr>				
				<?php
					if(count($adminuser) > 0)
					{	
						foreach($adminuser as $row)
						{
						$user_role = ($row['user_role']=='1') ? 'Admin' : 'Subscriber';
						$isActive = ($row['isActive']=='1') ? 'Active' : 'inActive';
				?>
				<tr data-id="<?php echo $row['adminuser_id']; ?>">
					<td valign="top"><?php echo $row['user_name']; ?></td>
					<td valign="top"><?php echo $row['email']; ?></td>
					<td valign="top"><?php echo $user_role; ?></td>
					<td valign="top"><?php echo $isActive; ?></td>
					<td valign="top" class="action">
						<a href="<?php echo $this->config->item('admin_url').'/adminuser/update/'.$row['adminuser_id']; ?>" title="Edit"><span class="icon-pencil124"></span></a> 
						<a href="#" onclick="delete_data('<?php echo $row['adminuser_id']; ?>')" title="Delete"><span class="icon-cross"></span></a>
					</td>
				</tr>
				<?php
					}
				}
				else
				{
				?>
					<tr>
						<td colspan="5" align="center">No records found</td>
					</tr>				
                <?php
				}
				?>
    		</table>			
  			<div class="clear-b"></div>
			<div></div>    
		</div>
	</section>