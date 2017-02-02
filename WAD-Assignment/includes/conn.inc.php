<?php
require('/../classes/Cart.php');
require('/../sessions/sessions.inc.php');
$dsn = 'mysql:host=localhost;dbname=wad_project';
$user = 'root';
$password = 'billion2468';

try
{
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec("SET CHARACTER SET utf8");
}
catch (PDOException $e)
{
  echo 'Connection failed again: ' . $e->getMessage();
}

require('/../classes/User.php');
$user = new user($pdo);
?>
