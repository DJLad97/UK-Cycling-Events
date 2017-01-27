<?php
class Cart
{
  private $noOfItems;
  private $cartTotal;

  public function __construct(){
    $this->noOfItems = 0;
    $this->cartTotal = 0;
  }

  public function setNoItems($num){
    $this->noOfItems = $num;
  }

  public function getNoItems(){
    return $this->noOfItems;
  }

  public function setcartTotal($total){
    $this->cartTotal = $total;
  }

  public function getcartTotal(){
    return $this->cartTotal;
  }
}
?>
