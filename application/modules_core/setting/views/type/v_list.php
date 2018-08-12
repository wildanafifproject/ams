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
					LIST CASE TYPE
					<a href="javascript:void(0);" OnClick="link_add('setting/type');"><i class="icon-plus pull-right"> Add Data</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped" id="dataTableNoSort">
						<thead>
							<tr>
								<th width="35%">Case</th>
								<th>Name</th>
								<th width="10%" class="hidden-xs">Status</th>
								<th width="15%">Action</th>								
							</tr>
						</thead>
						<tbody>
							<?php foreach($list as $row) : ?>
							<tr>
								<td><?php echo strip_tags($this->m_case->get_name_by_id($row->case_id)); ?></td>
								<td><?php echo strip_tags($row->type_name); ?></td>
								<td align="center" class="hidden-xs"><span class="label label-<?php echo (($row->type_status == 1)?'success':'danger'); ?>"><?php echo get_status($row->type_status); ?></span></td>
								<td class="actions" align="center">
									<div class="action-buttons">
										<a class="table-actions" href="javascript:void(0);" onClick="edit_data('setting/type', '<?php echo simple_encrypt($row->type_id); ?>');"><i class="icon-pencil"></i></a>
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