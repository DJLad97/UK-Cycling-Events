<?php
  require('includes/conn.inc.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $fName = filter_var(strip_tags(trim($_POST['fName'])), FILTER_SANITIZE_STRING);
      $sName = filter_var(strip_tags(trim($_POST['sName'])), FILTER_SANITIZE_STRING);
      $uName = filter_var(strip_tags(trim($_POST['uName'])), FILTER_SANITIZE_STRING);
      $email = filter_var(strip_tags(trim($_POST['email'])), FILTER_SANITIZE_EMAIL);
      $password = filter_var(strip_tags(trim($_POST['pass'])), FILTER_SANITIZE_STRING);
      if(empty($fName)){
          $error[] = "Please provide your firstname!";
      }
      if(empty($sName)){
          $error[] = "Please provide your surname!";
      }
      if(empty($uName)){
          $error[] = "Please provide a username!";
      }
      if(empty(!filter_var($email, FILTER_VALIDATE_EMAIL))){
          $error[] = "Please provide your email!";
      }
      if(strlen($password) < 6){
          $error[] = "Please provide a password!";
      }
      else
      {
          try
          {

            if($user->register($fName, $sName, $uName, $email, $password))
            {
              $user->redirect("index.php");
            }

          }
          catch(PDOException $e)
          {
            echo $e.getMessage();
          }

      }

  }
?>
