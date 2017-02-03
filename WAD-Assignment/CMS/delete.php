<?php
require('../includes/conn.inc.php');
$raceID = $_POST['raceID'];

$sql = "DELETE FROM races WHERE RaceID = :raceID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
$stmt->execute();

header('Location: CMS.php');
exit;
?>
