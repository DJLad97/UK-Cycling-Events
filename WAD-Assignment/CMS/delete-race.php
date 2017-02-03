<?php
require('../includes/conn.inc.php');
$raceID = $_POST['RaceID'];

$sql = "DELETE FROM races WHERE RaceID = :raceID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userID', $raceID, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchObject();

header('Location: CMS.php');
exi;
?>
