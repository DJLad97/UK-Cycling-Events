<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $raceType = $_POST['raceType'];
    echo $raceType;
    $organiserName = filter_var(strip_tags(trim($_POST['organiserName'])), FILTER_SANITIZE_STRING);
    $organiserEmail = filter_var(strip_tags(trim($_POST['organiserEmail'])), FILTER_SANITIZE_STRING);
    $raceName = filter_var(strip_tags(trim($_POST['raceName'])), FILTER_SANITIZE_STRING);
    $startDate = filter_var(strip_tags(trim($_POST['raceStartDate'])), FILTER_SANITIZE_STRING);
    $closeDate = filter_var(strip_tags(trim($_POST['closingEntryDate'])), FILTER_SANITIZE_STRING);
    $address = filter_var(strip_tags(trim($_POST['raceAddress'])), FILTER_SANITIZE_STRING);
    $postCode = filter_var(strip_tags(trim($_POST['racePostcode'])), FILTER_SANITIZE_STRING);
    $loc = filter_var(strip_tags(trim($_POST['raceLatLong'])), FILTER_SANITIZE_STRING);
    $isFree = $_POST['isFree'];
    if($_POST['entryPrice'] == null)
      $entryPrice = NULL;
    else
      $entryPrice = filter_var(strip_tags(trim($_POST['entryPrice'])), FILTER_SANITIZE_STRING);

    $raceDesc = filter_var(strip_tags(trim($_POST['raceDesc'])), FILTER_SANITIZE_STRING);

    if(empty($raceType)){
        $error[] = "Please choose what type of race you have!";
    }
    if(empty($organiserName)){
        $error[] = "Please enter your organisation name!";
    }
    if(empty($raceName)){
        $error[] = "Please enter the name of your race!";
    }
    if(empty(!filter_var($organiserEmail, FILTER_VALIDATE_EMAIL))){
        $error[] = "Please enter a <em>valid</em> email address!";
    }
    if(empty($startDate)){
        $error[] = "Please enter the date your race starts!";
    }
    if(empty($closeDate)){
        $error[] = "Please enter the date in which enteries are no longer allowed after!";
    }
    if(empty($address)){
        $error[] = "Please enter the address of your race!";
    }
    if(empty($postCode)){
        $error[] = "Please enter the race postcode!";
    }
    if(empty($loc)){
        $error[] = "Please choose the latitude and longtitude on the map!";
    }
    if(empty($isFree)){
        $error[] = "Please specifiy if your race is free to enter or not!";
    }
    else {
      try
      {
        header('Location: insert-race.php');
      }
      catch(PDOException $e)
      {
         echo $e.getMessage();
      }
    }
  }
?>
