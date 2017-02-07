<!--
- Have so html elements fade in when the page loads
- Do I actually need the isFree column in my races table?
- Add something to event listings page where it will say there is no upcoming races if there is no upcoming races
- Set the user session to quit after a certain amount of time
- Do a reset password feature
- Add a feature for the admin to print off a page containg the race sign up details
  (Or send a email to the event organiser containing the page of sign ups for them to print off,
  this email will get sent when the closing entry date has come)
- Add a view preview details to live search for each race
  - Add information about the add your event feature like that we will email you the sign ups
  when the closing entry date has arrived or an option to get emails daily
  - PREVENT THE USER FROM DIRECTLY ACCESSING PURE PHP SCRIPTS
  (http://stackoverflow.com/questions/409496/prevent-direct-access-to-a-php-include-file)
  -HAVE SOME SORT OF CONSTANT SIDE BAR SUCH AS SHOWING 5 RACES OR SO
  -CONFIGUE XAMPP ON SURFACE TO SET UP EMAILS
  -Race route with google maps polyline
  -Results page for each race
  -Website with 2 halves
-->
<?php
  require('includes/conn.inc.php');

  if(isset($_SESSION['userSession']))
  {
      echo "user session started";
  }
  else
  {
      echo "no user session";
  }

  if(isset($_SESSION['userSession']))
  {
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
                 WHERE RaceType = 'MTB' AND RaceDate > NOW() LIMIT 5";


  $roadUpcoming = "SELECT RaceID, RaceName, RaceDate, ClosingEntryDate FROM races
                  WHERE RaceType = 'Road' AND RaceDate > NOW() LIMIT 5";

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

  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/animate.css">
  <script src="js/main.js"></script>
  <script src="js/jquery.easing.js"></script>
  <script src="js/live-race-search.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>Home1</title>


</head>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <!-- <img src="images/navbar-image.png" id="navButton" alt="nav button"> -->
        <ul class="removeLeft nav navbar-nav navbar-left">
          <li class="dropdown"><a href="#">MTB & ROAD</a></li>
          <?php if(isset($_SESSION['userSession']) && $userRow['IsAdmin'] == 'admin'){ ?>
          <li class="dropdown"><a href="CMS/CMS.php">CMS Page</a></li>
          <?php }?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php
              if(isset($_SESSION['userSession']))
              {

          ?>
          <li><a href="profile.php"><?php echo $userRow['Username'] ?></a></li>
          <li><a href="log-out.php">LOG OUT</a></li>

          <?php
              }
              else
              {
          ?>
          <li><a href="log-in.php">SIGN IN</a></li>
          <li><a href="sign-up.php">SIGN UP</a></li>
          <?php } ?>
          <li><a href="#">CART</a></li>
        </ul>

    </div>
    <div id="fullDropdown">
      <ul class="nav navbar-left nav-stacked">
        <li class="dropdown"><a href="#">RACES</a></li>
        <li><a href="#">MAP</a></li>
        <li><a href="#">CALANDER</a></li>
      </ul>
      <ul class="nav navbar-right subnav">
        <li><a href="#">PROFILE</a></li>
        <li><a href="#">MY RACES</a></li>
        <li><a href="#">log-out</a></li>
      </ul>
    </div>
  </div>
</nav>

  <div id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for Slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="fill" style="background-image:url('images/mtb2.2.jpg');"></div>
            <div class="carousel-caption text-center">
              <div class="full-width text-center">
                <?php
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

                <h3>SEE MORE EVENTS BELOW</h3>
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
                <div id="seeMoreBtn"><i class="fa fa-angle-double-down fa-4x" aria-hidden="true"></i></div>
              </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    </a>
</div>

<div class="container">
  <div id="calander">
    <div id="btnAddEvent">
      <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4"></div>
        <div class="col-xs-4 col-sm-4 col-md-4">
          <a href="add-race.php"><input type="submit" value="ADD YOUR EVENT" class="btn btn-lg btn-primary"></a>
          <a href="event-listings.php"><input type="submit" value="EVENT LISTINGS" class="btn btn-lg btn-primary" style="margin: 10px;"></a>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-3 col-sm-3 col-md-3"></div>
      <div class="col-xs-3 col-sm-3 col-md-3">
        <h1>MTB RACES</h1>
        <hr />
        <?php
        while($mtbUpcomingRow = $upcomingQueryMtb->fetchObject())
        {
          $linkAddress = 'race-sign-up.php?RaceID=' . $mtbUpcomingRow->RaceID;
          echo "<a href='".$linkAddress."' target='_blank'><h3>{$mtbUpcomingRow->RaceName}</h3></a>";
          echo "<small>Start Date: {$mtbUpcomingRow->RaceDate}</small><br />";
          echo "<small>ClosingEntryDate: {$mtbUpcomingRow->ClosingEntryDate}</small>";
        }
        ?>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3">
        <h1>ROAD RACES</h1>
        <hr />
        <?php
        while($roadUpcomingRow = $upcomingQueryRoad->fetchObject())
        {
          $linkAddress = 'race-sign-up.php?RaceID=' . $roadUpcomingRow->RaceID;
          echo "<a href='".$linkAddress."' target='_blank'><h3>{$roadUpcomingRow->RaceName}</h3></a>";
          echo "<small>Start Date: {$roadUpcomingRow->RaceDate}</small><br />";
          echo "<small>ClosingEntryDate: {$roadUpcomingRow->ClosingEntryDate}</small>";
        }
        ?>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3"></div>

    </div>

  </div>
  <form role="form" method="post">
    <label>Search race name or race type (MTB or Road)</label>
    <div class="input-group input-group-lg col-xs-3">
      <input type="text" id="searchTerm" name="searchTerm" class="form-control" placeholder="Race Name" autocomplete="off"></input>
      <div class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>
  </form>
  <ul id="content"></ul>
</div>

<footer style="background-color: #000000; margin-top: 20vh;">
  <div class="container-fluid">
    <p>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium minima amet quia hic adipisci expedita iusto, voluptatum ducimus praesentium, suscipit non. Esse, illum explicabo voluptatem. Sed velit, magni id nemo!
    </p>

    <p>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium minima amet quia hic adipisci expedita iusto, voluptatum ducimus praesentium, suscipit non. Esse, illum explicabo voluptatem. Sed velit, magni id nemo!
    </p>
    <p>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium minima amet quia hic adipisci expedita iusto, voluptatum ducimus praesentium, suscipit non. Esse, illum explicabo voluptatem. Sed velit, magni id nemo!
    </p>
  </div>
</footer>


</body>
</html>
