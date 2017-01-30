<?php
require('includes/conn.inc.php');
$raceID = $_GET['RaceID'];
$raceName = $_GET['RaceName'];
$price = $_GET['EntryPrice'];
$gender = $_GET['gender'];
$ageRange = $_GET['ageRange'];

if(!isset($_SESSION['cart'])){
  $cart = new Cart();
  $_SESSION['cart'] = $cart;
}

$_SESSION['cart']->addItem($raceID, $raceName, $price, $gender, $ageRange);
header('Location: race-cart.php');
exit;
?>
