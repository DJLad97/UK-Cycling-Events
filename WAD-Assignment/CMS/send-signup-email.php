<?php
require('/../includes/conn.inc.php');

$raceID = filter_var(strip_tags(trim($_GET['RaceID'])), FILTER_SANITIZE_STRING);
$sql = "SELECT OrganiserName, OrganiserEmail FROM races WHERE RaceID = :raceID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchObject();

$signUpSql = "SELECT * FROM racesignup WHERE RaceID = :raceID";
$signUpStmt = $pdo->prepare($signUpSql);
$signUpStmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
$signUpStmt->execute();

$email = $row->OrganiserEmail;


$to = $email;
$subject = "Race Sign ups";
$body = "<p>Hi here is your weekly email containing the latest sign ups you have for your race</p>";
$count = 0;
$body .= "<p>        Name - Gender - Age Range</p>";
while($signUpRow = $signUpStmt->fetchObject()){
  $count++;
  $body .= "<p>$count : {$signUpRow->Name} - {$signUpRow->Gender} - {$signUpRow->AgeRange}</p>";
}


$header = "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";


if(mail($to,$subject,$body,$header)){
   header('Location: CMS.php');
}
else {
   echo "Message could not be sent...";
}
?>
