	<section>
		<div class="content-wrapper">
  			<h1>Images</h1>
   			<form name="frm_search" id="frm_search" action="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2); ?>" method="post">	
				<div class="search-wrapper"><label>Search</label><span class="icon-search4"></span>				
					<input type="text" class="" value="" id="search_string" name="search_string" />
				</div>
			</form>
			<h3><a href="<?php echo $this->config->item('admin_url').'/'.$this->uri->segment(2).'/add'; ?>">Add Images</a></h3>
   			<p>&nbsp;</p>
			<table cellpadding="0" cellspacing="0" border="0" id="table_listing">
				<tr>
					<th valign="top">Image Name</th>
					<th valign="top">Image</th>
					<th valign="top">Added By</th>
					<th valign="top">Status</th>
					<th valign="top"></th>
				</tr>				
				<?php
					if(count($image) > 0)
					{	
						foreach($image as $row)
						{
							$imagename = ($row['imagename']!='') ? $this->config->item('base_url').'/assets/uploads/pictures/resized/'.$row['imagename'] : '';
							$isActive = ($row['isActive']=='1') ? 'Active' : 'inActive';
				?>
				<tr data-id="<?php echo $row['image_id']; ?>">
					<td valign="top"><?php echo $row['image_title']; ?></td>
					<td valign="top"><img src="<?php echo $imagename; ?>" height="100" width="100" /></td>
					<td valign="top"><?php echo $row['user_name']; ?></td>
					<td valign="top"><?php echo $isActive; ?></td>
					<td valign="top" class="action">
						<a href="<?php echo $this->config->item('admin_url').'/image/update/'.$row['image_id']; ?>" title="Edit"><span class="icon-pencil124"></span></a> 
						<a href="#" onclick="delete_data('<?php echo $row['image_id']; ?>')" title="Delete"><span class="icon-cross"></span></a>
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