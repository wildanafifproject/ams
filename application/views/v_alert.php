<?php 
	$status_success = "display: none;";	$status_info = "display: none;";	$status_warning = "display: none;";	$status_danger = "display: none;";
	
	switch($status) {
		case "SUCCESS" :
			$status_success = "display: block;";
		break;
		case "INFO" :
			$status_info = "display: block;";
		break;	
		case "WARNING" :
			$status_warning = "display: block;";
		break;
		case "DANGER" :
			$status_danger = "display: block;";
		break;	
	}
?>
		
<div class="alert alert-success" style="<?php echo $status_success; ?>">
	<button class="close" data-dismiss="alert" type="button">&times;</button>
	<h4><i class="icon fa fa-check"></i> <?php echo $notify; ?></h4>
</div>
		
<div class="alert alert-info" style="<?php echo $status_info; ?>">
	<button class="close" data-dismiss="alert" type="button">&times;</button>
	<h4><i class="icon fa fa-info"></i> <?php echo $notify; ?></h4>
</div>

<div class="alert alert-warning"  style="<?php echo $status_warning; ?>">
	<button class="close" data-dismiss="alert" type="button">&times;</button>
	<h4><i class="icon fa fa-warning"></i> <?php echo $notify; ?></h4>
</div>
	
<div class="alert alert-danger" style="<?php echo $status_danger; ?>">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-ban"></i> <?php echo $notify; ?></h4>
</div>