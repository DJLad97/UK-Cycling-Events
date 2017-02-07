<?php
  require('includes/conn.inc.php');


  $userID = $_SESSION['userSession'];
  $IDinDB = $userID . '%';
  $delStmt = $pdo->prepare("UPDATE user SET ProfileImg = NULL WHERE ProfileImg = :userID");
  $delStmt->bindParam(":userID", $IDinDB);
  $delStmt->execute();

  unlink('images/' . $IDinDB);

  $fileError = $_FILES['profileImg']['error'];
  if($fileError > 0){
      header("Location:profile.php?err=imgUploadError");
      exit;
  }



  $fileTempName = $_FILES['profileImg']['tmp_name'];
  $trueFileType = exif_imagetype($fileTempName);
  $allowedFiles = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

  if (in_array($trueFileType, $allowedFiles)) {
    switch($trueFileType){
      case 1: $fileExt  = ".gif";
        break;
      case 2: $fileExt  = ".jpg";
        break;
      case 3 : $fileExt  = ".png";
        break;
     }
}
  else{
    header("Location:profile.php?err=WrongFileType");
    exit;
  }

  $newFileName = $userID . $fileExt;

  $myPathInfo = pathinfo($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']);
  $currentDir = $myPathInfo['dirname'];
  $imgDir = $currentDir . '/images/';



  $stmt = $pdo->prepare("UPDATE user SET profileImg = :profileImg WHERE UserID = :userID");
  $stmt->bindParam(":profileImg", $newFileName);
  $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
  $stmt->execute();

  $newImgLocation = $imgDir . $newFileName;
  if(move_uploaded_file($fileTempName, $newImgLocation))
    header("Location: profile.php");
  else
    header("Location:profile.php?err=uploadProb");
?>
