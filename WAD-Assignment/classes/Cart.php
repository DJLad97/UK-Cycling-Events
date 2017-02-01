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

  public function addItem($raceID, $raceName, $price, $gender, $ageRange){
    array_push($this->cartArr, array("RaceID" => $raceID, "RaceName" => $raceName,
                                    "EntryPrice" => $price, "Gender" => $gender, "AgeRange" => $ageRange));
    $this->noOfItems++;
  }

  public function showTotal($price){
    return $this->cartTotal += $price;
  }

  public function showCart(){
    //return $this->cartArr;

    foreach ($this->cartArr as $var) {
      echo "\nRace ID: ", $var['RaceID'], "\t\t Name: ", $var['RaceName'], "\t\t Price: £", $var['EntryPrice'], "\t\t",
            "Gender: ", "\t\t", $var['Gender'], "\t\t", "Age Range: ", $var['AgeRange'];
    }

    foreach ($this->cartArr as $key => $value) {
      echo $value['RaceName'];
    }
  }
}
?>
