<?php
  require_once('includes/conn.inc.php');

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
<div class="cart-window popup">
  <h4><strong>CART</strong></h4>
  <br />
  <?php
    $cartEmpty = true;

    if(!empty($_SESSION['cart']->cartArr)){
      $cartEmpty = false;

      $i = 0;
      foreach ($_SESSION['cart']->cartArr as $key => $value){
        echo '<form name="cart-form" method="post" action="remove-from-cart.php">';
        echo "<input type=\"submit\" value=\"Remove\" id=\"remove-item\"class=\"empty-button" . $i . "\"\"><br />

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
    <input type="submit" name="checkout" id="checkoutBtn" value="Checkout" class="modal-btn listing" <?php if($cartEmpty) echo "disabled"; ?>>
    <p><a class="non-nav close" href="/">&times;</a></p>
  </form>
</div>
