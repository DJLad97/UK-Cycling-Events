<?php
require('includes/conn.inc.php');

$_SESSION['error'] = array();
$showError = false;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $raceType = $_POST['raceType'];
  $organiserName = filter_var(strip_tags(trim($_POST['organiserName'])), FILTER_SANITIZE_STRING);
  $organiserEmail = filter_var(strip_tags(trim($_POST['organiserEmail'])), FILTER_SANITIZE_STRING);
  $raceName = filter_var(strip_tags(trim($_POST['raceName'])), FILTER_SANITIZE_STRING);
  $startDate = filter_var(strip_tags(trim($_POST['raceStartDate'])), FILTER_SANITIZE_STRING);
  $closeDate = filter_var(strip_tags(trim($_POST['closingEntryDate'])), FILTER_SANITIZE_STRING);
  $address = filter_var(strip_tags(trim($_POST['raceAddress'])), FILTER_SANITIZE_STRING);
  $postCode = filter_var(strip_tags(trim($_POST['racePostcode'])), FILTER_SANITIZE_STRING);
  $loc = filter_var(strip_tags(trim($_POST['raceLatLong'])), FILTER_SANITIZE_STRING);
  if($_POST['isFree'] == 'Yes')
    $isFree = 1;
  else
    $isFree = 0;

  if($_POST['entryPrice'] == null)
    $entryPrice = NULL;
  else
    $entryPrice = filter_var(strip_tags(trim($_POST['entryPrice'])), FILTER_SANITIZE_STRING);

  $raceDesc = filter_var(strip_tags(trim($_POST['raceDesc'])), FILTER_SANITIZE_STRING);
  $newStartDate = date('Y-m-d', strtotime($startDate));
  $newCloseDate = date('Y-m-d', strtotime($closeDate));

  if(empty($raceType)){
      array_push($_SESSION['error'], "Please choose what type of race you have!");
      $showError = true;
  }
  if(empty($organiserName)){
      array_push($_SESSION['error'], "Please enter your organisation name!");
      $showError = true;
  }
  if(empty($raceName)){
      array_push($_SESSION['error'], "Please enter the name of your race!");
      $showError = true;
  }
  if(empty($organiserEmail)){
      array_push($_SESSION['error'], "Please enter an email address!");
      $showError = true;
  }
  if(empty($startDate)){
      array_push($_SESSION['error'], "Please enter the date your race starts!");
      $showError = true;
  }
  if(empty($closeDate)){
      array_push($_SESSION['error'], "Please enter the date in which enteries are no longer allowed after!");
      $showError = true;
  }
  if(empty($address)){
      array_push($_SESSION['error'], "Please enter the address of your race!");
      $showError = true;
  }
  if(empty($postCode)){
      array_push($_SESSION['error'], "Please enter the race postcode!");
      $showError = true;
  }
  if(empty($loc)){
      array_push($_SESSION['error'], "Please choose the latitude and longtitude on the map!");
      $showError = true;
  }
  if(empty($isFree)){
      array_push($_SESSION['error'], "Please specifiy if your race is free to enter or not!");
      $showError = true;
  }

  if($showError)
    header("Location: add-race.php");
}



  if($_GET['fromCMS'] == true){
      $sql = "UPDATE races SET RaceType = :raceType, OrganiserName = :orgName, OrganiserEmail = :orgEmail,
                               RaceName = :name, RaceDate = :sDate, RaceDescription = :raceDesc,
                               RaceAddress = :raceAdd, RacePostcode = :racePC, RaceLatLong = :raceLoc,
                               IsFree = :isFree, EntryPrice = :entryPrice, ClosingEntryDate
                               WHERE RaceID = :raceID;"
  }
  else{
      $sql = "INSERT INTO races (RaceType, OrganiserName, OrganiserEmail, RaceName, RaceDate, RaceDescription,
                                 RaceAddress, RacePostcode, RaceLatLong, IsFree, EntryPrice, ClosingEntryDate)
                          VALUES (:raceType, :orgName, :orgEmail, :name, :sDate, :raceDesc,
                                  :raceAdd, :racePC, :raceLoc, :isFree, :entryPrice, :cDate)";
  }

   $stmt = $pdo->prepare($sql);
   $stmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
   $stmt->bindParam(":raceType", $raceType, PDO::PARAM_STR);
   $stmt->bindParam(":orgName", $organiserName, PDO::PARAM_STR);
   $stmt->bindParam(":orgEmail", $organiserEmail, PDO::PARAM_STR);
   $stmt->bindParam(":name", $raceName, PDO::PARAM_STR);
   $stmt->bindParam(":sDate", $newStartDate, PDO::PARAM_STR);
   $stmt->bindParam(":raceDesc", $raceDesc, PDO::PARAM_STR);
   $stmt->bindParam(":raceAdd", $address, PDO::PARAM_STR);
   $stmt->bindParam(":racePC", $postCode, PDO::PARAM_STR);
   $stmt->bindParam(":raceLoc", $loc, PDO::PARAM_STR);
   $stmt->bindParam(":isFree", $isFree, PDO::PARAM_STR);
   $stmt->bindParam(":entryPrice", $entryPrice, PDO::PARAM_STR);
   $stmt->bindParam(":cDate", $newCloseDate, PDO::PARAM_STR);
   $stmt->execute();

   unset($_SESSION['error']);

   header("Location: index.php");
   exit;
?>
