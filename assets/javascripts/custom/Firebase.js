var config = {
    apiKey: "AIzaSyBbiOi4Wogy0ogDujcowufG8wxW5lWD4-k",
    authDomain: "sos-ambulance.firebaseapp.com",
    databaseURL: "https://sos-ambulance.firebaseio.com",
    projectId: "sos-ambulance",
    storageBucket: "sos-ambulance.appspot.com",
    messagingSenderId: "222333435740"
  };
firebase.initializeApp(config);

function writeAmbulanceData(ambulanceId) {

	var adaRankRef = firebase.database().ref('ambulance/' + ambulanceId+'/ambulance_notifikasi');
	adaRankRef.transaction(function(currentRank) {
		console.log(currentRank);
	  // If users/ada/rank has never been set, currentRank will be `null`.
	  return currentRank;
	});


  // firebase.database().ref('ambulance/' + ambulanceId).set({
  //   ambulance_notifikasi: 1
  // });
}

function notifToDevice(ambulanceId) {
	firebase.database().ref('ambulance/' + ambulanceId).once('value').then(function(snapshot) {
	  	
	  	var x = snapshot.val().ambulance_notifikasi+1; 
	  	console.log(x);
	  	firebase.database().ref('ambulance/' + ambulanceId).update({
		    ambulance_notifikasi: x
		 });
	});
}