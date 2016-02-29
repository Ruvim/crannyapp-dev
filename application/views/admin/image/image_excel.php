<?php
$filename = "gym_".date("Y_m_d_H_i_s").".xls";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>Gym Name</td>
        <td>Ratings</td>
        <td>City</td>
        <td>State</td>
        <td>Contact Number</td>
		<td>Status</td>
	</tr>
	<?php
	foreach($export as $row) 
	{
	?>
	<tr>
		<td><?php echo $row['gym_name']; ?></td>
        <td><?php echo $row['overall_ratings']; ?></td>
        <td><?php echo $row['city']; ?></td>
        <td><?php echo $row['state_name']; ?></td>
        <td><?php echo $row['contact_number']; ?></td>
		<td><?php if($row['isActive'] == 1){ ?> Active <?php }else{ ?> InActive <?php } ?> </td>
	</tr>
	<?php } ?>
</table>