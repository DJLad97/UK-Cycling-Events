<?php
  require('includes/conn.inc.php');
  require_once('classes/User.php');
  $login = new user($pdo);

  if(isset($_SESSION['userSession']))
  {
  	  $login->redirect('index.php');
  }

  // If the user tried to access a page that required login
  // they will be redirected to that page after login
  if(isset($_SESSION['url']))
    $url = $_SESSION['url'];
  else
    $url = 'profile.php';

  if(isset($_POST['submit']))
  {
      $uName = strip_tags($_POST['uName']);
      $password = strip_tags($_POST['pass']);

      if($login->login($uName, $password))
      {
          $login->redirect($url);
      }
      else
      {
          $error = "Wrong details!";
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/styles.css">
  <script src="js/main.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>Log In</title>


</head>
<body>
  <div class="container well">
    <div class="form-container">
      <form class="col-md-4" method="post">
        <div class="page-header">
          <h2>SIGN IN</h2>
        </div><hr />
        <div id="error">
        <?php
    			if(isset($error))
    			{
    				?>
              <div class="alert alert-danger">
                 <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
              </div>
              <?php
    			}
    		?>
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" class="form-control" name="uName" placeholder="Username" value="" required/>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" name="pass" placeholder="Password" value="" required/>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Sign In" class="btn btn-primary btn-lg" />
        </div>
      </form>
    </div>
  </div>


</body>
</html>
