<?php
  require('includes/conn.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/animate.css">
  <script src="js/main.js"></script>
  <script src="js/jquery.easing.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>RACE CART</title>
</head>
<body>
  <?php
  // Need to try an get the individual elements in the array
  echo $_SESSION['cart']->getCartFirst();
  ?>
  <div id="cart">
    <?php
    if(isset($_SESSION['cart']))
      echo $_SESSION['cart']->showCart();
    ?>

    <form action="insert-race-sign-up.php" method="post">
      <input type="hidden" name="RaceID" value="<?php echo $raceID?>" />
      <input type="hidden" name="RaceName" value="<?php echo $result->RaceName?>" />
      <input type="hidden" name="EntryPrice" value="<?php echo $result->EntryPrice?>" />
    </form>
  </div>

</body>
</html>
