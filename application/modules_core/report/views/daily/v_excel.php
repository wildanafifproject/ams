<?php  
    header("Cache-Control: no-cache, no-store, must-revalidate");  
    header("Content-Type: application/vnd.ms-excel");  
    header("Content-Disposition: attachment; filename=Daily Report($from - $to).xls");  
?> 
<h3>DAILY REPORT AMS - SOS 1HEALTH</h3>
<P>Date: <?=$from?> - <?=$from?></P>
<table  border="1">
    <tr>
        <th height="10" width="auto" align="center" rowspan="3" bgcolor="#eff3f8">No</th>
        <th height="50" width="auto" align="center" rowspan="3" bgcolor="#eff3f8">Unit Siloam</th>
		<th width="auto" align="center" bgcolor="#eff3f8" colspan="7">Emergency</th>
		<th width="auto" align="center" bgcolor="#eff3f8" colspan="7">Non Emergency</th>
		 <th height="50" width="auto" align="center" rowspan="3" bgcolor="#eff3f8">Notes</th>
        
    </tr>
    <tr>
    	<th width="auto" align="center" bgcolor="#eff3f8" colspan="3">Order By 1500-911</th>
		<th width="auto" align="center" bgcolor="#eff3f8" colspan="3">Order By Hospital</th>

		<th width="auto" align="center" bgcolor="#eff3f8" colspan="1" rowspan="2">Complete Order (%)</th>

		<th width="auto" align="center" bgcolor="#eff3f8" colspan="3">Order By 1500-911</th>
		<th width="auto" align="center" bgcolor="#eff3f8" colspan="3">Order By Hospital</th>
		<th width="auto" align="center" bgcolor="#eff3f8" colspan="1" rowspan="2">Complete Order (%)</th>
    </tr>
    <tr>
    	<th width="auto" align="center" bgcolor="#eff3f8">Order <br>Create</th>
		<th width="auto" align="center" bgcolor="#eff3f8" >Order <br> Cancel</th>
		<th width="auto" align="center" bgcolor="#eff3f8" >Canceled <br>By</th>

		<th width="auto" align="center" bgcolor="#eff3f8">Order <br>Create</th>
		<th width="auto" align="center" bgcolor="#eff3f8" >Order <br>Cancel</th>
		<th width="auto" align="center" bgcolor="#eff3f8" >Canceled <br>By</th>

		<th width="auto" align="center" bgcolor="#eff3f8">Order <br>Create</th>
		<th width="auto" align="center" bgcolor="#eff3f8" >Order <br>Cancel</th>
		<th width="auto" align="center" bgcolor="#eff3f8" >Canceled <br>By</th>

		<th width="auto" align="center" bgcolor="#eff3f8">Order <br>Create</th>
		<th width="auto" align="center" bgcolor="#eff3f8" >Order<br> Cancel</th>
		<th width="auto" align="center" bgcolor="#eff3f8" >Canceled <br>By</th>
    </tr>
    <?php 
    	$total_emergency_order_create_by_1=0;
    	$total_emergency_order_cancel_by_1=0;

    	$total_emergency_order_create_by_4=0;
    	$total_emergency_order_cancel_by_4=0;

    	$total_nonemergency_order_create_by_1=0;
    	$total_nonemergency_order_cancel_by_1=0;

    	$total_nonemergency_order_create_by_4=0;
    	$total_nonemergency_order_cancel_by_4=0;

    ?>
    <?php foreach ($data as $key => $value) { 

    	$total_emergency_order_create_by_1=$total_emergency_order_create_by_1+$value['emergency_order_create_by_1'];
    	$total_emergency_order_cancel_by_1=$total_emergency_order_cancel_by_1+$value['emergency_order_cancel_by_1'];

    	$total_emergency_order_create_by_4=$total_emergency_order_create_by_4+$value['emergency_order_create_by_4'];
    	$total_emergency_order_cancel_by_4=$total_emergency_order_cancel_by_4+$value['emergency_order_cancel_by_4'];

    	$total_nonemergency_order_create_by_1=$total_nonemergency_order_create_by_1+$value['nonemergency_order_create_by_1'];
    	$total_nonemergency_order_cancel_by_1=$total_nonemergency_order_cancel_by_1+$value['nonemergency_order_cancel_by_1'];

    	$total_nonemergency_order_create_by_4=$total_nonemergency_order_create_by_4+$value['nonemergency_order_create_by_4'];
    	$total_nonemergency_order_cancel_by_4=$total_nonemergency_order_cancel_by_4+$value['nonemergency_order_cancel_by_4'];


    	?>
    	<tr>
    		<td><?=$key+1?></td>
    		<td ><?=$value['unit']?></td>
    		<td  style="text-align: center;" ><?=$value['emergency_order_create_by_1']?></td>
    		<td  style="text-align: center;" ><?=$value['emergency_order_cancel_by_1']?></td>
    		<td  style="text-align: center;" ><?=$value['emergency_order_cancelation_by_1']?></td>

    		<td  style="text-align: center;" ><?=$value['emergency_order_create_by_4']?></td>
    		<td  style="text-align: center;" ><?=$value['emergency_order_cancel_by_4']?></td>
    		<td  style="text-align: center;" ><?=$value['emergency_order_cancelation_by_4']?></td>
    		<td style="text-align: center;">
<?php 
            $prosentase = 0;
            $div = ($value['emergency_order_cancel_by_1']+$value['emergency_order_cancel_by_4']+$value['emergency_order_create_by_1']+$value['emergency_order_create_by_4']);
            if($div>0){
                $prosentase = (($value['emergency_order_create_by_1']+$value['emergency_order_create_by_4'])
                / ($div))
                * 100;
            }

                echo round($prosentase)."%";

?>      
            </td>


    		<td style="text-align: center;" ><?=$value['nonemergency_order_create_by_1']?></td>
    		<td style="text-align: center;" ><?=$value['nonemergency_order_cancel_by_1']?></td>
    		<td style="text-align: center;" ><?=$value['nonemergency_order_cancelation_by_1']?></td>

    		<td style="text-align: center;" ><?=$value['nonemergency_order_create_by_4']?></td>
    		<td style="text-align: center;" ><?=$value['nonemergency_order_cancel_by_4']?></td>
    		<td style="text-align: center;" ><?=$value['nonemergency_order_cancelation_by_4']?></td>
            <td style="text-align: center;">
<?php 
            $prosentase = 0;
            $div = ($value['nonemergency_order_cancel_by_1']+$value['nonemergency_order_cancel_by_4']+$value['nonemergency_order_create_by_1']+$value['nonemergency_order_create_by_4']);
            if($div>0){
                $prosentase = (($value['nonemergency_order_create_by_1']+$value['nonemergency_order_create_by_4'])
                / ($div))
                * 100;
            }

                echo round($prosentase)."%";

?> 
    		</td>
    		<td  style="text-align: center;" >-</td>

    	</tr>
    <?php } ?>
    <tr>
        <th height="10" width="auto" align="center" rowspan="3" ></th>
        <th height="50" width="auto" align="center" rowspan="3" style="text-align: right;" >Total</th>
		<th width="auto" align="center" ><?=$total_emergency_order_create_by_1?></th>
		<th width="auto" align="center" ><?=$total_emergency_order_cancel_by_1?></th>
		<th width="auto" align="center" ></th>


		<th width="auto" align="center" ><?=$total_emergency_order_create_by_4?></th>
		<th width="auto" align="center" ><?=$total_emergency_order_cancel_by_4?></th>
		<th width="auto" align="center" ></th>
		<th width="auto" align="center" ></th>


		<th width="auto" align="center" ><?=$total_nonemergency_order_create_by_1?></th>
		<th width="auto" align="center" ><?=$total_nonemergency_order_cancel_by_1?></th>
		<th width="auto" align="center" ></th>
		<th width="auto" align="center" ><?=$total_nonemergency_order_create_by_4?></th>
		<th width="auto" align="center" ><?=$total_nonemergency_order_cancel_by_4?></th>
		<th width="auto" align="center" ></th>
        <th width="auto" align="center" ></th>
		<th height="10" width="auto" align="center" rowspan="3" ></th>
        
    </tr>
    <tr>
        <th width="auto" align="center" colspan="3" bgcolor="#b8cce4" >
            <?=$total_emergency_order_create_by_1+$total_emergency_order_create_by_4?>
        </th>
        <th width="auto" align="center" colspan="3" bgcolor="#fbd5b4" >
            <?=$total_emergency_order_cancel_by_1+$total_emergency_order_cancel_by_4?>
        </th>
        <th rowspan="2"  >
            <?php
                $prosentase = 0;
                $penyebut = ($total_emergency_order_create_by_4+$total_emergency_order_cancel_by_4+$total_emergency_order_create_by_1+$total_emergency_order_cancel_by_1);
                if($penyebut>0){
                     $prosentase = ($total_emergency_order_create_by_1+$total_emergency_order_create_by_4)/
                    ($total_emergency_order_create_by_4+$total_emergency_order_cancel_by_4+$total_emergency_order_create_by_1+$total_emergency_order_cancel_by_1)
                    *100;
                }
               
                    echo round($prosentase)."%";
            ?>
        </th>

         <th width="auto" align="center" colspan="3" bgcolor="#b8cce4" >
            <?=$total_nonemergency_order_create_by_1+$total_nonemergency_order_create_by_4?>
        </th>
        <th width="auto" align="center" colspan="3" bgcolor="#fbd5b4" >
            <?=$total_nonemergency_order_cancel_by_1+$total_nonemergency_order_cancel_by_4?>
        </th>
        <th rowspan="2">
            <?php
                $prosentase = 0;
                $penyebut = ($total_nonemergency_order_create_by_4+$total_nonemergency_order_cancel_by_4+$total_nonemergency_order_create_by_1+$total_nonemergency_order_cancel_by_1);
                if($penyebut>0){
                    $prosentase = ($total_nonemergency_order_create_by_1+$total_nonemergency_order_create_by_4)/
                    ($total_nonemergency_order_create_by_4+$total_nonemergency_order_cancel_by_4+$total_nonemergency_order_create_by_1+$total_nonemergency_order_cancel_by_1)
                    *100;
                }
                
                    echo round($prosentase)."%";
            ?>
        </th>
    </tr>
    <tr>
        <th colspan="3" bgcolor="#b8cce4">
            ORDERS DONE
        </th>
        <th colspan="3" bgcolor="#fbd5b4">
            CANCEL
        </th>
        <th colspan="3" bgcolor="#b8cce4">
            ORDERS DONE
        </th>
        <th colspan="3" bgcolor="#fbd5b4">
            CANCEL
        </th>
    </tr>
    
		
</table>