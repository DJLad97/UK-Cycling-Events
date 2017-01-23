<?php
  require('includes/conn.inc.php');
  $userID = trim($_GET['x']);
  $active = trim($_GET['y']);

  if(is_numeric($userID) && !empty($active)){
    $stmt  = $pdo->prepare("UPDATE user SET active = 'Yes' WHERE userID = :userID AND active = :active");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':active', $active);
    $stmt->execute();
    if($stmt->rowCount() == 1){
      header('Location: login.php?action=active');
      exit;
    }
    else {
      echo "Your account could not be activated";
    }
  }
?>
