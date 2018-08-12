<div class="container-fluid main-content">
    <div class="page-title">
        <h1></h1>
    </div>
    <!-- DataTables Example -->
    <div class="row">
		<div class="col-lg-12">
			<?php
				if($this->session->flashdata('message') != "") {
					$data['status'] = $this->session->flashdata('status');	
					$data['notify'] = $this->session->flashdata('message');
					$this->load->view('../v_alert', $data);
				}
			?>
		</div>
		
        <div class="col-lg-1">&nbsp;</div>
		<div class="col-lg-10">
			<div class="widget-container fluid-height clearfix">
				<div class="heading">
					LIST COMPLAINT
					<a href="javascript:void(0);" OnClick="link_add('complaint/add');"><i class="icon-plus pull-right"> Add Data</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped" id="dataTableNoSort">
						<thead>
							<tr>
								<th></th>
								<th width="25%">Hospital</th>
								<th width="15%" class="hidden-xs">Name</th>
								<th width="15%" class="hidden-xs">Type</th>
								<th>Description</th>
								<th width="15%">File</th>
								<th width="10%" class="hidden-xs">Status</th>
								
									<th width="15%">Action</th>							
								
								
							</tr>
						</thead>
						<tbody>

							<?php 
							$x=0;
							foreach($list as $row) : 
								$x++;
								?>
							<tr>
								<td><?=$x?></td>
								<td><?php echo strip_tags($this->m_hospital->get_name_by_id($row->hospital_id)); ?></td>
								<td align="center" class="hidden-xs"><?php echo $row->name; ?></td>
								<td align="center" class="hidden-xs"><?php 
									if ($row->type==1) {
										echo "Urgent";
									}elseif ($row->type==2) {
										echo "Midle";
									}else{
										echo "Low";
									}

								 ?></td>
								<td><?php echo strip_tags($row->description); ?></td>
								<td align="center"><img src="<?php echo base_url('assets/uploads/complaint/'.$row->file); ?>" width="100" ></td>
								<td align="center" class="hidden-xs"><span class="label label-<?php echo (($row->status == 1)?'success':'danger'); ?>"><?php echo (($row->status == 1)?'Answer':'Pending'); ?></span></td>

								
								<td class="actions" align="center">
									<div class="action-buttons">
										<a class="table-actions" href="javascript:void(0);" onClick="edit_data('complaint', '<?php echo simple_encrypt($row->complaint_id); ?>');"><i class="icon-pencil"></i></a>
									</div>
								</td>
								


							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-1">&nbsp;</div>
    </div>
    <!-- end DataTables Example -->
</div>