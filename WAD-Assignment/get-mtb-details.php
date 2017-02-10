<?php
  //header('Content-Type: applications/json');
  require('includes/conn.inc.php');

  $stmt = $pdo->prepare("SELECT RaceID, RaceType, RaceName, RaceLatLong, RaceDate FROM races WHERE ClosingEntryDate > NOW() AND RaceType = 'MTB'");
  $stmt->execute();

 while($row = $stmt->fetch()){
   $returnArr[] = array("RaceID" => $row['RaceID'], "RaceType" => $row['RaceType'], "RaceName" => $row['RaceName'],
                        "RaceLatLong" => $row['RaceLatLong'], "RaceDate" => $row['RaceDate']);
 }

  echo json_encode($returnArr);
?>
