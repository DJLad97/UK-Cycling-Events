<?php
    require('includes/conn.inc.php');

    $userID = $_SESSION['userSession'];

    $userQuery = "SELECT * FROM user WHERE userID = :userID";
    $stmt = $user->runQuery($userQuery);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/styles.css">
  <script src="js/main.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>Home</title>


</head>
<body>

  <div class="container">
    <div class="profile-header page-header">
      <div class="row">
        <div class="col-md-7">
          <h1 id="welcome">MY PROFILE</h1>
          <h2>
            <a href="index.php" style="text-decoration: none">
              <?php
              echo "Hello " . $userRow['Forename'] . " " . $userRow['Surname'];
              ?>
            </a>
          </h2>
          <div class="user-races">
            <h3>Your upcoming races</h3>
              <?php
              while($raceRow = $raceStmt->fetchObject())
              {
                  echo "<p><strong>{$raceRow->RaceName}</strong></p>";
                  echo "<p>{$raceRow->RaceDate}</p>";
                  echo "<br />";
              }

              ?>
          </div>
        </div>
          <div class="profile-img col-md-5">
            <img src="images/default.jpg" class="img" alt="profile image" width="400" height="400">
            <form action="upload-img.php" method="post" enctype="multipart/form-data">
              Select image to upload:
              <input type="file" name="file" id="fileToUpload" />
              <br />
              <input type="submit" name="upload" value="Save" />
            </form>
          </div>
        </div>
    </div>


  </div>


</body>
</html>
