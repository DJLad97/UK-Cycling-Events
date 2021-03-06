<?php
define('DIR', 'http://danjscott.co.uk/UK-Cycling-Events/');
define('SITEEMAIL', 'noreply@UK-Cycling-Events.co.uk');
class user
{
  private $db;
  public $userID;
  public $activation;
  function __construct($pdo)
  {
      $this->db = $pdo;
  }

  public function runQuery($sql)
  {
      $stmt = $this->db->prepare($sql);
      return $stmt;
  }

  public function register($fName, $sName, $uName, $email, $password)
  {
    try
    {
      // $newPass = $password_hash($password, PASSWORD_DEFAULT);
      $activation = md5(uniqid(rand(), true));
      $safePass = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $hashedPass = password_hash($safePass, PASSWORD_BCRYPT);
      $this->hashedPassGlb = $hashedPass;
      $stmt = $this->db->prepare("INSERT INTO user(Forename, Surname, Username, Email, Password, active)
      VALUES(:fName, :sName, :uName, :email, :password, :active)");

      $stmt->bindParam(':fName', $fName);
      $stmt->bindParam(':sName', $sName);
      $stmt->bindParam(':uName', $uName);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $hashedPass);
      $stmt->bindParam(':active', $activation);

      $stmt->execute();

      $userID = $this->db->lastInsertId('UserID');

      $to = $email;
      $subject = "Registration Confirmation";
      $body = "<p>Thank you for registering for the site!</p>
      <p>To activate your account, please click on <a href='".DIR."activate.php?x=$userID&y=$activation'>this link</a></p>
      <p>Regards Site Admin</p>";

      $header = "MIME-Version: 1.0\r\n";
      $header .= "Content-type: text/html\r\n";

      if(mail($to,$subject,$body,$header)){
         header('Location: index.php?succ=activate');
         echo "Message sent successfully...";
      }
      else {
         echo "Message could not be sent...";
      }
      // $to = $email;
      // $subject = "Registration Confirmation";
      // $body = "<p>Thank you for registering for the site!</p>
      // <p>To activate your account, please click on <a href='".DIR."activate.php?x=$userID&y=$activation'>this link</a></p>
			// <p>Regards Site Admin</p>";
      //
      // $header = "MIME-Version: 1.0\r\n";
      // $header .= "Content-type: text/html\r\n";
      //
      //
      // if(mail($to,$subject,$body,$header)){
      //    header('Location: index.php');
      //    echo "Message sent successfully...";
      // }
      // else {
      //    echo "Message could not be sent...";
      // }
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  }

  public function sendEmail(){
    $to = $email;
    $subject = "Registration Confirmation";
    $body = "<p>Thank you for registering for the site!</p>
    <p>To activate your account, please click on <a href='".DIR."activate.php?x=$userID&y=$activation'>this link</a></p>
    <p>Regards Site Admin</p>";

    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    if(mail($to,$subject,$body,$header)){
       header('Location: index.php?succ=activate');
       echo "Message sent successfully...";
    }
    else {
       echo "Message could not be sent...";
    }
  }
  public function login($uName, $pass)
   {
      try
      {
         $stmt = $this->db->prepare("SELECT UserID, Username, Password, active, IsAdmin FROM user WHERE Username = :uName LIMIT 1");
         $stmt->bindParam(':uName', $uName, PDO::PARAM_STR);
         $stmt->execute();
         //$stmt->execute(array(':uName'=>$uName));
         $userRow = $stmt->fetch(PDO::FETCH_ASSOC);;


         if($stmt->rowCount() > 0)
         {
            if(password_verify($pass, $userRow['Password']) && $userRow['active'] == 'yes')
            {
               $_SESSION['userLevel'] = $userRow['IsAdmin'];
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
