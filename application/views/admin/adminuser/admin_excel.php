<?php
$filename = "adminuser_".date("Y_m_d_H_i_s").".xls";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>Name</td>
		<td>Email</td>
		<td>Password</td>
		<td>Active</td>
	</tr>
	<?php
	foreach($export as $row) 
	{
	?>
	<tr>
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $row['email']; ?></td>
        <td><?php echo base64_decode($row['password']); ?></td>
		<td><?php if($row['isActive'] == 1){ ?> Active <?php }else{ ?> InActive <?php } ?> </td>
	</tr>
	<?php } ?>
</table>