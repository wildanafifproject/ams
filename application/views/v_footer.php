		<script>
			function change_radio(id) {
				document.getElementById("category"+id).checked = true;
			}
			
			function change_ambulance(id) {
				$('.checkboxAmbulance').each(function () {
					this.checked = false;
				});
				
				document.getElementById("chkAmbulance"+id).checked = true;
			}
			
			function change_motorbike(id) {
				$('.checkboxMotorbike').each(function () {
					this.checked = false;
				});
				
				document.getElementById("chkMotorbike"+id).checked = true;
			}
		</script>
	</body>
	
	<div class="modal fade" id="modal-edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
					<h4 class="modal-title"><i class="icon-warning-sign"></i> Edit Confirmation</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure want to edit this data ?</p>
				</div>
				<div class="modal-footer">
					<button id="edit-no" class="btn btn-danger" data-dismiss="modal" type="button"><i class="icon-repeat"> CANCEL</i></button>
					<button id="edit-yes" class="btn btn-primary" type="button"><i class="icon-save"></i> SUBMIT</button>
				</div>
			</div>
		</div>
    </div>
	
	<div class="modal fade" id="modal-delete">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
					<h4 class="modal-title"><i class="icon-warning-sign"></i> Delete Confirmation</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure want to delete this data ?</p>
				</div>
				<div class="modal-footer">
					<button id="delete-no" class="btn btn-danger" data-dismiss="modal" type="button"><i class="icon-repeat"> CANCEL</i></button>
					<button id="delete-yes" class="btn btn-primary" type="button"><i class="icon-save"></i> SUBMIT</button>
				</div>
			</div>
		</div>
    </div>
	
	<div class="modal fade" id="modal-message">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
					<h4 class="modal-title"><i class="icon-exclamation-sign"></i> Notification</h4>
				</div>
				<div class="modal-body">
					<p id="validate-message"></p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default-outline" data-dismiss="modal" type="button"><i class="icon-info-sign"> CLOSE</i></button>
				</div>
			</div>
		</div>
    </div>
	
	<div class="modal fade" id="modal-status-emergency">
		<div class="modal-dialog">
			<form class="form-horizontal" method="post" id="form_update_emergency" action="<?php echo base_url(); ?>emergency/set-status">
				<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
				<input type="hidden" id="emergency_status" name="emergency_status" value="" readonly />
				<input type="hidden" id="status_emergency" name="status" value="" readonly />
				<input type="hidden" id="datetime_emergency" name="datetime_emergency">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
						<h4 class="modal-title"><i class="icon-warning-sign"></i> Edit Status</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-md-3">Time <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<div class="input-group bootstrap-timepicker">
									<input class="form-control" id="timepicker-24h" name="time" type="text" value="<?php echo get_his(); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> SUBMIT</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
    </div>
	
	<div class="modal fade" id="modal-cancel-emergency">
		<div class="modal-dialog">
			<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>emergency/set-cancel">
				<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
				<input type="hidden" id="emergency_cancel" name="emergency_cancel" value="" readonly />
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
						<h4 class="modal-title"><i class="icon-warning-sign"></i> Cancel Emergency</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-md-3">Reason</label>
							<div class="col-md-8">
								<textarea class="form-control" rows="2" style="resize: none;" name="reason"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> SUBMIT</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
    </div>
	
	<div class="modal fade" id="modal-set-emergency-crew">
		<div class="modal-dialog">
			<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>emergency/set-crew">
				<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
				<input type="hidden" id="set_emergency_crew" name="emergency" value="" readonly />
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
						<h4 class="modal-title"><i class="icon-user"></i> Set Emergency Crew</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-md-2">Driver <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="set_crew_emergency_driver" name="driver[]" required=""></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Doctor <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="set_crew_emergency_doctor" name="doctor[]" required=""></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Nurse <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="set_crew_emergency_nurse" name="nurse[]" required=""></select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> SUBMIT</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
    </div>
	
	<div class="modal fade" id="modal-set-nonemergency-crew">
		<div class="modal-dialog">
			<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>non-emergency/set-crew">
				<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
				<input type="hidden" id="set_nonemergency_crew" name="nonemergency" value="" readonly />
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
						<h4 class="modal-title"><i class="icon-user"></i> Set Non Emergency Crew</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-md-2">Driver <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="set_crew_nonemergency_driver" name="driver[]" required=""></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Doctor <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="set_crew_nonemergency_doctor" name="doctor[]" required=""></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Nurse <span class="text-danger">*</span></label>
							<div class="col-md-9">
								<select class="select2able" multiple="" id="set_crew_nonemergency_nurse" name="nurse[]" required=""></select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> SUBMIT</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
    </div>
	
	<div class="modal fade" id="modal-status-nonemergency">
		<div class="modal-dialog">
			<form class="form-horizontal" method="post" id="form_update_nonemergency" action="<?php echo base_url(); ?>non-emergency/set-status">
				<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
				<input type="hidden" id="nonemergency_status" name="nonemergency_status" value="" readonly />
				<input type="hidden" id="status_nonemergency" name="status" value="" readonly />
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
						<h4 class="modal-title"><i class="icon-warning-sign"></i> Edit Status</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-md-3">Date <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<div class="input-group">
									<input class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" name="date" type="text" value="<?php echo get_dmy(); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-calendar"></i></span></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Time <span class="text-danger">*</span></label>
							<div class="col-md-8">
								<div class="input-group bootstrap-timepicker">
									<input class="form-control" id="timepicker-24" name="time" type="text" value="<?php echo get_his(); ?>" autocomplete="off" required="" ><span class="input-group-addon"><i class="icon-time"></i></span></input>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> SUBMIT</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
    </div>
	
	<div class="modal fade" id="modal-cancel-nonemergency">
		<div class="modal-dialog">
			<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>non-emergency/set-cancel">
				<input type="hidden" name="valid" value="<?php echo simple_encrypt(1); ?>" />
				<input type="hidden" id="nonemergency_cancel" name="nonemergency_cancel" value="" readonly />
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
						<h4 class="modal-title"><i class="icon-warning-sign"></i> Cancel Emergency</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-md-3">Reason</label>
							<div class="col-md-8">
								<textarea class="form-control" rows="2" style="resize: none;" name="reason"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-7">
								<button class="btn btn-danger" type="reset"><i class="icon-repeat"></i> CANCEL</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> SUBMIT</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
    </div>
	
	<div class="modal fade" id="modal-get-crew"">
		<div class="modal-dialog">
			<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>non-emergency/set-cancel">
				<div class="modal-content">
					<div class="modal-header" style="background: #f1f1f1;">
						<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
						<h4 class="modal-title">AMBULANCE ON DUTY (CREW) <br> <p id="heading-crew"></p></h4>
					</div>
					<div class="modal-body" id="detail_crew"></div>
				</div>
			</form>		
		</div>
    </div>

	<div class="modal fade" id="modal-accept-emergency">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
					<h4 class="modal-title"><i class="icon-warning-sign"></i> Accept Confirmation</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure want to accept this data ?</p>
				</div>
				<div class="modal-footer">
					<button id="accept-emergency-no" class="btn btn-danger" data-dismiss="modal" type="button"><i class="icon-repeat"> CANCEL</i></button>
					<button id="accept-emergency-yes" class="btn btn-primary" type="button"><i class="icon-save"></i> SUBMIT</button>
				</div>
			</div>
		</div>
    </div>
	
	<div class="modal fade" id="modal-accept-nonemergency">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
					<h4 class="modal-title"><i class="icon-warning-sign"></i> Accept Confirmation</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure want to accept this data ?</p>
				</div>
				<div class="modal-footer">
					<button id="accept-nonemergency-no" class="btn btn-danger" data-dismiss="modal" type="button"><i class="icon-repeat"> CANCEL</i></button>
					<button id="accept-nonemergency-yes" class="btn btn-primary" type="button"><i class="icon-save"></i> SUBMIT</button>
				</div>
			</div>
		</div>
    </div>
	
	<style>
		#mapCanvas {
			width: 100%;
			height: 300px;
		}
		
		#mapCanvas2 {
			width: 100%;
			height: 300px;
		}
	</style>
	
	<script src="http://maps.google.com/maps/api/js?key=AIzaSyD-sd_b7ydVjn2n0zJcPahkRkqjw1Qfwd0"></script>

	<script>
		<?php if($this->session->userdata('default_map') == 1) { ?>
			<?php if($this->session->userdata('default_report') == 1) { ?>
			var stat = 0;
			<?php } else { ?>
			var stat = 1;
			<?php } ?>
		<?php } else { ?>
		var stat = 0;
		<?php } ?>
	</script>
	
	<script>
		<?php if($this->session->userdata('default_map') == 1) { ?>
		var mapLatitude = <?php echo $this->session->userdata('default_lat'); ?>;
		var mapLongitude = <?php echo $this->session->userdata('default_lon'); ?>;
		<?php } else { ?>
		var mapLatitude = <?php echo lat_default; ?>;
		var mapLongitude = <?php echo lon_default; ?>;
		<?php } ?>
			
		function initMap() {
			var map = new google.maps.Map(document.getElementById('mapCanvas'), {
				mapTypeControl: false,
				streetViewControl: false,
				panControl: false,
				scaleControl: true, // enable scale control
				zoomControl: true, //enable zoom control
				zoom: <?php echo (($this->session->userdata('default_zoom') == "")?zoom_default:$this->session->userdata('default_zoom')); ?>,
				center: {lat: mapLatitude, lng: mapLongitude}
			});
			
			<?php if($this->session->userdata('default_report') == 1) { ?>
			var myCenter=new google.maps.LatLng(mapLatitude, mapLongitude);
			var marker;
			
			var marker=new google.maps.Marker({
				position:myCenter,
				//animation:google.maps.Animation.BOUNCE,
				icon : base_url + "assets/images/32.png"
				//label: "Ambulance Location",
			});

			marker.setMap(map);
			
			<?php if($this->session->userdata('default_ambulance') == 1) { ?>
			var myCenter1=new google.maps.LatLng(<?php echo $this->session->userdata('ambulance_lat'); ?>, <?php echo $this->session->userdata('ambulance_lon'); ?>);
			var marker1;
			
			var marker1=new google.maps.Marker({
				position:myCenter1,
				icon : base_url + "assets/images/32ambu.png"
			});

			marker1.setMap(map);
			<?php } ?>
			<?php } ?>
		}
    </script>
	
	<script>
		var geocoder;
		codeAddress = function() {
			
			var map;
			var marker;
			
			geocoder = new google.maps.Geocoder();
			var address = document.getElementById('street_search').value;
			
			if(address == "") {
				show_message("Street name cannot be empty");
			}
			else {
				geocoder.geocode({
					'address': address
				}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						if(stat == 0) {
							lokasi_nya = results[0].geometry.location;
						}
						else {
							lokasi_nya = new google.maps.LatLng(mapLatitude, mapLongitude);
						}
						
						map = new google.maps.Map(document.getElementById('mapCanvas'), {
							zoom: 16,
							mapTypeControl: false,
							streetViewControl: false,
							panControl: false,
							scaleControl: true, // enable scale control
							zoomControl: true, //enable zoom control
							mapTypeControlOptions: {
								style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
								mapTypeIds: [google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.ROADMAP]
							},
							center: lokasi_nya,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						});
						
						map.setCenter(lokasi_nya);
						marker = new google.maps.Marker({
							map: map,
							position: lokasi_nya,
							draggable: true,
							title: 'From Location'
						});
						updateMarkerPosition('street_latitude', 'street_longitude', lokasi_nya);
						geocodePosition('street_address', lokasi_nya);

						// Add dragging event listeners.
						google.maps.event.addListener(marker, 'dragstart', function() {
							updateMarkerAddress('street_address', '...');
						});

						google.maps.event.addListener(marker, 'drag', function() {
							updateMarkerPosition('street_latitude', 'street_longitude', marker.getPosition());
						});

						google.maps.event.addListener(marker, 'dragend', function() {
							geocodePosition('street_address', marker.getPosition());
							map.panTo(marker.getPosition());
						});

						google.maps.event.addListener(map, 'click', function(e) {
							updateMarkerPosition('street_latitude', 'street_longitude', e.latLng);
							geocodePosition('street_address', marker.getPosition());
							marker.setPosition(e.latLng);
							map.panTo(marker.getPosition());
						});

					} else {
						alert('Geocode was not successful for the following reason: ' + status);
					}
				});
			}
		}

		function geocodePosition(div, pos) {
			geocoder.geocode({
				latLng: pos
			}, function(responses) {
				if (responses && responses.length > 0) {
					updateMarkerAddress(div, responses[0].formatted_address);
				} else {
					updateMarkerAddress(div, 'Cannot determine address at this location.');
				}
			});
		}

		function updateMarkerPosition(div_latitude, div_longitude, latLng) {
			document.getElementById(div_latitude).value = latLng.lat();
			document.getElementById(div_longitude).value = latLng.lng();
		}

		function updateMarkerAddress(div_address, str) {
			document.getElementById(div_address).value = str;
		}
	</script>
	
	<script>
		<?php if($this->session->userdata('default_map2') == 1) { ?>
			<?php if($this->session->userdata('default_report2') == 1) { ?>
			var stat2 = 0;
			<?php } else { ?>
			var stat2 = 1;
			<?php } ?>
		<?php } else { ?>
		var stat2 = 0;
		<?php } ?>
	</script>
	
	<script>
		<?php if($this->session->userdata('default_map2') == 1) { ?>
		var mapLatitude2 = <?php echo $this->session->userdata('default_lat2'); ?>;
		var mapLongitude2 = <?php echo $this->session->userdata('default_lon2'); ?>;
		<?php } else { ?>
		var mapLatitude2 = <?php echo lat_default; ?>;
		var mapLongitude2 = <?php echo lon_default; ?>;
		<?php } ?>
			
		function initMap2() {
			var map = new google.maps.Map(document.getElementById('mapCanvas2'), {
				mapTypeControl: false,
				streetViewControl: false,
				panControl: false,
				scaleControl: true, // enable scale control
				zoomControl: true, //enable zoom control
				zoom: <?php echo (($this->session->userdata('default_zoom') == "")?zoom_default:$this->session->userdata('default_zoom')); ?>,
				center: {lat: mapLatitude2, lng: mapLongitude2}
			});
			
			<?php if($this->session->userdata('default_report2') == 1) { ?>
			var myCenter=new google.maps.LatLng(mapLatitude2, mapLongitude2);
			var marker;
			
			var marker=new google.maps.Marker({
				position:myCenter,
				//animation:google.maps.Animation.BOUNCE,
				icon : base_url + "assets/images/32ambu.png"
				//label: "Ambulance Location",
			});

			marker.setMap(map);
			<?php } ?>
		}
    </script>
	
	<script>
		var geocoder2;
		codeAddress2 = function() {
			
			var map;
			var marker;
			
			geocoder2 = new google.maps.Geocoder();
			var address = document.getElementById('street_search2').value;
			
			if(address == "") {
				show_message("Street name cannot be empty");
			}
			else {
				geocoder2.geocode({
					'address': address
				}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						if(stat == 0) {
							lokasi_nya = results[0].geometry.location;
						}
						else {
							lokasi_nya = new google.maps.LatLng(mapLatitude2, mapLongitude2);
						}
						
						map = new google.maps.Map(document.getElementById('mapCanvas2'), {
							zoom: 16,
							mapTypeControl: false,
							streetViewControl: false,
							panControl: false,
							scaleControl: true, // enable scale control
							zoomControl: true, //enable zoom control
							mapTypeControlOptions: {
								style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
								mapTypeIds: [google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.ROADMAP]
							},
							center: lokasi_nya,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						});
						
						map.setCenter(lokasi_nya);
						marker = new google.maps.Marker({
							map: map,
							position: lokasi_nya,
							draggable: true,
							title: 'To Location'
						});
						updateMarkerPosition('street_latitude2', 'street_longitude2', lokasi_nya);
						geocodePosition2('street_address2', lokasi_nya);

						// Add dragging event listeners.
						google.maps.event.addListener(marker, 'dragstart', function() {
							updateMarkerAddress('street_address2', '...');
						});

						google.maps.event.addListener(marker, 'drag', function() {
							updateMarkerPosition('street_latitude2', 'street_longitude2', marker.getPosition());
						});

						google.maps.event.addListener(marker, 'dragend', function() {
							geocodePosition2('street_address2', marker.getPosition());
							map.panTo(marker.getPosition());
						});

						google.maps.event.addListener(map, 'click', function(e) {
							updateMarkerPosition('street_latitude2', 'street_longitude2', e.latLng);
							geocodePosition2('street_address2', marker.getPosition());
							marker.setPosition(e.latLng);
							map.panTo(marker.getPosition());
						});

					} else {
						alert('Geocode was not successful for the following reason: ' + status);
					}
				});
			}
		}
		
		function geocodePosition2(div, pos) {
			geocoder2.geocode({
				latLng: pos
			}, function(responses) {
				if (responses && responses.length > 0) {
					updateMarkerAddress(div, responses[0].formatted_address);
				} else {
					updateMarkerAddress(div, 'Cannot determine address at this location.');
				}
			});
		}
	</script>
</html>
