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
  <meta name="theme-color" content="#404040" />
  <link rel="icon" type="image/png" href="images/icon.png" sizes="32x32">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>

  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/meanmenu.css">
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
  <title>Race Listings</title>
</head>
<body>
  <?php
    include('includes/modals.php');
    include('includes/navbar.php');
    if(isset($_SESSION['userSession'])){
      require_once('race-cart.php');
    }
  ?>

  <div class="container well-custom">
    <div class="jumbotron">
      <h1>RACE LISTINGS</h1>
    </div>
      <form action="sort-races.php" method="post">
        <div class="row form-group">
            <div class="col-md-3">
              <label for="sel2">Sort By:</label>
              <select name="sortBy" class="form-control">
                <option value="">No Filter</option>
                <option value="MTB">MTB Races</option>
                <option value="Road">Road Races</option>
                <option value="RaceDate">Start Date</option>
                <option value="ClosingEntryDate">Closing Entry Date</option>
              </select>
            </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <input type="submit" name="sortBtn" onclick="submitForm('insert-race-sign-up.php', 'post')"
            id="button" value="Update" class="modal-btn listing">
          </div>
        </form>
          <div class="col-md-6"></div>
          <div class="col-md-3">
            <form action="add-race.php" method="post">
              <div class="form-group">
                <input type="submit" value="ADD YOUR EVENT" class="modal-btn listing add-event" id="add-event">
              </div>
            </form>
          </div>
        </div>
      <div class="row" style="margin-bottom: 0; padding-bottom: 0;">
        <div id="search" class="col-xs-4 col-sm-4 col-md-13">
          <form role="form" method="post">
            <label class="search-heading">Search race name or race type (MTB or Road)</label>
            <div class="">
              <div class="cmn-t-underline">
                <input type="text" id="searchTerm" name="searchTerm" class="search-races cmn-t-underline" placeholder="Race Name" autocomplete="off"></input>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <ul id="content"></ul>
          <div id="prepare-results">
            <?php
            while($eventRow = $eventQuery->fetchObject()){
              $queryString =  'race-sign-up.php?RaceID=' . $eventRow->RaceID;
              $temp = strtotime($eventRow->RaceDate);
              $startDate = date("d F", $temp);

              $temp = strtotime($eventRow->ClosingEntryDate);
              $closeDate = date("d F", $temp);
              echo "<div class='race-listing' id='prepare-results'>";
              $queryString = 'race-sign-up.php?RaceID=' . $eventRow->RaceID;

              echo "<h3><strong><a class='non-nav' href='" . $queryString . "'>{$eventRow->RaceName}</strong> | <small>{$eventRow->RaceAddress}</small></h3></a>";
              echo "<p class='race-listing-details'>{$eventRow->OrganiserName} - Race Date $startDate - Entries Close $closeDate</p>";
              echo "<hr />";
              echo "</div>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  <?php include('includes/footer.php'); ?>

  <!-- <div class='race-listing'>
    <h3><strong><a class='non-nav' href='race-sign-up.php?RaceID=1'>Parkwood Loop</strong> |
      <small>120 Shirecliffe Road, Sheffield</small></h3></a>
      <p class='race-listing-details'>Sheffield MTB - Race Date 29 March - Entries Close 22 March</p>
      <hr />
  </div> -->

</body>
</html>
