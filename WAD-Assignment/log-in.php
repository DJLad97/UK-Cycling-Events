<?php
  require('includes/conn.inc.php');
  require_once('classes/User.php');
  $login = new user($pdo);

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
      }
  }
?>
