var socket = io.connect( 'http://'+window.location.hostname+':3000' );
var audio = new Audio(base_url+'assets/ringtone/notification.mp3');
var is_sender=false;
function link_new_tab(url) {
	location.reload();
	uri = url;	
	window.open(uri,'_blank', 'directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no, width=770, height=700, top=20, left=80');
}
function notifikasi(to){
    is_sender=true;
             // socket.emit('new_count_message', { 
             //      new_count_message: data.new_count_message
             // });
    socket.emit('notifikasi', { 
        to: to,
        
    });
}
function initNotif() {
    count_emergency();
    notif_emergency();

    count_nonemergency();
    notif_nonemergency();
}

socket.on('notifikasi', function (data) {
    //alert('user auth: '+user_authority+', to:'+data.to);
    if (data.to == hospital_id_notif || user_authority == '2') {
        audio.play();
        count_emergency();
        notif_emergency();

        count_nonemergency();
        notif_nonemergency();
    }

});
function link_to(url) {
	location.href = base_url + url;
}

function link_detail(url, id) {
	location.href = base_url + url + "/detail-data/" + id;
}

function link_preview(url, id) {
	uri = base_url + url + "/preview-data/" + id;	
	window.open(uri,'_blank', 'directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no, width=770, height=500, top=20, left=80');
}

function link_pdf(url) {
	location.href = base_url + "report/" + url + "/export-to-pdf";
}

function link_excel(url) {
	location.href = base_url + "report/" + url + "/export-to-excel";
}

function link_download(url, file) {
	uri = base_url + 'assets/uploads/' + url + '/' + file;	
	window.open(uri,'_self', 'directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no, width=600, height=400, top=20, left=80');
}

function link_add(url) {
	location.href = base_url + url + "/add-data";
}

function link_edit(url, id) {
	location.href = base_url + url + "/edit-data/" + id;
}

function link_delete(url, id) {
	location.href = base_url + url + "/delete-data/" + id;
}

function link_delete_detail(url, id, detail) {
	location.href = base_url + url + "/delete-detail-" + detail + "/" + id;
}

function edit_data(url, id) {
	$('#modal-edit').modal()                      
	$('#modal-edit').modal({ keyboard: false })   
	$('#modal-edit').modal('show')                
	
	$('#edit-yes').click(
		function() {
			link_edit(url, id);
		}
	);
	
	return false;
}

function edit_to(url, id) {
	$('#modal-edit').modal()                      
	$('#modal-edit').modal({ keyboard: false })   
	$('#modal-edit').modal('show')                
	
	$('#edit-yes').click(
		function() {
			link_to(url + "/" + id);
		}
	);
	
	return false;
}

function delete_data(url, id) {
	$('#modal-delete').modal()                      
	$('#modal-delete').modal({ keyboard: false })   
	$('#modal-delete').modal('show')                
	
	$('#delete-yes').click(
		function() {
			link_delete(url, id);
		}
	);
	
	return false;
}

function delete_to(url) {
	$('#modal-delete').modal()                      
	$('#modal-delete').modal({ keyboard: false })   
	$('#modal-delete').modal('show')                
	
	$('#delete-yes').click(
		function() {
			link_to(url);
		}
	);
	
	return false;
}

function delete_detail_data(url, id, detail) {
	$('#modal-delete').modal()                      
	$('#modal-delete').modal({ keyboard: false })   
	$('#modal-delete').modal('show')                
	
	$('#delete-yes').click(
		function() {
			link_delete_detail(url, id, detail);
		}
	);
}

function show_message(message) {
	$("#validate-message").html(message);
	
	$('#modal-message').modal()                      
	$('#modal-message').modal({ keyboard: false })   
	$('#modal-message').modal('show')                
}

function show_form_status_emergency(id, status) {
	document.getElementById("emergency_status").value = id;
	document.getElementById("status_emergency").value = status;
	
	$('#modal-status-emergency').modal()                      
	$('#modal-status-emergency').modal({ keyboard: false })   
	$('#modal-status-emergency').modal('show')                
}

function show_form_cancel_emergency(id) {
	document.getElementById("emergency_cancel").value = id;
	
	$('#modal-cancel-emergency').modal()                      
	$('#modal-cancel-emergency').modal({ keyboard: false })   
	$('#modal-cancel-emergency').modal('show')                
}

function show_crew_emergency(id) {
	$('#modal-crew-emergency').modal()                      
	$('#modal-crew-emergency').modal({ keyboard: false })   
	$('#modal-crew-emergency').modal('show')                
}

function show_form_status_nonemergency(id, status) {
	document.getElementById("nonemergency_status").value = id;
	document.getElementById("status_nonemergency").value = status;
	
	$('#modal-status-nonemergency').modal()                      
	$('#modal-status-nonemergency').modal({ keyboard: false })   
	$('#modal-status-nonemergency').modal('show')                
}

function show_form_cancel_nonemergency(id) {
	document.getElementById("nonemergency_cancel").value = id;
	
	$('#modal-cancel-nonemergency').modal()                      
	$('#modal-cancel-nonemergency').modal({ keyboard: false })   
	$('#modal-cancel-nonemergency').modal('show')                
}

function reset_area(d) {
	$("#area").select2("val", null);
	ajax_ambulance_default();
	ajax_motorbike_default();
}

function get_crew(type, id, heading) {
	$("#heading-crew").html(heading);
	
	$('#modal-get-crew').modal()                      
	$('#modal-get-crew').modal({ keyboard: false })   
	$('#modal-get-crew').modal('show')           
	
	ajax_detail_crew(type, id);	
}

function set_emergency_crew(ambulance, id) {
	document.getElementById("set_emergency_crew").value = id;
	
	$('#modal-set-emergency-crew').modal()                      
	$('#modal-set-emergency-crew').modal({ keyboard: false })   
	$('#modal-set-emergency-crew').modal('show')                
	
	ambulance_emergency_driver(ambulance);
	ambulance_emergency_doctor(ambulance);
	ambulance_emergency_nurse(ambulance);
}

function set_nonemergency_crew(ambulance, id) {
	document.getElementById("set_nonemergency_crew").value = id;
	
	$('#modal-set-nonemergency-crew').modal()                      
	$('#modal-set-nonemergency-crew').modal({ keyboard: false })   
	$('#modal-set-nonemergency-crew').modal('show')                
	
	ambulance_nonemergency_driver(ambulance);
	ambulance_nonemergency_doctor(ambulance);
	ambulance_nonemergency_nurse(ambulance);
}

function accept_emergency(id) {
	$('#modal-accept-emergency').modal()                      
	$('#modal-accept-emergency').modal({ keyboard: false })   
	$('#modal-accept-emergency').modal('show')                
	
	$('#accept-emergency-yes').click(
		function() {
			link_to('emergency/accept-data/' + id);
		}
	);
	
	return false;
}

function accept_nonemergency(id) {
	$('#modal-accept-nonemergency').modal()                      
	$('#modal-accept-nonemergency').modal({ keyboard: false })   
	$('#modal-accept-nonemergency').modal('show')                
	
	$('#accept-nonemergency-yes').click(
		function() {
			link_to('non-emergency/accept-data/' + id);
		}
	);
	
	return false;
}