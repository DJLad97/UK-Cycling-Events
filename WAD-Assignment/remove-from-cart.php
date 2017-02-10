<?php
require('includes/conn.inc.php');
 $itemToRemove = $_POST['cart-item'];

 // Create temp array so I can reset the index the elements are in
 // E.g array[0], array[1], array[2], array[3]
 // I remove array[1] the elements will reset so I will now have
 // array[0], array[1], array[2]
 $tempArr = $_SESSION['cart']->cartArr;

for($i = 0; $i < count($tempArr); $i++){
  // Remove the item the user requested
  if($tempArr[$i]['RaceID'] == $itemToRemove){
    unset($tempArr[$i]);
  }
}

// Do what I mentioned above
$_SESSION['cart']->cartArr = array_values($tempArr);

header('Location: ' . $_SESSION['url']);
?>
