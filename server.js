/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});

setInterval(function(){ 
              var currentdate = new Date();
              var currentMonthInt = (currentdate.getMonth()+1);
              var currentMonth = currentMonthInt+ "";
              if(currentMonthInt<10){
                currentMonth = "0"+currentMonth;
              }
              var onlyDate = currentdate.getFullYear()+"-"+currentMonth+"-"+currentdate.getDate();
              var onlyTime = currentdate.getHours()+":"+currentdate.getMinutes();
              console.log(onlyDate+" "+onlyTime);
            }, 5000);
io.on('connection', function (socket) {

  socket.on( 'new_count_message', function( data ) {
    io.sockets.emit( 'new_count_message', { 
    	new_count_message: data.new_count_message

    });
  });

  socket.on( 'update_count_message', function( data ) {
    io.sockets.emit( 'update_count_message', {
    	update_count_message: data.update_count_message 
    });
  });

  socket.on( 'notifikasi', function( data ) {
    io.sockets.emit( 'notifikasi', data);
    console.log(data);
  });

 

  
});
