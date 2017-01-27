<?php
  require('includes/conn.inc.php');
  require_once('includes/functions.inc.php');

  $userID = $_SESSION['userSession'];

  echo $_SESSION['userSession'];

  $userQuery = "SELECT UserID, Forename, Surname FROM user WHERE UserID = :userID";
  $userStmt = $user->runQuery($userQuery);
  $userStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
  $userStmt->execute();

  $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);

  $nameFromUser = $userRow['Forename'] . " " . $userRow['Surname'];

  $raceID = $_SESSION['getRaceID'];
  $userID = $userRow['UserID'];
  $name = $nameFromUser;
  $gender = $_POST['gender'];
  $ageRange = $_POST['ageRange'];

  $sql = "INSERT INTO RaceSignUp (RaceID, UserID, Name, Gender, AgeRange)
          VALUES (:raceID, :userID, :name, :gender, :ageRange)";


  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":raceID", $raceID, PDO::PARAM_INT);
  $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
  $stmt->bindParam(":name", $name, PDO::PARAM_STR);
  $stmt->bindParam(":gender", $gender, PDO::PARAM_STR);
  $stmt->bindParam(":ageRange", $ageRange, PDO::PARAM_STR);
  $stmt->execute();

  header("Location: index.php");

  exit;
?>
