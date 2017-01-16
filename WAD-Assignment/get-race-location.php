<?php
  require('includes/conn.inc.php');
  $raceID = $_SESSION['getRaceID'];

  $sql = "SELECT RaceLatLong FROM races WHERE RaceID = :raceID";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetchObject();

  $returnVar = $row->RaceLatLong;
  echo json_encode($returnVar);
?>
