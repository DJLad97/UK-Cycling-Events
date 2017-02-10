<?php
  require('includes/conn.inc.php');


  // PUT THIS CODE IN A SEPARATE PHP FILE!
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>

  <link rel="stylesheet" href="css/styles.css">
  <script src="js/main.js"></script>
  <script src="js/user-validation.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>Sign Up</title>

</head>
<body>
  <div class="container well">
     <div class="form-container">
       <?php
          if(isset($error)) {
            ?>
            <div class="alert alert-danger">
              <?php
              foreach($error as $e) {
                  ?>
                    <i class="glyphicon glyphicon-warning-sign"> &nbsp; <?php echo $e; ?></i>
                  <?php
              }
          }

       ?>
       </div>
       <form class="col-md-4" id="register-form" method="post">
        <!-- <form class="col-md-4" id="register-form" method="post"> -->
          <div class="page-header">
            <h2>SIGN UP</h2>
          </div><hr />
          <label>Have an account? <a href="index.php">Sign In</a></label>
            <div class="form-group">
              <label>First Name *</label>
              <input type="text" class="form-control" name="fName" />
            </div>
            <div class="form-group">
              <label>Last Name *</label>
              <input type="text" class="form-control" name="sName" />
            </div>
            <div class="form-group">
              <label>Username *</label>
              <input type="text" class="form-control" name="uName" />
            </div>
            <div class="form-group">
              <label>Email *</label>
              <input type="text" class="form-control" name="email" />
            </div>
            <div class="form-group">
               <label>Password *</label>
               <input type="password" class="form-control" id="pass" name="pass"/>
            </div>
            <div class="form-group">
               <label>Confirm Password *</label>
               <input type="password" class="form-control" name="passConf"/>
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <!-- <button type="submit" class="btn btn-block btn-primary" name="btn-signup">
                 <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button> -->
                <input type="submit" name="submit" value="Register" id="submit-button" class="btn btn-primary btn-lg" />
            </div>
            <br />
        </form>
       </div>
  </div>

</body>
</html>
