<!--  TODO:
  - ADD REMOVING RACE FROM CART
-->
<?php
  require('includes/conn.inc.php');

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
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/animate.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
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
    <h4>CART</h4>
    <br />
    <?php
    foreach ($_SESSION['cart']->cartArr as $key => $value){
      echo "<button type=\"button\" id=\"remove-item\"class=\"empty-button\">
              <i class=\"fa fa-times\" aria-hidden=\"true\"></i>
            </button>
            Race: " . $value['RaceName'] . "\t\t" . "Category: " . $value['AgeRange'] . " - " . $value['Gender'];
      echo '<br />';
    }
    ?>

    <form action="insert-race-sign-up.php" method="post">
      <input type="hidden" name="sqlQuery" value="<?php echo $sql?>" />
      <input type="submit" name="checkout" id="checkoutBtn" value="Checkout" class="btn btn-primary btn-default">
    </form>
  </div>

</body>
</html>
