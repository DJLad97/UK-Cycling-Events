<!--  Add some warning color to indicate that the closing entry date is coming up -->

<?php
  require('../includes/conn.inc.php');
  require('check-user.php');

  $raceID = $_GET['RaceID'];
  $sql = "SELECT * FROM races WHERE RaceID = :raceID";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetchObject();
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

  <link rel="stylesheet" href="../css/CMS-style.css">
  <script src="js/main.js"></script>
  <script src="js/race-location.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>VIEW <?php echo $result->RaceName; ?></title>
</head>
<body>
  <?php include('header.php'); ?>
  <div class="container well">
  <div style="padding-left: 20px; padding-right: 20px;">
      <div class="page-header">
        <h2>VIEW RACE</h2>
      </div>
      <div class="row">
        <!-- <div class="col-xs-4 col-sm-2 col-md-2"></div> -->
        <!-- <div class="col-xs-4 col-sm-4 col-md-4 colCenterText"> -->
        <?php

          echo "<h1>{$result->RaceName}</h1>";
          echo "<p>
          Race Type: {$result->RaceType}
          <br />
          Start Date: {$result->RaceDate}
          <br />
          Entry Closing Date: {$result->ClosingEntryDate}
          <br / >
          Organiser Name: {$result->OrganiserName}
          <br />
          Organiser Email: {$result->OrganiserEmail}
          </p>";

        ?>
        <!-- </div> -->
        <!-- <div class="col-xs-8 col-sm-4 col-md-4 colCenterText"> -->
        <!-- <p class="RaceDesc centerDesc"> -->
        <p>
          <?php
          echo "{$result->RaceDescription}";
          ?>
        </p>
        <!-- </div> -->
      </div>

      <div class="row">
        <!-- <div class="col-xs-4 col-sm-2 col-md-2"></div> -->

          <?php
          if($result->EntryPrice == NULL) {
            ?>
            <label>No Entry Fee</label>
            <?php
          }
          else{
            ?>
            <p>
              <label>Price: </label>
              <?php
              echo "£{$result->EntryPrice}";
              ?>
              </p>
          <?php } ?>
      </div>
      <div id="map"></div>
    </div>
  </div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh5LqX12YrJlbySaXrwof1R7XcAURBK1M&callback=raceLocation"></script>
</body>
</html>
