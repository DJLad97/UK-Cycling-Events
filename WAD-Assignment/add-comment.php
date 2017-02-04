<?php
require('includes/conn.inc.php');

$raceID = $_POST['raceID'];
$userID = $_SESSION['userSession'];

$commentContent = filter_var(strip_tags(trim($_POST['raceComment'])), FILTER_SANITIZE_STRING);

$sql = "INSERT INTO comment (CommentContent, UserID) VALUES (:commentContent, :userID)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':commentContent', $commentContent, PDO::PARAM_STR);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
header('Location: race-sign-up.php?RaceID=' . $raceID);
exit;
?>
