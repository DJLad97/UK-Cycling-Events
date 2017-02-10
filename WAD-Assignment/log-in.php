<?php
  require('includes/conn.inc.php');
  require_once('classes/User.php');
  $login = new user($pdo);
  // If the user tried to access a page that required login
  // they will be redirected to that page after login
  // if(isset($_SESSION['url']))
  //   $url = $_SESSION['url'];
  // else
  //   $url = 'profile.php';
  $url = 'profile.php';
  if(isset($_POST['submit']))
  {
      $uName = strip_tags($_POST['uName']);
      $password = strip_tags($_POST['pass']);

      if($login->login($uName, $password))
      {
        if($_SESSION['userLevel'] == 'admin')
          $url = 'CMS/CMS.php';

         $login->redirect($url);
      }
      else
      {
        $login->redirect('index.php?er=failedLogin');
        // $_SESSION['error'] = "Username or password is invalid or you haven't activated your account!";
      }
  }
?>
