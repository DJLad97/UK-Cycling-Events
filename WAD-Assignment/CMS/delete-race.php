<?php
require('../includes/conn.inc.php');
require('check-user.php');

$raceID = $_GET['RaceID'];
$sql = "SELECT * FROM races WHERE RaceID = :raceID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':raceID', $raceID, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchObject();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>

  <link rel="stylesheet" href="../css/CMS-style.css">
  <script src="../js/main.js"></script>
  <script src="../js/race-validation.js"></script>
  <script src="../js/google-maps.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <title>DELETE <?php echo $row->RaceName; ?></title>
</head>
<body>
  <?php include('header.php'); ?>
  <div class="container well">
    <div class="page-header">
      <h1>DELETE <?php echo $row->RaceName; ?></h1>
    </div>
    <div class="row">
      <form action="delete.php" method="post">
        <div class="form-group">
          <input name="raceID" type="hidden" value="<?php echo $raceID; ?>">
          	<input type="submit" value="Delete" class="btn btn-danger">
          <a href="CMS.php" class="btn btn-success">Save</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
