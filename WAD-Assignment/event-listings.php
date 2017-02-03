<?php
  require('includes/conn.inc.php');

  // IF THE MAP DOESN'T SHOW UP THIS IS WHAT I DID TO FIX IT:
  /*
        In the src for the race map I put a "../" before to see if that would work
        it didn't, so I put it back and refreshed and it worked
        Maybe it was the ctrl-f5 that did it but just in case
  */
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/animate.css">
  <script src="js/main.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/jquery.easing.js"></script>
  <script src="js/race-map.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <title>Event Listings</title>
</head>
<body>
  <div class="container">

    <h1>MAP</h1>
    <div id="map"></div>

  </div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh5LqX12YrJlbySaXrwof1R7XcAURBK1M&callback=raceMap"></script>
</body>
</html>
