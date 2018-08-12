var socket = io.connect( 'http://'+window.location.hostname+':3000' );
var is_sender=false;
function notifikasi(to){
    is_sender=true;
             // socket.emit('new_count_message', { 
             //      new_count_message: data.new_count_message
             // });
    socket.emit('notifikasi', { 
        to: to,
        
    });
}