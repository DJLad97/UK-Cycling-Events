<?php
  //header('Content-Type: applications/json');
  require('includes/conn.inc.php');

  $stmt = $pdo->prepare("SELECT RaceID, RaceType, RaceName, RaceLatLong, RaceDate FROM races");
  $stmt->execute();
  $row = $stmt->fetchObject();

  //echo json_encode($row)
 $returnArr = array();
 while($row = $stmt->fetch()){

   $returnArr[] = array("RaceID" => $row['RaceID'], "RaceType" => $row['RaceType'], "RaceName" => $row['RaceName'],
                        "RaceLatLong" => $row['RaceLatLong'], "RaceDate" => $row['RaceDate']);
 }

  echo json_encode($returnArr);
?>
