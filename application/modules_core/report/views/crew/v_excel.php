<?php  
    header("Cache-Control: no-cache, no-store, must-revalidate");  
    header("Content-Type: application/vnd.ms-excel");  
    header("Content-Disposition: attachment; filename=crew.xls");  
?> 
<table width="100%" border="1">
    <tr>
        <th height="50" width="50" align="center" bgcolor="#eff3f8">No</th>
		<th width="100" align="center" bgcolor="#eff3f8">Case number</th>
		<th width="200" align="center" bgcolor="#eff3f8">Hospital</th>
		<th width="100" align="center" bgcolor="#eff3f8">Ambulance</th>
		<th width="75" align="center" bgcolor="#eff3f8">Type</th>
		<th width="150" align="center" bgcolor="#eff3f8">Name</th>
    </tr>
    <?php $number=0; if(count($list) != 0) { ?>
    <?php for($i=0; $i<count($list); $i++) {  ?>
		<tr>
			<td height="20" align="center"><?php echo ++$number; ?></td>
			<td align="center"><?php echo $list[$i]['code']; ?></td>
			<td align="center"><?php echo $list[$i]['hospi']; ?></td>
			<td align="center"><?php echo $list[$i]['ambulance']; ?></td>
			<td align="center"><?php echo $list[$i]['crew']; ?></td>
			<td align="center"><?php echo $list[$i]['name']; ?></td>
		</tr>
    <?php } ?>
    <?php } else { echo "<tr><td colspan='6' align='center'>Data Not Found</td></tr>"; }?>  
</table>