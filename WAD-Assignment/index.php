<?php
  require('includes/conn.inc.php');
  $_SESSION['url'] = $_SERVER['REQUEST_URI'];

  if(isset($_SESSION['userSession']))
  {
      $userLoggedIn = "true";
      $userID = $_SESSION['userSession'];

      $userQuery = "SELECT * FROM user WHERE userID = :userID";
      $stmt = $user->runQuery($userQuery);
      $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
      $stmt->execute();
      $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

  }


  $mtbEvent = "SELECT RaceID, RaceName, ClosingEntryDate FROM races
                WHERE RaceType = 'MTB' AND ClosingEntryDate > NOW() LIMIT 1";

  $mtbUpcoming = "SELECT RaceID, RaceName, RaceDate, ClosingEntryDate FROM races
                 WHERE RaceType = 'MTB' AND RaceDate > NOW() ORDER BY RaceDate LIMIT 5";


  $roadUpcoming = "SELECT RaceID, RaceName, RaceDate, ClosingEntryDate FROM races
                  WHERE RaceType = 'Road' AND RaceDate > NOW() ORDER BY RaceDate LIMIT 5";

  $roadEvent = "SELECT RaceID, RaceName, ClosingEntryDate FROM races
                WHERE RaceType = 'Road' AND ClosingEntryDate > NOW() LIMIT 1";

  // $mtbQuery = $pdo->prepare($mtbEvent);
  // $mtbQuery->execute();
  // $resultMtbRow = $mtbQuery->fetchObject();

  $mtbQuery = $pdo->prepare($mtbEvent);
  $mtbQuery->execute();
  $resultMtbRow = $mtbQuery->fetchObject();

  $upcomingQueryMtb = $pdo->prepare($mtbUpcoming);
  $upcomingQueryMtb->execute();
  // $mtbUpcomingRow = $upcomingQueryMtb->fetchObject();

  $upcomingQueryRoad = $pdo->prepare($roadUpcoming);
  $upcomingQueryRoad->execute();
  //$roadUpcomingRow = $upcomingQueryRoad->fetchObject();

  $roadQuery = $pdo->prepare($roadEvent);
  $roadQuery->execute();
  $resultRoadRow = $roadQuery->fetchObject();

  if(isset($_SESSION['userSession'])){
    require_once('race-cart.php');
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

  <title>Home1</title>




</head>
<body>
  <?php

      include('includes/modals.php');
      include('includes/navbar.php');
  ?>
   <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>

    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="fill" style="background-image:url('images/mtb2.2.jpg');"></div>
            <div class="carousel-caption text-center">
              <div class="full-width text-center">
                <?php
                  $openModal = 'onclick="document.getElementById("login-modal").style.display="block"';
                  if($mtbQuery->rowCount() > 0){

                    echo "<h1>
                    {$resultMtbRow->RaceName}<br />
                    {$resultMtbRow->ClosingEntryDate}
                    </h1>";
                    echo "<p><a href=\"race-sign-up.php?RaceID={$resultMtbRow->RaceID}\" class=\"regBtn\">REGISTER</a></p>";
                  }
                  else{
                    echo "<h1>NO UPCOMING RACES</h1>";

                  }

                 ?>
                <h3 class="see-more">SEE MORE EVENTS BELOW</h3>
                <div class="moveDownBtn">
                    <i class="fa fa-angle-double-down fa-4x" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="fill" style="background-image:url('images/road2.2.jpg');"></div>
            <div class="carousel-caption text-center">
              <div class="full-width text-center">
                <?php
                if($roadQuery->rowCount() > 0){
                  echo "<h1>
                  {$resultRoadRow->RaceName}<br />
                  {$resultRoadRow->ClosingEntryDate}
                  </h1>";
                  echo "<p><a href=\"race-sign-up.php?RaceID={$resultRoadRow->RaceID}\" class=\"regBtn\">REGISTER</a></p>";

                }
                else{
                  echo "<h1>NO UPCOMING RACES</h1>";
                }

                 ?>
                <h3>SEE MORE EVENTS BELOW</h3>
                <div class="moveDownBtn">
                    <i class="fa fa-angle-double-down fa-4x" aria-hidden="true"></i></div>
                </div>
              </div>
            </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-xs-4 col-sm-4 "></div>
              <div id="search" class="col-xs-4 col-sm-4 col-md-13 fade-in">
                <form role="form" method="post">
                  <label class="search-heading">Search race name or race type (MTB or Road)</label>
                  <div class="search-div">
                    <div class="cmn-t-underline">
                      <input type="text" id="searchTerm" name="searchTerm" class="search-races cmn-t-underline" placeholder="Race Name" autocomplete="off"></input>
                    </div>
                </div>
              </form>
              <ul id="content"></ul>
            </div>
            <div class="col-xs-4 col-sm-4"></div>
          </div>
        </div>

    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    </a>
</div>

<div class="container">
</div>

<div id="upcoming-races" class="fade-in">
  <div class="row">
    <div class="col-md-4"></div>
    <h1 class="big col-xs-12 col-sm-12 col-md-4" id="upcoming-races-header">UPCOMING RACES</h1>
    <div class="col-md-4"></div>
  </div>
  <div class="im-centered">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-xs-12 col-sm-12 col-md-4" id="mtb-table">
        <h1 class="big">MTB RACES</h1>
        <?php
          while($mtbUpcomingRow = $upcomingQueryMtb->fetchObject())
          {
            $temp = strtotime($mtbUpcomingRow->RaceDate);
            $temp2 = strtotime($mtbUpcomingRow->ClosingEntryDate);
            $day = date("d", $temp);
            $month = date("M", $temp);
            $closeDay = date("d", $temp2);
            $closeMonth = date("M", $temp2);
            echo "<div class='event-box'>";
            $linkAddress = 'race-sign-up.php?RaceID=' . $mtbUpcomingRow->RaceID;
            echo "<span class='race-day'><strong>" . $day . "</strong><em>$month</em></span>";
            echo "<span class='close-date '>Entries Close: $closeDay $closeMonth</span>";
            echo "<a class='non-nav' href='".$linkAddress."' target='_blank'><h3 class='race-name'><strong>{$mtbUpcomingRow->RaceName}</strong></h3></a>";;
            echo "</div>";
          }
        ?>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4" id="road-table">
        <div class="spacing"><p></p></div>
        <h1 class="big">ROAD RACES</h1>
        <?php
          while($roadUpcomingRow = $upcomingQueryRoad->fetchObject())
          {
            $temp = strtotime($roadUpcomingRow->RaceDate);
            $temp2 = strtotime($roadUpcomingRow->ClosingEntryDate);
            $day = date("d", $temp);
            $month = date("M", $temp);
            $closeDay = date("d", $temp2);
            $closeMonth = date("M", $temp2);
            echo "<div class='event-box'>";
            $linkAddress = 'race-sign-up.php?RaceID=' . $roadUpcomingRow->RaceID;
            echo "<span class='race-day'><strong>" . $day . "</strong><em>$month</em></span>";
            echo "<span class='close-date '>Entries Close: $closeDay $closeMonth</span>";
            echo "<a class='non-nav' href='".$linkAddress."' target='_blank'><h3 class='race-name'><strong>{$roadUpcomingRow->RaceName}</strong></h3></a>";

            echo "</div>";
          }
        ?>
      </div>
      <div class="col-md-2"></div>

    </div>
  </div>
  </div>

<div class="container fade-in">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
      <div id="mtbMap"></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
      <div id="roadMap"></div>
    </div>
  </div>
</div>


<?php
  include('includes/footer.php');
  if(!empty($_GET['er'])){
    ?>
    <script>
      document.getElementById('login-modal').style.display='block';
    </script>
    <?php
  }
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh5LqX12YrJlbySaXrwof1R7XcAURBK1M&callback=mtbMap"></script>
</body>
</html>
