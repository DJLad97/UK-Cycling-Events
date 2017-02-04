<?php
require('includes/conn.inc.php');

$raceID = $_POST['raceID'];
$userID = $_SESSION['userSession'];

$commentContent = filter_var(strip_tags(trim($_POST['raceComment'])), FILTER_SANITIZE_STRING);

$userSQL = "SELECT Username FROM user WHERE UserID = :userID";
$userStmt = $pdo->prepare($userSQL);
$userStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$userStmt->execute();

$sql = "INSERT INTO comment (CommentContent, UserID, Username) VALUES (:commentContent, :userID, :userName)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':commentContent', $commentContent, PDO::PARAM_STR);
$stmt->bindParam(':userName', $userStmt->Username, PDO::PARAM_STR);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
header('Location: race-sign-up.php?RaceID=' . $raceID);
exit;
?>
