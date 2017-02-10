<?php
require('includes/conn.inc.php');

$_SESSION['url'] = $_SERVER['REQUEST_URI'];

$event = "SELECT * FROM races";

$mtbEvent = "SELECT * FROM races
              WHERE RaceType = 'MTB'";

$roadEvent = "SELECT * FROM races
              WHERE RaceType = 'Road'";


if(isset($_SESSION['event'])){
  $eventQuery = $pdo->prepare($_SESSION['event']);
}
else {
  $eventQuery = $pdo->prepare($event);

}
$eventQuery->execute();

$mtbQuery = $pdo->prepare($mtbEvent);
$mtbQuery->execute();
$resultMtbRow = $mtbQuery->fetchObject();

$roadQuery = $pdo->prepare($roadEvent);
$roadQuery->execute();
$resultRoadRow = $roadQuery->fetchObject();
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
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>

  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/meanmenu.css">
  <link rel="stylesheet" href="css/animate.css">
  <script src="js/main.js"></script>
  <script src="js/jquery.easing.js"></script>
  <script src="js/live-race-search.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/index-map.js"></script>
  <script src="js/user-validation.js"></script>
  <script src="js/jquery.meanmenu.js"></script>



  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <title>Document</title>
</head>
<body>
  <?php include('includes/modals.php'); ?>
  <?php include('includes/navbar.php'); ?>
  <div class="container well-custom-listing">
    <div class="jumbotron">
      <h1>RACE LISTINGS</h1>
    </div>
    <form action="sort-races.php" method="post">
      <div class="form-group">
        <!-- <div class="col-xs-4 col-sm-2 col-md-2"></div> -->
        <label for="sel2">Sort By:</label>
        <select name="sortBy" class="form-control">
          <option value="">-Select-</option>
          <option value="MTB">MTB Races</option>
          <option value="Road">Road Races</option>
          <option value="RaceDate">Start Date</option>
          <option value="ClosingEntryDate">Closing Entry Date</option>
        </select>
      </div>
      <input type="submit" name="sortBtn" onclick="submitForm('insert-race-sign-up.php', 'post')"
              id="button" value="Update" class="modal-btn listing">
    </form>
      <div class="row">
        <div class="col-md-12">
          <?php
          while($eventRow = $eventQuery->fetchObject()){
            $queryString =  'race-sign-up.php?RaceID=' . $eventRow->RaceID;
            $temp = strtotime($eventRow->RaceDate);
            $startDate = date("d F", $temp);

            $temp = strtotime($eventRow->ClosingEntryDate);
            $closeDate = date("d F", $temp);
            echo "<div class='race-listing'>";
            $queryString = 'race-sign-up.php?RaceID=' . $eventRow->RaceID;
              // echo "<p><a href=\"race-sign-up.php?RaceID={$resultMtbRow->RaceID}\" class=\"regBtn\">REGISTER</a></p>";
            echo "<h3><strong><a class='non-nav' href='" . $queryString . "'>{$eventRow->RaceName}</strong> | <small>{$eventRow->RaceAddress}</small></h3></a>";

            echo "<p class='race-listing-details'>{$eventRow->OrganiserName} - Race Date $startDate - Entries Close $closeDate</p>";
            echo "</div>";
            echo "<hr />";
          }

          ?>

        </div>
    </div>
  </div>

</body>
</html>
