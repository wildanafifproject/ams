<!DOCTYPE html>
<html>
<head>
	<title>FRBS</title>
</head>
<body>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script type="text/javascript">
	  var config = {
	    apiKey: "AIzaSyBbiOi4Wogy0ogDujcowufG8wxW5lWD4-k",
	    authDomain: "sos-ambulance.firebaseapp.com",
	    databaseURL: "https://sos-ambulance.firebaseio.com",
	    projectId: "sos-ambulance",
	    storageBucket: "sos-ambulance.appspot.com",
	    messagingSenderId: "222333435740"
	  };
	  firebase.initializeApp(config);
	  <?php
	  	foreach ($data as $key => $value) { ?>
	  	writeUserData("<?=$value['ambulance_id']?>","<?=$value['ambulance_no']?>","<?=$value['ambulance_police']?>","<?=$value['ambulance_username']?>","<?=$value['ambulance_tracklatitude']?>","<?=$value['ambulance_tracklongitude']?>","<?=$value['ambulance_trackrotation']?>");
	  <?php	}
	  ?>

	  function writeUserData(ambulance_id, ambulance_no, ambulance_police, ambulance_username, ambulance_tracklatitude, ambulance_tracklongitude, ambulance_trackrotation) {
		  firebase.database().ref('ambulance/' + ambulance_id).set({
		  	ambulance_notifikasi: 0,
		    ambulance_id: ambulance_id,
		    ambulance_no: ambulance_no,
		    ambulance_police : ambulance_police,
		    ambulance_username: ambulance_username,
		    ambulance_tracklatitude: ambulance_tracklatitude,
		    ambulance_tracklongitude: ambulance_tracklongitude,
		    ambulance_trackrotation: ambulance_trackrotation
		  });
		}

	  // Get a reference to the database service
	  var database = firebase.database();
</script>
</body>
</html>