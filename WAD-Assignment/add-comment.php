<?php
require('includes/conn.inc.php');

$raceID = $_POST['raceID'];
$userID = $_SESSION['userSession'];

$commentContent = filter_var(strip_tags(trim($_POST['raceComment'])), FILTER_SANITIZE_STRING);

$userSQL = "SELECT Username FROM user WHERE UserID = :userID";
$userStmt = $pdo->prepare($userSQL);
$userStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$userStmt->execute();
$userResult = $userStmt->fetchObject();

echo $userID;
echo $userResult->Username;

$sql = "INSERT INTO comment (CommentContent, UserID, RaceID, Username) VALUES (:commentContent, :userID, :raceID, :userName)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':commentContent', $commentContent, PDO::PARAM_STR);
$stmt->bindParam(':userName', $userResult->Username, PDO::PARAM_STR);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
$stmt->execute();
header('Location: race-sign-up.php?RaceID=' . $raceID);
exit;
?>
