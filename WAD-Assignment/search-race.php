<?php
require('includes/conn.inc.php');
$searchTerm = filter_var($_POST['searchTerm'], FILTER_SANITIZE_STRING);
$searchTerm = "%" . $searchTerm . "%";

$sql = "SELECT * FROM races WHERE RaceName LIKE :raceName OR RaceType LIKE :raceName";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":raceName", $searchTerm, PDO::PARAM_STR);
$stmt->execute();

$resultArr = array();
while($row = $stmt->fetchObject()){
  array_push($resultArr, array("RaceID" => $row->RaceID, "RaceType" => $row->RaceType,
                               "RaceName" => $row->RaceName, "RaceDate" => $row->RaceDate,
                               "ClosingEntryDate" => $row->ClosingEntryDate,
                               "RaceAddress" => $row->RaceAddress,
                               "OrganiserName" => $row->OrganiserName));
}

echo json_encode($resultArr);
?>
