<?php
  require('includes/conn.inc.php');

  $url = $_SESSION['url'];

  if(isset($_SESSION['userSession']))
  {
      setcookie('userSession', '', time()-3600, '/', 'localhost', 1, 1);
  }

  $_SESSION = array();

  session_destroy();


  header('Location: index.php');
  exit;
?>
