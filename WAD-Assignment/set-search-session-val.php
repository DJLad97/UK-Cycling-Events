<?php
  $_SESSION['hasSearched'] = $_GET['searchLength'];
  echo json_encode(array('message' => $_SESSION['hasSearched']));
?>
