<?php
  require('includes/conn.inc.php');
  require_once('includes/functions.inc.php');
  if(!isset($_SESSION['userSession'])){
    header('Location: index.php?er=notLoggedIn');
  }
  $userID = $_SESSION['userSession'];

  $userQuery = "SELECT UserID, Forename, Surname FROM user WHERE UserID = :userID";
  $userStmt = $user->runQuery($userQuery);
  $userStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
  $userStmt->execute();

  $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);

  $nameFromUser = $userRow['Forename'] . " " . $userRow['Surname'];

  $raceID = $_SESSION['getRaceID'];
  $userID = $userRow['UserID'];
  $name = $nameFromUser;

  if(!isset($_POST['checkout'])){
    $gender = $_POST['gender'];
    $ageRange = $_POST['ageRange'];
  }

  if(isset($_POST['checkout'])){
    $sql = $_POST['sqlQuery'];
  }
  else {
    $sql = "INSERT INTO RaceSignUp (RaceID, UserID, Name, Gender, AgeRange)
            VALUES (:raceID, :userID, :name, :gender, :ageRange)";
  }

  //echo $sql;
  $stmt = $pdo->prepare($sql);
  if(!isset($_POST['checkout'])){
    $stmt->bindParam(":raceID", $raceID, PDO::PARAM_INT);
    $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":gender", $gender, PDO::PARAM_STR);
    $stmt->bindParam(":ageRange", $ageRange, PDO::PARAM_STR);
  }

  $stmt->execute();

  unset($_SESSION['cart']);
  header("Location: index.php");

  exit;
?>
