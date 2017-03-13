<?php
    require('includes/conn.inc.php');

    $userID = $_SESSION['userSession'];
    if(!isset($_SESSION['userSession']))
    {
        header("Location: index.php?notLoggedIn=true");
    }
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    $userQuery = "SELECT * FROM user WHERE userID = :userID";
    // Maybe change this to normal prepare...?
    $stmt = $user->runQuery($userQuery);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $userRow = $stmt->fetch();

    $imgQuery = "SELECT ProfileImg FROM user WHERE userID = :userID";
    $imgStmt = $pdo->prepare($imgQuery);
    $imgStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $imgStmt->execute();
    $imgRow = $imgStmt->fetch();
    //$racesQuery = "SELECT RaceID FROM racesignup WHERE UserID = :userID";
    $racesQuery = "SELECT * FROM races LEFT JOIN racesignup on races.RaceID = racesignup.RaceID WHERE racesignup.UserID = :userID";
    $raceStmt = $pdo->prepare($racesQuery);
    $raceStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $raceStmt->execute();
    //$raceRow = $raceStmt->fetchObject();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="theme-color" content="#404040" />
  <link rel="icon" type="image/png" href="images/icon.png" sizes="32x32">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/meanmenu.css">
  <script src="js/main.js"></script>
  <script src="js/jquery.easing.js"></script>
  <script src="js/live-race-search.js"></script>
  <script src="js/jquery.meanmenu.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>Profile</title>


</head>
<body>
  <?php
  include('includes/navbar.php');
  if(isset($_SESSION['userSession'])){
    require_once('race-cart.php');
  }

  ?>

  <div class="container well-custom">
    <div class="profile-header page-header">
      <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4"></div>
        <div class="col-xs-4 col-sm-4 col-md-4">
          <img src="images/<?php
          $default = 'default.jpg';
          if(isset($imgRow['ProfileImg'])) echo $imgRow['ProfileImg'];
          else echo $default
          ?>"class="img" alt="profile image">
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4"></div>
      </div>
    </div>
      <h1 id="welcome" class="big">MY PROFILE</h1>
      <h1>
        <?php
        echo "Hello, " . $userRow['Forename'] . " " . $userRow['Surname'];
        ?>
      </h1>
      <div class="details-section">
        <h3><strong><a class="non-nav races" href="#">Your upcoming races <i class="fa fa-angle-down" aria-hidden="true"></i></a></strong></h3>
        <div id="user-races" class="reveal-details">
          <br>
          <?php
          if($raceRow == 0){
            echo "<h2>NO UPCOMING RACES</h2>";
          }
          while($raceRow = $raceStmt->fetchObject())
          {
            $queryString =  'race-sign-up.php?RaceID=' . $raceRow->RaceID;
            $temp = strtotime($raceRow->RaceDate);
            $startDate = date("d F", $temp);

            $temp = strtotime($raceRow->ClosingEntryDate);
            $closeDate = date("d F", $temp);
            echo "<div class='race-listing'>";
            $queryString = 'race-sign-up.php?RaceID=' . $raceRow->RaceID;

            echo "<h3><strong><a class='non-nav' href='" . $queryString . "'>{$raceRow->RaceName}</strong> | <small>{$raceRow->RaceAddress}</small></h3></a>";
            echo "<p class='race-listing-details'>{$raceRow->OrganiserName} - Race Date $startDate - Entries Close $closeDate</p>";
            echo "</div>";
            echo "<hr />";
          }

          ?>
        </div>
        <h3><strong><a class="non-nav profile" href="#">Profile Details <i class="fa fa-angle-down" aria-hidden="true"></i></a></strong></h3>

        <div id="profile-customize" class="reveal-details">
          <form action="upload-img.php" enctype="multipart/form-data" method="post">
            <label for="">Change profile image</label>
            <input type="file" name="profileImg" id="profileImg" />
            <br />
            <?php
            if(!empty($_GET)){
              switch($_GET['err']){
                case 'WrongFileType':
                echo '<p class="error-text">Only .png .jpg, .gif allowed</p>';
                break;
                case 'imgUploadError':
                echo '<p class="error-text">Something went wrong with the upload</p>';
                break;

              }
            }
            ?>
            <input type="submit" name="upload" value="Save" class="modal-btn listing"/>
          </form>
        </div>
      </div>


  </div>

  <?php include('includes/footer.php'); ?>

</body>
</html>
