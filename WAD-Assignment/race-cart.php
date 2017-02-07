<!--  TODO:
  - ADD REMOVING RACE FROM CART
-->
<?php
  require('includes/conn.inc.php');
  if(!isset($_SESSION['userSession'])){
    header("Location: log-in.php");
  }

  $userID = $_SESSION['userSession'];

  $userQuery = "SELECT UserID, Forename, Surname FROM user WHERE UserID = :userID";
  $userStmt = $user->runQuery($userQuery);
  $userStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
  $userStmt->execute();

  $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);

  $nameFromUser = $userRow['Forename'] . " " . $userRow['Surname'];

  $sql = "INSERT INTO RaceSignUp (RaceID, UserID, Name, Gender, AgeRange)
  VALUES ";
  $valuesArr = array();
  $values = "";
  if(isset($_SESSION['cart'])){
    foreach ($_SESSION['cart']->cartArr as $key => $value) {
      $values .= "(" . $value['RaceID'] . ", " . $userID . ", '" .  $nameFromUser .
                "', '" . $value['Gender'] . "', '" . $value['AgeRange'] . "'), ";
    }
    // echo count($_SESSION['cart']->cartArr);
    // for($i = 0; $i < count($_SESSION['cart']->cartArr); $i++){
    //     $values .= "(" . $_SESSION['cart']->cartArr[$i]['RaceID'] . ", " . $userID . ", '" .  $nameFromUser .
    //               "', '" . $_SESSION['cart']->cartArr[$i]['Gender'] . "', '" . $_SESSION['cart']->cartArr[$i]['AgeRange'] . "'), ";
    //   }
  }

  // Concatonate the values and remove the comma at the end of alues
  $sql .= substr_replace($values, "", -2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
  //echo $_SESSION['cart']->getCartFirst();
  ?>
  <?php
  //print_r($_SESSION['cart']->cartArr);
  ?>
  <div id="cart">
    <h4>CART</h4>
    <br />
    <?php
    // echo $_SESSION['cart']->cartArr[0]['RaceName'];
      $cartEmpty = true;

      if(!empty($_SESSION['cart']->cartArr)){
        $cartEmpty = false;
        $i = 0;

      // for($i = 0; $i < count($_SESSION['cart']->cartArr); $i++){
      //   echo '<form name="cart-form" method="post" action="remove-from-cart.php">';
      //   echo "<input type=\"submit\" id=\"remove-item\"class=\"empty-button" . $i . "\"\">
      //           <i class=\"fa fa-times\" aria-hidden=\"true\"></i>
      //         </button>
      //         Race: " . $_SESSION['cart']->cartArr[$i]['RaceName'] . "\t\t" . "Category: " .
      //         $_SESSION['cart']->cartArr[$i]['AgeRange'] . " - " . $_SESSION['cart']->cartArr[$i]['Gender'];
      //   echo '<br />';
      //   echo '<input type="hidden" name="cart-item" value="' . $_SESSION['cart']->cartArr[$i]['RaceID'] .'"/>';
      //   echo '</form>';
      // }
        foreach ($_SESSION['cart']->cartArr as $key => $value){
          echo '<form name="cart-form" method="post" action="remove-from-cart.php">';
          echo "<input type=\"submit\" id=\"remove-item\"class=\"empty-button" . $i . "\"\">
                  <i class=\"fa fa-times\" aria-hidden=\"true\"></i>
                </button>
                Race: " . $value['RaceName'] . "\t\t" . "Category: " . $value['AgeRange'] . " - " . $value['Gender'];
          echo '<br />';
          echo '<input type="hidden" name="cart-item" value="' . $value['RaceID'] .'"/>';
          echo '</form>';
          $i++;
        }
    }
    else{
    ?>
    <p>CART IS EMPTY</p>
    <?php } ?>
    <form action="insert-race-sign-up.php" method="post">
      <input type="hidden" name="sqlQuery" value="<?php echo $sql?>" />
      <input type="submit" name="checkout" id="checkoutBtn" value="Checkout" class="btn btn-primary btn-default" <?php if($cartEmpty) echo "disabled"; ?>>
    </form>
  </div>

</body>
</html>
