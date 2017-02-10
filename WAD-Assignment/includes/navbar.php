<?php
require_once('includes/conn.inc.php');
include ('Mobile-Detect/Mobile_Detect.php');
$detect = new Mobile_Detect();
if(isset($_SESSION['userSession']))
{
    $userLoggedIn = "true";
    $userID = $_SESSION['userSession'];

    $userQuery = "SELECT * FROM user WHERE userID = :userID";
    $stmt = $user->runQuery($userQuery);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

}

?>
<header>
  <nav class="navbar navbar-inverse navbar-fixed-top">
      <ul>
        <li><a class="home" href="index.php">UK CYCLING EVENTS</a></li>
        <li><a href="race-listings.php">MTB & ROAD</a></li>
        <?php if(isset($_SESSION['userSession']) && $userRow['IsAdmin'] == 'admin'){ ?>
        <li><a href="CMS/CMS.php">CMS Page</a></li>
        <?php }?>
        <?php
            if(isset($_SESSION['userSession']))
            {

        ?>
        <li><a href="profile.php"><?php echo $userRow['Username'] ?></a></li>
        <li><a href="log-out.php">LOG OUT</a></li>

        <?php
            }
            else
            {
        ?>
        <li><a class="a-with-pointer sign-in" onclick="document.getElementById('login-modal').style.display='block'; document.getElementById('signup-modal').style.display='none'">SIGN IN</a></li>
        <li><a class="a-with-pointer sign-up" onclick="document.getElementById('signup-modal').style.display='block'; document.getElementById('login-modal').style.display='none';">SIGN UP</a></li>
        <?php } ?>
        <li><a class="a-with-pointer" id="cart" href="<?php if($detect->isMobile()) echo 'race-cart.php'; ?>">CART</a></li>
      </ul>
  </nav>
</header>
