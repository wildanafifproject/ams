function ajax_hospital(id) {
	$("#driver").select2("val", null);
	ajax_driver_by_hospital(id);
	
	$("#doctor").select2("val", null);
	ajax_doctor_by_hospital(id);
	
	$("#nurse").select2("val", null);
	ajax_nurse_by_hospital(id);
}

function ajax_driver_by_hospital(id) {
	var uri = base_url + "ajax/driver-by-hospital";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ hospital:id }),
		success: function(msg) {
			if(msg == ''){
				$("#driver").html('<option></option>');
			}
			else {
				$("#driver").removeAttr('disabled');
				$("#driver").html(msg);
			}                                                                     
		}
	}); 
}

function ajax_doctor_by_hospital(id) {
	var uri = base_url + "ajax/doctor-by-hospital";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ hospital:id }),
		success: function(msg) {
			if(msg == ''){
				$("#doctor").html('<option></option>');
			}
			else {
				$("#doctor").removeAttr('disabled');
				$("#doctor").html(msg);
			}                                                                     
		}
	}); 
}

function ajax_nurse_by_hospital(id) {
	var uri = base_url + "ajax/nurse-by-hospital";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ hospital:id }),
		success: function(msg) {
			if(msg == ''){
				$("#nurse").html('<option></option>');
			}
			else {
				$("#nurse").removeAttr('disabled');
				$("#nurse").html(msg);
			}                                                                     
		}
	}); 
}

function ajax_areadetail_by_area(id) {
	$("#areadetail").select2("val", null);
	var uri = base_url + "ajax/location-by-area";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ area:id }),
		success: function(msg) {
			if(msg == ''){
				$("#areadetail").html('<option></option>');
			}
			else {
				$("#areadetail").removeAttr('disabled');
				$("#areadetail").html(msg);
			}                                                                     
		}
	}); 
}

function ambulance_by_avaibility(id) {
	var date = document.getElementById('date').value;
	var time = document.getElementById('timepicker-24h').value;
	
	if(date == "" ||  time == "") {
		show_message("Please set date and time");
		$("#area").select2("val", null);
		ajax_ambulance_default();
		ajax_motorbike_default();
	}
	else {
		ajax_ambulance_by_avaibility(id, date, time);
		$("#location").select2("val", null);
		var uri = base_url + "ajax/location-by-area";
		
		$.ajax({
			type: "POST",
			dataType: "html",
			url: uri ,
			data: $.param({ area:id }),
			success: function(msg) {
				if(msg == ''){
					$("#location").html('<option></option>');
				}
				else {
					$("#location").removeAttr('disabled');
					$("#location").html(msg);
				}                                                                     
			}
		}); 
	}
}

function ajax_ambulance_by_avaibility(id, date, time) {
	div_loading("#listing_ambulance");
	ajax_motorbike_by_area(id);
	
	var uri = base_url + "ajax/ambulance-by-avaibility";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ area:id, date:date, time:time }),
		success: function(msg) {
			$("#listing_ambulance").fadeIn( 3000 );  			
			$("#listing_ambulance").html(msg);                                                              
		}
	}); 
}

function ajax_ambulance_default() {
	div_loading("#listing_ambulance");

	var uri = base_url + "ajax/ambulance-default";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		success: function(msg) {
			$("#listing_ambulance").fadeIn( 3000 );  			
			$("#listing_ambulance").html(msg);                                                              
		}
	}); 
}

function ajax_motorbike_default() {
	div_loading("#listing_motorbike");

	var uri = base_url + "ajax/motorbike-default";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		success: function(msg) {
			$("#listing_motorbike").fadeIn( 3000 );  			
			$("#listing_motorbike").html(msg);                                                              
		}
	}); 
}


function ajax_location_by_area(id) {
	ajax_ambulance_by_area(id);
	$("#location").select2("val", null);
	var uri = base_url + "ajax/location-by-area";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ area:id }),
		success: function(msg) {
			if(msg == ''){
				$("#location").html('<option></option>');
			}
			else {
				$("#location").removeAttr('disabled');
				$("#location").html(msg);
			}                                                                     
		}
	}); 
}

function ajax_ambulance_by_forward(id) {
	var uri = base_url + "ajax/ambulance-by-forward";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ forward:id }),
		success: function(msg) {
			$("#listing_ambulance").fadeIn( 3000 );  			
			$("#listing_ambulance").html(msg);                                                              
		}
	}); 
}

function ajax_motorbike_by_forward(id) {
	div_loading("#listing_motorbike");
	var uri = base_url + "ajax/motorbike-by-forward";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ forward:id }),
		success: function(msg) {
			$("#listing_motorbike").fadeIn( 3000 );  			
			$("#listing_motorbike").html(msg);                                                              
		}
	}); 
}

function div_loading(div) {
	var uri = base_url + "ajax/div-loading";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		success: function(msg) {
			$(div).fadeIn( 100 );
			$(div).html(msg);                                                                     
		}
	}); 
}

function ajax_ambulance_by_area(id) {
	div_loading("#listing_ambulance");
	ajax_motorbike_by_area(id);
	
	var uri = base_url + "ajax/ambulance-by-area";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ area:id }),
		success: function(msg) {
			$("#listing_ambulance").fadeIn( 3000 );  			
			$("#listing_ambulance").html(msg);                                                              
		}
	}); 
}

function ajax_motorbike_by_area(id) {
	div_loading("#listing_motorbike");
	var uri = base_url + "ajax/motorbike-by-area";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ area:id }),
		success: function(msg) {
			$("#listing_motorbike").fadeIn( 3000 );  			
			$("#listing_motorbike").html(msg);                                                              
		}
	}); 
}

function ajax_detail_crew(type, id) {
	div_loading("#detail_crew");
	var uri = base_url + "ajax/detail_crew";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ type:type, order:id }),
		success: function(msg) {
			$("#detail_crew").fadeIn( 3000 );  			
			$("#detail_crew").html(msg);                                                              
		}
	}); 
}

function ambulance_emergency_driver(id) {
	var uri = base_url + "ajax/ambulance-crew-driver";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ ambulance:id }),
		success: function(msg) {
			if(msg == ''){
				$("#set_crew_emergency_driver").html('<option></option>');
			}
			else {
				$("#set_crew_emergency_driver").removeAttr('disabled');
				$("#set_crew_emergency_driver").html(msg);
			}                                                                    
		}
	});
}

function ambulance_emergency_doctor(id) {
	var uri = base_url + "ajax/ambulance-crew-doctor";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ ambulance:id }),
		success: function(msg) {
			if(msg == ''){
				$("#set_crew_emergency_doctor").html('<option></option>');
			}
			else {
				$("#set_crew_emergency_doctor").removeAttr('disabled');
				$("#set_crew_emergency_doctor").html(msg);
			}                                                                    
		}
	});
}

function ambulance_emergency_nurse(id) {
	var uri = base_url + "ajax/ambulance-crew-nurse";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ ambulance:id }),
		success: function(msg) {
			if(msg == ''){
				$("#set_crew_emergency_nurse").html('<option></option>');
			}
			else {
				$("#set_crew_emergency_nurse").removeAttr('disabled');
				$("#set_crew_emergency_nurse").html(msg);
			}                                                                    
		}
	});
}

function ambulance_nonemergency_driver(id) {
	var uri = base_url + "ajax/ambulance-crew-driver";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ ambulance:id }),
		success: function(msg) {
			if(msg == ''){
				$("#set_crew_nonemergency_driver").html('<option></option>');
			}
			else {
				$("#set_crew_nonemergency_driver").removeAttr('disabled');
				$("#set_crew_nonemergency_driver").html(msg);
			}                                                                    
		}
	});
}

function ambulance_nonemergency_doctor(id) {
	var uri = base_url + "ajax/ambulance-crew-doctor";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ ambulance:id }),
		success: function(msg) {
			if(msg == ''){
				$("#set_crew_nonemergency_doctor").html('<option></option>');
			}
			else {
				$("#set_crew_nonemergency_doctor").removeAttr('disabled');
				$("#set_crew_nonemergency_doctor").html(msg);
			}                                                                    
		}
	});
}

function ambulance_nonemergency_nurse(id) {
	var uri = base_url + "ajax/ambulance-crew-nurse";
	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: uri ,
		data: $.param({ ambulance:id }),
		success: function(msg) {
			if(msg == ''){
				$("#set_crew_nonemergency_nurse").html('<option></option>');
			}
			else {
				$("#set_crew_nonemergency_nurse").removeAttr('disabled');
				$("#set_crew_nonemergency_nurse").html(msg);
			}                                                                    
		}
	});
}