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
					LIST USER
					<a href="javascript:void(0);" OnClick="link_add('user');"><i class="icon-plus pull-right"> Add Data</i></a>
				</div>
				<div class="widget-content padded clearfix">
					<table class="table table-bordered table-striped" id="dataTableNoSort">
						<thead>
							<tr>
								<th>Username</th>
								<th width="25%">Full Name</th>
								<th width="10%" class="hidden-xs">Authority</th>
								<th width="20%" class="hidden-xs">Hospital</th>
								<th width="15%" class="hidden-xs">Last Login</th>
								<th width="10%" class="hidden-xs">Image</th>
								<th width="15%">Action</th>								
							</tr>
						</thead>
						<tbody>
							<?php foreach($list as $row) : ?>
							<tr>
								<td><?php echo $row->user_name; ?></td>
								<td><?php echo strip_tags($row->user_fullname); ?></td>
								<td align="center" class="hidden-xs"><?php echo get_authority($row->user_authority); ?></td>
								<td class="hidden-xs"><?php echo strip_tags($this->m_hospital->get_name_by_id($row->hospital_id)); ?></td>
								<td align="center" class="hidden-xs"><?php echo (($row->last_login != "")?convert_to_dmyhis($row->last_login):""); ?></td>
								<td align="center" class="hidden-xs">
									<a class="gallery-item fancybox" href="<?php echo base_url() ."assets/uploads/".(($row->user_image != "")?"user/". $row->user_image:"no_image.png"); ?>" title="<?php echo strip_tags($row->user_name); ?>">
										<img src="<?php echo base_url() ."assets/uploads/".(($row->user_image != "")?"user/thumb/". $row->user_image:"no_image.png"); ?>" style="width:60px;" />
										<div class="actions">
											<i class="icon-zoom-in"></i>
										</div>
									</a>
								</td>
								<td class="actions" align="center">
									<div class="action-buttons">
										<a class="table-actions" href="javascript:void(0);" onClick="edit_data('user', '<?php echo simple_encrypt($row->user_id); ?>');"><i class="icon-pencil"></i></a>
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