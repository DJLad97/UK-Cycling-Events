<?php
if($_SESSION['userLevel'] != 'admin'){
  header('Location: ../index.php');
}
?>
