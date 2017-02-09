<header>
  <nav class="navbar navbar-inverse navbar-fixed-top">
      <ul>
        <li><a href="index.php">MTB & ROAD</a></li>
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
        <li><a class="sign-in" onclick="document.getElementById('login-modal').style.display='block'">SIGN IN</a></li>
        <li><a href="sign-up.php">SIGN UP</a></li>
        <?php } ?>
        <li><a href="#">CART</a></li>
      </ul>
  </nav>
</header>
