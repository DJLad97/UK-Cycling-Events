<?php
class Cart
{
  public $noOfItems;
  public $cartTotal;
  public $cartArr = array();
  // public $cartArr = array('RaceID' => array(), 'Name' => array(), 'Price' => array());

  public function __construct(){
    $this->noOfItems = 0;
    $this->cartTotal = 0;
  }

  public function addItem($raceID, $name, $price){
    array_push($this->cartArr, array($raceID, $name, $price));
  }

  public function showCart(){
    return $this->cartArr;
  }
}
?>
