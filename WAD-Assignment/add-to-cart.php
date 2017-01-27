<?php
require('includes/conn.inc.php');
$raceID = $_GET['RaceID'];
$raceName = $_GET['RaceName'];
$price = $_GET['EntryPrice'];

if($price == NULL)
  header('Location: insert-race-sign-up.php');

if(!isset($_SESSION['cart'])){
  $cart = new Cart();
  $_SESSION['cart'] = $cart;
}

$_SESSION['cart']->addItem($raceID, $raceName, $price);
header('Location: index.php');
exit;
?>
