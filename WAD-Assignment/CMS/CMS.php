<!--  ADD A CHECK TO SEE IF THE ID EXISTS ON EACH CMS PAGE-->

<?php
  require('/../includes/conn.inc.php');
  require('check-user.php');

  $sql = "SELECT * FROM races";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $userSql = "SELECT * FROM user";
  $userStmt = $pdo->prepare($userSql);
  $userStmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://use.fontawesome.com/1a6d4ae9a2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../css/CMS-style.css">

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>CMS</title>
</head>
<body>
  <?php include('header.php'); ?>
  <div class="container well">
    <div class="page-header">
      <h1>Content Management System</h1>
    </div>
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#races">Races</a></li>
      <li><a data-toggle="tab" href="#users">Users</a></li>
      <li><a data-toggle="tab" href="#files">Files</a></li>
    </ul>
    <br />

    <div class="tab-content">
      <div id="races" class="tab-pane fade in active">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped">
              <p><a href="add-race-cms.php" class="btn btn-success">Add New Race</a></p>
              <thead>
                <tr>
                  <th class="table-text">Race</th>
                  <th class="table-text">Send Sign Up Email</th>
                  <th class="table-text">Edit</th>
                  <th class="table-text">Delete</th>
                  <th class="table-text">View</th>
                </tr>
              </thead>
              <?php
              while($row = $stmt->fetchObject()){
                echo "<tr>";
                echo "<td class=\"table-text\">{$row->RaceName}</td>";
                echo "<td><a href=\"send-signup-email.php?RaceID={$row->RaceID}\"</a>Send</td>";
                echo "<td><a href=\"edit-race.php?RaceID={$row->RaceID}\"</a>Edit</td>";
                echo "<td><a href=\"delete-race.php?RaceID={$row->RaceID}\"</a>Delete</td>";
                echo "<td><a href=\"view-race.php?RaceID={$row->RaceID}\"</a>View</td>";
                echo "</tr>";
              }
              ?>
            </table>
          </div>
        </div>
      </div>
      <div id="users" class="tab-pane fade">
        <div class="row">
          <div class="col-md-12">
            <p><a href="insert-race.php" class="btn btn-success">Add New User</a></p>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="table-text">UserID</th>
                  <th class="table-text">Email</th>
                  <th class="table-text">Name - Username</th>
                  <th class="table-text">Edit</th>
                  <th class="table-text">Delete</th>
                  <th class="table-text">View</th>
                </tr>
              </thead>
              <?php
              while($userRow = $userStmt->fetchObject()){
                echo "<tr>";
                echo "<td class=\"table-text\">{$userRow->UserID}</td>";
                echo "<td class=\"table-text\">{$userRow->Email}</td>";
                echo "<td class=\"table-text\">{$userRow->Forename} {$userRow->Surname} - {$userRow->Username}</td>";
                echo "<td><a href=\"edit-user.php?UserID={$userRow->UserID}\"</a>Edit</td>";
                echo "<td><a href=\"delete-user.php?UserID={$userRow->UserID}\"</a>Delete</td>";
                echo "<td><a href=\"user-details.php?UserID={$userRow->UserID}\"</a>View</td>";
                echo "</tr>";
              }
              ?>
            </table>
          </div>
        </div>
      </div>
      <div id="files" class="tab-pane fade">
        <div class="row">
          <div class="col-md-12">
            <p><a href="insert-race.php" class="btn btn-success">Add New File</a></p>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="table-text">FileName</th>
                  <th class="table-text">Edit</th>
                  <th class="table-text">Delete</th>
                  <th class="table-text">View</th>
                </tr>
              </thead>
              <?php
               foreach(glob('../images/*.*') as $filename){
                // Removes the directory from the name
                $noDirFile = basename($filename);
                echo "<tr>";
                echo "<td class=\"table-text\">$noDirFile</td>";
                echo "<td><a href=\"edit-user.php\"</a>Edit</td>";
                echo "<td><a href=\"delete-user.php\"</a>Delete</td>";
                echo "<td><a href=\"user-details.php\"</a>View</td>";
                echo "</tr>";
              }
              ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="container">
      <p class="text-muted">&copy 2017 UK Cycling Events</p>
    </div>
  </footer>


</body>
</html>
