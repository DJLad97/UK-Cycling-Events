<?php
  require('includes/conn.inc.php');
  //This is so I can redirect to this page after a login
  $_SESSION['url'] = $_SERVER['REQUEST_URI'];

  $userID = $_SESSION['userSession'];
  if(!isset($_SESSION['userSession']))
  {
      header("Location: log-in.php");
  }

  $raceID = $_GET['RaceID'];
  $sql = "SELECT * FROM races WHERE RaceID = :raceID";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetchObject();

  $_SESSION['getRaceID'] = $raceID;

  $userSignedUp = "SELECT RaceID FROM racesignup WHERE UserID = :userID";
  $signUps = $pdo->prepare($userSignedUp);
  $signUps->bindParam(':userID', $userID, PDO::PARAM_INT);
  $signUps->execute();
  $signUpIDs = array();
  while($row = $signUps->fetchObject()){
    $signUpIDs[] = $row->RaceID;
  }
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
  <script src="js/main.js"></script>
  <script src="js/race-location.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <title>Race Sign Up</title>
</head>
<body>
  <div class="container well">

  <div style="padding-left: 30px; padding-right: 30px;">
      <div class="page-header">
        <h2>SIGN UP</h2>
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
        // If user hasn't signed up to the race that is currently been displayed
        // then display sign up details, otherwise inform you've signed up to this race
        if(!in_array($_GET['RaceID'], $signUpIDs)) {

          ?>

        <form method="post" action="insert-race-sign-up.php">
          <div class=" form-group">
            <label for="sel1">Gender:</label>
            <label class="radio-inline"><input type="radio" name="gender" checked="checked" value="M">Male</label>
            <label class="radio-inline"><input type="radio" name="gender" value="F">Female</label>
          </div>
          <div class="form-group">
            <!-- <div class="col-xs-4 col-sm-2 col-md-2"></div> -->
            <label for="sel2">Your Age Range:</label>
            <select name="ageRange" id="sel3" class="form-control">
              <option value="14-17">14-17</option>
              <option value="18-39">18-39</option>
              <option value="40+">40+</option>
            </select>
          </div>

          <div class="form-group">
            <?php
            if($result->EntryPrice == NULL) {
              ?>
              <label>Free Entry!</label>
              <br>

              <input type="submit" name="subBtn" id="button" value="Go Race!" class="btn btn-primary btn-default">
              <?php
            }
            else{
              ?>
              <p>
                <label>Price: </label>
                <?php echo "£{$result->EntryPrice}" ?>
              </p>
              <input type="submit" name="subBtn" id="button" value="Add to Cart" class="btn btn-primary btn-default">
              <?php
            }
            ?>

          </div>
        </form>
      </div>
      <?php
      } else{

      ?>
        <h2>You've already signed up to this race</h2>
      <?php } ?>
      <div id="map"></div>
    </div>
  </div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh5LqX12YrJlbySaXrwof1R7XcAURBK1M&callback=raceLocation"></script>
</body>
</html>
