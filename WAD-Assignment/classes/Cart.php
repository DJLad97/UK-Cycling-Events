<?php
class Cart
{
  public $noOfItems;
  public $cartTotal;
  public $cartArr = array();

  public function __construct(){
    $this->noOfItems = 0;
    $this->cartTotal = 0;
  }

  public function addItem($raceID, $raceName, $price){
    array_push($this->cartArr, array("RaceID" => $raceID, "RaceName" => $raceName, "EntryPrice" => $price));
    $this->noOfItems++;
  }

  public function showCart(){
    //return $this->cartArr;

    foreach ($this->cartArr as $var) {
      echo "\n", $var['RaceID'], "\t\t", $var['RaceName'], "\t\t", $var["EntryPrice"];
    }
  }
}
?>
