<?php
class user
{
  private $db;

  function __construct($pdo)
  {
      $this->db = $pdo;
  }

  public function runQuery($sql)
  {
      $stmt = $this->db->prepare($sql);
      return $stmt;
  }

  public function register($fName, $sName, $uName, $email, $password,
                          $add1, $add2, $townCity, $county, $postCode, $country)
  {
    try
    {
      // $newPass = $password_hash($password, PASSWORD_DEFAULT);
      $safePass = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $hashedPass = password_hash($safePass, PASSWORD_BCRYPT);
      $this->hashedPassGlb = $hashedPass;
      $stmt = $this->db->prepare("INSERT INTO User(Forename, Surname, Username, Email, Password,
      AddressLine1, AddressLine2, TownCity, County, PostCode, Country)
      VALUES(:fName, :sName, :uName, :email, :password, :add1, :add2,
              :townCity, :county, :postCode, :country)");

      $stmt->bindParam(':fName', $fName);
      $stmt->bindParam(':sName', $sName);
      $stmt->bindParam(':uName', $uName);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $hashedPass);
      $stmt->bindParam(':add1', $add1);
      $stmt->bindParam(':add2', $add2);
      $stmt->bindParam(':townCity', $townCity);
      $stmt->bindParam(':county', $county);
      $stmt->bindParam(':postCode', $postCode);
      $stmt->bindParam(':country', $country);

      $stmt->execute();

      return $stmt;
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  }

  public function login($uName, $pass)
   {
      try
      {
         $stmt = $this->db->prepare("SELECT UserID, Username, Password FROM user WHERE Username=:uName LIMIT 1");
         $stmt->bindParam(':uName', $uName, PDO::PARAM_STR);
         $stmt->execute();
         //$stmt->execute(array(':uName'=>$uName));
         $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

         if($stmt->rowCount() > 0)
         {
            if(password_verify($pass, $userRow['Password']))
            {
               $_SESSION['userSession'] = $userRow['UserID'];
               return true;
            }
            else
            {
               return false;
            }
         }
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
  }

  public function redirect($url)
  {
      header("Location: $url");
  }
}
?>
