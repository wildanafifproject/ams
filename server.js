/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var socket = require('socket.io');
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = socket.listen(server);
var port = process.env.PORT || 3000;
var request = require('request');
var mysql = require('mysql');
var config;
var con;
function connectToMysql() {
    con = mysql.createConnection({
        host: "localhost",
        user: "root",
        password: "",
        database: "db_ams3"
    });
}
var admin = require("firebase-admin");

var serviceAccount = require("./keyfrbadmin.json");

admin.initializeApp({
    credential: admin.credential.cert(serviceAccount),
    databaseURL: "https://sos-ambulance.firebaseio.com"
});
server.listen(port, function () {
    console.log('Server listening at port %d', port);
    schedule();
//    writeAmbulanceData(16);
//    sendNotificationToUser({
//        id: "id",
//        type: " Emergency",
//        hospitalId: "hospitalId",
//        ambulanceId: 16,
//        patientName: "patientName"
//    });
    // initFrb();
});
function writeAmbulanceData(ambulanceId) {

    var adaRankRef = admin.database().ref('nonemergency/ambulance/' + ambulanceId + '/ambulance_notifikasi');
    adaRankRef.transaction(function (currentRank) {
        // If users/ada/rank has never been set, currentRank will be `null`.
        return (currentRank || 0) + 1;
    });
}

function sendNotificationToUser(data) {
    request.post({
        headers: {'content-type': 'application/x-www-form-urlencoded'},
        url: 'http://localhost/gt_ams/api/notifikasi_api',
        form: data,
        json: true,
    }, function (error, response, body) {
        console.log(body);
    });
}

function schedule() {
    setInterval(function () {
        var dataResult = [];
        var currentdate = new Date();
        var currentMonthInt = (currentdate.getMonth() + 1);
        var currentMonth = currentMonthInt + "";
        var currentHours = currentdate.getHours();
        var currentMinutes = currentdate.getMinutes();
        var currentDay = currentdate.getDate();
        if (currentMonthInt < 10) {
            currentMonth = "0" + currentMonth;
        }
        if (currentHours < 10) {
            currentHours = "0" + currentHours;
        }
        if (currentMinutes < 10) {
            currentMinutes = "0" + currentMinutes;
        }
        if (currentDay < 10) {
            currentDay = "0" + currentDay;
        }
        var onlyDate = currentdate.getFullYear() + "-" + currentMonth + "-" + currentDay;
        var onlyTime = currentHours + ":" + currentMinutes;
        //console.log(onlyDate + " " + onlyTime);
        //console.log("get Data");
        connectToMysql();
        var dataResult = [];
        con.connect(function (err) {
            if (err)
                throw err;
            // if connection is successful
            var querS = "SELECT * FROM `tp_nonemergency` where nonemergency_infodate='" + onlyDate + "' AND nonemergency_infotime >='" + onlyTime + ":00' AND nonemergency_infotime <='" + onlyTime + ":59'";
            console.log(querS);
            con.query(querS, function (err, result, fields) {
                // if any error while executing above query, throw error
                // iterate for all the rows in result
                Object.keys(result).forEach(function (key) {
                    var row = result[key];
                    writeAmbulanceData(row.ambulance_id);
                    sendNotificationToUser({
                        id: row.nonemergency_id,
                        type: "Non Emergency",
                        hospitalId: row.nonemergency_tohospital,
                        ambulanceId: row.ambulance_id,
                        patientName: row.nonemergency_infoname
                    });
                    console.log(row.ambulance_id);
                });
                // console.log(dataResult);
            });

        });

    }, 15000);
}

io.on('connection', function (socket) {

    socket.on('new_count_message', function (data) {
        io.sockets.emit('new_count_message', {
            new_count_message: data.new_count_message

        });
    });

    socket.on('update_count_message', function (data) {
        io.sockets.emit('update_count_message', {
            update_count_message: data.update_count_message
        });
    });

    socket.on('notifikasi', function (data) {
        io.sockets.emit('notifikasi', data);
        console.log(data);
    });




});
