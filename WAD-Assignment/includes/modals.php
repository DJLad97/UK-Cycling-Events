
<?php
if(!isset($_SESSION['userSession'])){

?>

<div id="login-modal" class="modal">
    <div class="col-xs-1 col-sm-3 col-md-4"></div>
    <form class="model-content animate col-xs-10 col-sm-6 col-md-4" method="post" action="log-in.php" id="login-form">
      <span onclick="document.getElementById('login-modal').style.display='none'"
      class="close" title="Close Modal">&times;</span>
      <div id="error">
      <?php
  			if(!empty($_GET['er'])){
  				?>
            <div class="alert alert-danger">
               <i class="glyphicon glyphicon-warning-sign"></i> &nbsp;
               <?php
               switch($_GET['er']){
                 case 'failedLogin':
                   echo "Username or password is invalid or you haven't activated your account!";
                   break;
                 case 'notLoggedIn':
                   echo "Please log in to sign up for races";
                   break;

               }
               ?>
            </div>
            <?php
  			}
        if(!empty($_GET['succ'])){
  				?>
            <div class="alert alert-success">
               <i class="glyphicon glyphicon-ok"></i> &nbsp;
               <?php
               switch($_GET['succ']){
                 case 'activate':
                   echo 'Please check your email to activate your account.<br />
                         No Email? <i>Do this later</i>';
                   break;

               }
               ?>
            </div>
            <?php
  			}
      ?>
      </div>
      <div class="page-header">
        <h2>SIGN IN</h2>
      </div>
      <div class="form-group">
        <label>Username</label>
        <input type="text" class="text-box" name="uName" placeholder="Username"/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="text-box" name="pass" placeholder="Password"/>
      </div>
      <p><a href="sign-up.php">Don't have an account?</a></p>
      <div class="form-group">
        <input type="submit" name="submit" value="Sign In" class="modal-btn" />
      </div>
    </form>
    <div class="col-xs-1 col-sm-3 col-md-4"></div>
  </div>

  <div id="signup-modal" class="modal">
    <div class="col-xs-1 col-sm-3 col-md-3"></div>
    <form class="model-content animate col-xs-10 col-sm-6 col-md-6" method="post" action="sign-up.php" id="register-form">
      <span onclick="document.getElementById('signup-modal').style.display='none'"
      class="close" title="Close Modal">&times;</span>
      <div class="page-header">
        <h2>SIGN UP</h2>
      </div>
      <label>Have an account? <a class="non-nav" href="index.php">Sign In</a></label>
      <div class="row">
        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label>First Name *</label>
            <input type="text" class="text-box" name="fName" placeholder="First Name"/>
          </div>
        </div>
        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label>Last Name *</label>
            <input type="text" class="text-box" name="sName"  placeholder="Last Name"/>
          </div>
        </div>
        <div class="col-sm-12 col-md-12">
          <div class="form-group">
            <label>Username *</label>
            <input type="text" class="text-box" name="uName"  placeholder="Username"/>
          </div>
        </div>
        <div class="col-sm-12 col-md-12">
          <div class="form-group">
            <label>Email *</label>
            <input type="text" class="text-box" name="email" placeholder="Email" />
          </div>
        </div>
        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label>Password *</label>
            <input type="password" class="text-box" id="pass" name="pass" placeholder="Password"/>
          </div>
        </div>
        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label>Confirm Password *</label>
            <input type="password" class="text-box" name="passConf" placeholder="Confirm Password"/>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <input type="submit" name="submit" value="Register" id="submit-button" class="modal-btn" />
          </div>
        </div>
      </div>
    </form>
    <div class="col-xs-1 col-sm-6 col-md-3"></div>
  </div>
  <?php } ?>
