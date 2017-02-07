<!--  Add some warning color to indicate that the closing entry date is coming up -->

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

  $postURL = ($result->EntryPrice == NULL ? 'insert-race-sign-up.php' : 'add-to-cart.php');

  $_SESSION['getRaceID'] = $raceID;

  $userSignedUp = "SELECT RaceID FROM racesignup WHERE UserID = :userID";
  $signUps = $pdo->prepare($userSignedUp);
  $signUps->bindParam(':userID', $userID, PDO::PARAM_INT);
  $signUps->execute();
  $signUpIDs = array();
  while($row = $signUps->fetchObject()){
    $signUpIDs[] = $row->RaceID;
  }

  $commentSQL = "SELECT * FROM comment";
  $commentStmt = $pdo->prepare($commentSQL);
  $commentStmt->execute();
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
  <!-- PUT THIS CODE IN AN EXTERNAL FILE -->
  <script>
    function submitForm(action, method){
      document.getElementById('raceForm').action = action;
      document.getElementById('raceForm').method = method;
      document.getElementById('raceForm').submit();
    }
  </script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <title>Race Sign Up</title>
</head>
<body>
  <div class="container">
    <div class="well">

    <div style="padding-left: 30px; padding-right: 30px;">
      <?php
      if(isset($result->RaceID)){

      ?>
        <div class="page-header">
          <h2>SIGN UP</h2>
        </div>
        <div class="row">
          <!-- <div class="col-xs-4 col-sm-2 col-md-2"></div> -->
          <!-- <div class="col-xs-4 col-sm-4 col-md-4 colCenterText"> -->
          <?php

            $temp = strtotime($result->ClosingEntryDate);
            $closeDate = date($temp);
            $now = time();

            $dateDiff = $closeDate - $now;

            $daysBeforeClose = floor ($dateDiff / 86400);
            $warningType;

            if($daysBeforeClose > 7)
              $warningType = 'alert alert-success';
            else if($daysBeforeClose <= 7 && $daysBeforeClose > 1)
              $warningType = 'alert alert-warning';
            else if($daysBeforeClose <= 1)
              $warningType = 'alert alert-danger';

            $span = '<span class="' . $warningType . '">';

            echo "<h1>{$result->RaceName}</h1>";
            echo "<p>
            Race Type: {$result->RaceType}
            <br />
            Start Date: {$result->RaceDate}
            <br /><br />";
            echo $span . "Entry Closing Date: {$result->ClosingEntryDate}</span>
            </p><br />";


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

          <form method="" action="" id="raceForm">
            <input type="hidden" name="RaceID" value="<?php echo $raceID?>" />
            <input type="hidden" name="RaceName" value="<?php echo $result->RaceName?>" />
            <input type="hidden" name="EntryPrice" value="<?php echo $result->EntryPrice?>" />
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

                <input type="submit" name="subBtn" onclick="submitForm('insert-race-sign-up.php', 'post')"
                        id="button" value="Go Race!" class="btn btn-primary btn-default">
                <?php
              }
              else{
                ?>
                <p>
                  <label>Price: </label>
                  <?php
                  echo "£{$result->EntryPrice}";
                  //print_r($_SESSION['cart']->cartArr);
                  //unset($_SESSION['cart']);
                  ?>
                  </p>
                  <?php
                    $found = false;

                    if(isset($_SESSION['cart'])){
                    for($i = 0; $i < $_SESSION['cart']->noOfItems; $i++){
                      if(in_array($raceID, $_SESSION['cart']->cartArr[$i])){
                        echo "<p>Race already in cart! </p>";
                        $found = true;
                      }
                    }
                  }
                  if(!$found){ ?>
                    <input type="submit" name="subBtn" onclick="submitForm('add-to-cart.php', 'get')"
                    id="button" value="Add to Cart" class="btn btn-primary btn-default">
                    <?php
                  }
              }
              ?>

            </div>
          </form>
        </div>
        <?php
        } else{

        ?>
          <h2>You've already signed up to this race</h2>
        <?php }
        }
        else {
          echo "<h1>SORRY, THIS RACE DOESN'T EXIST</h1>";
        } ?>
        <div id="map"></div>
      </div>
    </div>
  </div>
  <div class="container">
    <h2>COMMENTS</h2>
    <hr>
      <div class="row">
        <div class="col-md-4">

      <?php
      $i = 0;
       while($commentResult = $commentStmt->fetchObject()){
          ?>
          <div class="well">
            <button class="empty-button reply-text replyButton<?php echo $i;?>">Reply</button>
            <p><strong><?php echo $commentResult->Username; ?></strong></p>
            <p><?php echo $commentResult->CommentContent; ?></p>
              <form class="reply-form reply-form<?php echo $i; ?>" action="add-comment.php" method="post">
                <input type="hidden" name="raceID" value="<?php echo $commentResult->CommentID; ?>">
                <label>Reply to comment</label>
                <textarea type="comments" class="form-control" name="replyCommet"></textarea>
                <input type="submit" value="Reply" name="replyBtn" class="btn btn-primary"></input>
              </form>
          </div>
          <script>var commentCount = <?php echo(json_encode($i)); ?>;</script>
          <?php
          $i++;
      }
      ?>
        <form method="post" action="add-comment.php">
          <div class="form-group">
            <input type="hidden" name="raceID" value="<?php echo $raceID; ?>">
            <label>Leave a comment</label>
            <textarea type="comments" class="form-control" name="raceComment"></textarea>
          </div>
          <input type="submit" value="Post Comment" name="commentBtn" class="btn btn-primary"></input>
        <form>
      </div>
    </div>
    <footer></footer>
  </div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh5LqX12YrJlbySaXrwof1R7XcAURBK1M&callback=raceLocation"></script>
</body>
</html>
