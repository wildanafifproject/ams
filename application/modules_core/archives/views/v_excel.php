<?php  
    header("Cache-Control: no-cache, no-store, must-revalidate");  
    header("Content-Type: application/vnd.ms-excel");  
    header("Content-Disposition: attachment; filename=archives.xls");  
?> 
<table width="100%" border="1">
    <tr>
        <th height="50" width="50" align="center" bgcolor="#eff3f8">No</th>
		<th width="100" align="center" bgcolor="#eff3f8">Case number</th>
		<th width="150" align="center" bgcolor="#eff3f8">Patient name</th>
        <th width="250" align="center" bgcolor="#eff3f8">From</th>
		<th width="250" align="center" bgcolor="#eff3f8">To</th>
		<th width="250" align="center" bgcolor="#eff3f8">Area</th>
		<th width="100" align="center" bgcolor="#eff3f8">Ambulance</th>
		<th width="200" align="center" bgcolor="#eff3f8">Time of call</th>
		<th width="200" align="center" bgcolor="#eff3f8">Time response</th>
		<th width="200" align="center" bgcolor="#eff3f8">Time crew notified</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins to collect data</th>
		<th width="225" align="center" bgcolor="#eff3f8">Time departure from hospitals</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins to leave from time of notification</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins to leave from time of call</th>
		<th width="200" align="center" bgcolor="#eff3f8">Time call patient</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins to call patient from time of call</th>
		<th width="200" align="center" bgcolor="#eff3f8">Time of arrival at location</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins to arrive at call location</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins to arrive at location from time of call</th>
		<th width="225" align="center" bgcolor="#eff3f8">Time of departure from location</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins spent at location</th>
		<th width="200" align="center" bgcolor="#eff3f8">Time of arrival at hospitals</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins to arrive at hospitals</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins spent for trip at hospitals</th>
		<th width="300" align="center" bgcolor="#eff3f8">Total time from time of call to arrival at hospital</th>
		<th width="200" align="center" bgcolor="#eff3f8">Time of arrival back to hospitals</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins to arrive back to hospitals</th>
		<th width="225" align="center" bgcolor="#eff3f8">Mins spent for back to hospitals</th>
		<th width="300" align="center" bgcolor="#eff3f8">Total time from time of call to arrival back to hospital</th>
		<th width="200" align="center" bgcolor="#eff3f8">Time cancel</th>
		<th width="400" align="center" bgcolor="#eff3f8">Notes</th>
		<th width="400" align="center" bgcolor="#eff3f8">Cancelation Reason</th>
		<th width="100" align="center" bgcolor="#eff3f8">Status</th>
		<th width="150" align="center" bgcolor="#eff3f8">Login By</th>
    </tr>
	<?php
		$avg_time_response 									= "00:00:00";
		$avg_min_collect_data 								= "00:00:00";
		$avg_min_leave_from_time_notification 				= "00:00:00";
		$avg_min_leave_from_original_call 					= "00:00:00";
		$avg_min_call_patient_from_original_call 			= "00:00:00";
		$avg_min_arrived_patient 							= "00:00:00";
		$avg_min_arrived_patient_from_original_call 		= "00:00:00";
		$avg_min_spent_patient 								= "00:00:00";
		$avg_min_arrived_hospital 							= "00:00:00";
		$avg_min_spent_trip 								= "00:00:00";
		$avg_min_arrived_hospital_from_original_call 		= "00:00:00";
		$avg_min_spent_hospital 							= "00:00:00";
		$avg_min_arrived_back_hospital 						= "00:00:00";
		$avg_min_arrived_back_hospital_from_original_call 	= "00:00:00";
	
		$int_time_response 									= 0;
		$int_min_collect_data 								= 0;
		$int_min_leave_from_time_notification 				= 0;
		$int_min_leave_from_original_call 					= 0;
		$int_min_call_patient_from_original_call 			= 0;
		$int_min_arrived_patient 							= 0;
		$int_min_arrived_patient_from_original_call 		= 0;
		$int_min_spent_patient 								= 0;
		$int_min_arrived_hospital 							= 0;
		$int_min_spent_trip 								= 0;
		$int_min_arrived_hospital_from_original_call 		= 0;
		$int_min_spent_hospital 							= 0;
		$int_min_arrived_back_hospital 						= 0;
		$int_min_arrived_back_hospital_from_original_call 	= 0;
		
		$total_time_response 								= "00:00:00";
		$total_min_collect_data 							= "00:00:00";
		$total_min_leave_from_time_notification 			= "00:00:00";
		$total_min_leave_from_original_call 				= "00:00:00";
		$total_min_call_patient_from_original_call 			= "00:00:00";
		$total_min_arrived_patient 							= "00:00:00";
		$total_min_arrived_patient_from_original_call 		= "00:00:00";
		$total_min_spent_patient 							= "00:00:00";
		$total_min_arrived_hospital 						= "00:00:00";
		$total_min_spent_trip 								= "00:00:00";
		$total_min_arrived_hospital_from_original_call 		= "00:00:00";
		$total_min_spent_hospital 							= "00:00:00";
		$total_min_arrived_back_hospital 					= "00:00:00";
		$total_min_arrived_back_hospital_from_original_call = "00:00:00";
	?>
    <?php $number=0; if(count($list) != 0) { ?>
    <?php for($i=0; $i<count($list); $i++) {  ?>
		<tr>
			<td height="20" align="center"><?php echo ++$number; ?></td>
			<td align="center"><?php echo $list[$i]['code']; ?></td>
			<td align="center"><?php echo $list[$i]['patient']; ?></td>
			<td><?php echo $list[$i]['from']; ?></td>
			<td><?php echo $list[$i]['to']; ?></td>
			<td align="center"><?php echo $list[$i]['area']; ?></td>
			<td align="center"><?php echo $list[$i]['ambulance']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_booked']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['time_response']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_set_crew']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_collect_data']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_to_patient']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_leave_from_time_notification']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_leave_from_original_call']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_call_patient']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_call_patient_from_original_call']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_arrived_patient']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_arrived_patient']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_arrived_patient_from_original_call']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_to_hospital']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_spent_patient']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_arrived_hospital']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_arrived_hospital']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_spent_trip']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_arrived_hospital_from_original_call']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_complete']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_spent_hospital']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_arrived_back_hospital']; ?></td>
			<td align="center" bgcolor="#1E90FF"><?php echo $list[$i]['min_arrived_back_hospital_from_original_call']; ?></td>
			<td align="center" bgcolor="#FFFACD"><?php echo $list[$i]['time_cancel']; ?></td>
			<td><?php echo $list[$i]['note']; ?></td>
			<td><?php echo $list[$i]['reason']; ?></td>
			<td align="center"><?php echo $list[$i]['status']; ?></td>
			<td align="center"><?php echo $list[$i]['by']; ?></td>
		</tr>
		<?php
			$int_time_response 									= $int_time_response + minute_to_int($list[$i]['time_response']);
			$int_min_collect_data 								= $int_min_collect_data + minute_to_int($list[$i]['min_collect_data']);
			$int_min_leave_from_time_notification 				= $int_min_leave_from_time_notification + minute_to_int($list[$i]['min_leave_from_time_notification']);
			$int_min_leave_from_original_call 					= $int_min_leave_from_original_call + minute_to_int($list[$i]['min_leave_from_original_call']);
			$int_min_call_patient_from_original_call 			= $int_min_call_patient_from_original_call + minute_to_int($list[$i]['min_call_patient_from_original_call']);
			$int_min_arrived_patient 							= $int_min_arrived_patient + minute_to_int($list[$i]['min_arrived_patient']);
			$int_min_arrived_patient_from_original_call 		= $int_min_arrived_patient_from_original_call + minute_to_int($list[$i]['min_arrived_patient_from_original_call']);
			$int_min_spent_patient 								= $int_min_spent_patient + minute_to_int($list[$i]['min_spent_patient']);
			$int_min_arrived_hospital 							= $int_min_arrived_hospital + minute_to_int($list[$i]['min_arrived_hospital']);
			$int_min_spent_trip 								= $int_min_spent_trip + minute_to_int($list[$i]['min_spent_trip']);
			$int_min_arrived_hospital_from_original_call 		= $int_min_arrived_hospital_from_original_call + minute_to_int($list[$i]['min_arrived_hospital_from_original_call']);
			$int_min_spent_hospital 							= $int_min_spent_hospital + minute_to_int($list[$i]['min_spent_hospital']);
			$int_min_arrived_back_hospital 						= $int_min_arrived_back_hospital + minute_to_int($list[$i]['min_arrived_back_hospital']);
			$int_min_arrived_back_hospital_from_original_call 	= $int_min_arrived_back_hospital_from_original_call + minute_to_int($list[$i]['min_arrived_back_hospital_from_original_call']);
			
			$total_time_response								= sum_the_time($total_time_response, $list[$i]['time_response']);
			$total_min_collect_data 							= sum_the_time($total_min_collect_data, $list[$i]['min_collect_data']);
			$total_min_leave_from_time_notification 			= sum_the_time($total_min_leave_from_time_notification, $list[$i]['min_leave_from_time_notification']);
			$total_min_leave_from_original_call 				= sum_the_time($total_min_leave_from_original_call, $list[$i]['min_leave_from_original_call']);
			$total_min_call_patient_from_original_call 			= sum_the_time($total_min_call_patient_from_original_call, $list[$i]['min_call_patient_from_original_call']);
			$total_min_arrived_patient 							= sum_the_time($total_min_arrived_patient, $list[$i]['min_arrived_patient']);
			$total_min_arrived_patient_from_original_call 		= sum_the_time($total_min_arrived_patient_from_original_call, $list[$i]['min_arrived_patient_from_original_call']);
			$total_min_spent_patient 							= sum_the_time($total_min_spent_patient, $list[$i]['min_spent_patient']);
			$total_min_arrived_hospital 						= sum_the_time($total_min_arrived_hospital, $list[$i]['min_arrived_hospital']);
			$total_min_spent_trip 								= sum_the_time($total_min_spent_trip, $list[$i]['min_spent_trip']);
			$total_min_arrived_hospital_from_original_call 		= sum_the_time($total_min_arrived_hospital_from_original_call, $list[$i]['min_arrived_hospital_from_original_call']);
			$total_min_spent_hospital 							= sum_the_time($total_min_spent_hospital, $list[$i]['min_spent_hospital']);
			$total_min_arrived_back_hospital 					= sum_the_time($total_min_arrived_back_hospital, $list[$i]['min_arrived_back_hospital']);
			$total_min_arrived_back_hospital_from_original_call = sum_the_time($total_min_arrived_back_hospital_from_original_call, $list[$i]['min_arrived_back_hospital_from_original_call']);
		?>	
    <?php } ?>
    <?php } else { echo "<tr><td colspan='31' align='center'>Data Not Found</td></tr>"; }?>  
	
	<?php
		if(count($list) > 0) { $pembagi = count($list); } else { $pembagi = 1; } 
		
		$avg_time_response 									= second_to_time(($int_time_response / $pembagi));
		$avg_min_collect_data 								= second_to_time(($int_min_collect_data / $pembagi));
		$avg_min_leave_from_time_notification 				= second_to_time(($int_min_leave_from_time_notification / $pembagi));
		$avg_min_leave_from_original_call 					= second_to_time(($int_min_leave_from_original_call / $pembagi));
		$avg_min_call_patient_from_original_call 			= second_to_time(($int_min_call_patient_from_original_call / $pembagi));
		$avg_min_arrived_patient 							= second_to_time(($int_min_arrived_patient / $pembagi));
		$avg_min_arrived_patient_from_original_call 		= second_to_time(($int_min_spent_patient / $pembagi));
		$avg_min_spent_patient 								= second_to_time(($int_min_spent_patient / $pembagi));
		$avg_min_arrived_hospital 							= second_to_time(($int_min_arrived_hospital / $pembagi));
		$avg_min_spent_trip 								= second_to_time(($int_min_spent_trip / $pembagi));
		$avg_min_arrived_hospital_from_original_call 		= second_to_time(($int_min_arrived_hospital_from_original_call / $pembagi));
		$avg_min_spent_hospital 							= second_to_time(($int_min_spent_hospital / $pembagi));
		$avg_min_arrived_back_hospital 						= second_to_time(($int_min_arrived_back_hospital / $pembagi));
		$avg_min_arrived_back_hospital_from_original_call 	= second_to_time(($int_min_arrived_back_hospital_from_original_call / $pembagi));
	?>
	
	<tr>
		<td height="20" align="center" colspan="7">AVERAGE TIME</td>
		<td></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_time_response; ?></td>
		<td></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_collect_data; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_leave_from_time_notification; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_leave_from_original_call; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_call_patient_from_original_call; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_arrived_patient; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_arrived_patient_from_original_call; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_spent_patient; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_arrived_hospital; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_spent_trip; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_arrived_hospital_from_original_call; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_spent_hospital; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_arrived_back_hospital; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $avg_min_arrived_back_hospital_from_original_call; ?></td>
		<td colspan="5"></td>
	</tr>
	<tr>
		<td height="20" align="center" colspan="7">TOTAL TIME</td>
		<td></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_time_response; ?></td>
		<td></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_collect_data; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_leave_from_time_notification; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_leave_from_original_call; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_call_patient_from_original_call; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_arrived_patient; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_arrived_patient_from_original_call; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_spent_patient; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_arrived_hospital; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_spent_trip; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_arrived_hospital_from_original_call; ?></td>
		<td align="center"></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_spent_hospital; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_arrived_back_hospital; ?></td>
		<td align="center" bgcolor="#1E90FF"><?php echo $total_min_arrived_back_hospital_from_original_call; ?></td>
		<td colspan="5"></td>
	</tr>	
</table>