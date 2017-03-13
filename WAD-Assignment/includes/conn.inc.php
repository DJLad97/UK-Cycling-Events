<?php
require($_SERVER['DOCUMENT_ROOT'] . '/UK-Cycling-Events/classes/Cart.php');
require($_SERVER['DOCUMENT_ROOT'] . '/UK-Cycling-Events/sessions/sessions.inc.php');
$dsn = 'mysql:host=**HOST_NAME_**;dbname=**DB_NAME**';
$user = '';
$password = '';

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

require($_SERVER['DOCUMENT_ROOT'] . '/UK-Cycling-Events/classes/User.php');
$user = new user($pdo);
?>
