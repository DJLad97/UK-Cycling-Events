<?php
  require('includes/conn.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/animate.css">
  <script src="js/main.js"></script>
  <script src="js/jquery.easing.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>RACE CART</title>
</head>
<body>
  <?php
  // Need to try an get the individual elements in the array
  //echo $_SESSION['cart']->getCartFirst();
  ?>
  <div id="cart">
    <?php
    if(isset($_SESSION['cart'])){
      foreach ($_SESSION['cart']->cartArr as $key => $value) {
        echo $value['EntryPrice'];
      }
    }
      //echo $_SESSION['cart']->showCart();
      for($i = 0; $i < $_SESSION['cart']->noOfItems; $i++){
        $gender = implode(', ', $_SESSION['cart']->cartArr[$i]['$gender']);
        $ageRange = implode(', ', $_SESSION['cart']->cartArr[$i]['$ageRange']);
        echo "GENDERS: " . $gender;
        echo "AGERANGES: " . $ageRange;
      }
    ?>

    <form action="insert-race-sign-up.php" method="post">
      <?php
        foreach ($_SESSION['cart']->cartArr as $key => $value) {

      ?>
      <input type="hidden" name="RaceID" value="<?php echo $value['RaceID']?>" />
      <input type="hidden" name="RaceName" value="<?php echo $value['RaceName']?>" />
      <input type="hidden" name="gender" value="<?php echo $value['Gender']?>" />
      <input type="hidden" name="ageRange" value="<?php echo $value['AgeRange']?>" />

      <?php } ?>
      <input type="submit" name="subBtn" id="button" value="Checkout" class="btn btn-primary btn-default">
    </form>
  </div>

</body>
</html>