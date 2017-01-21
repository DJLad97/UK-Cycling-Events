<?php

  require ('includes/conn.inc.php');

  $stmt = $pdo->prepare("SELECT Username, Email FROM User");
  $stmt->execute();

  while($row = $stmt->fetch()){
    $returnArr[] = array("Username" => $row['Username'], "Email" => $row['Email']);
  }

  echo json_encode($returnArr);
?>
