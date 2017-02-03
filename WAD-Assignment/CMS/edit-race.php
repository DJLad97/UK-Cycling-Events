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
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <title>EDIT <?php echo $row->RaceName; ?></title>
</head>
<body>
  <?php include('header.php'); ?>
  <div class="container well">
    <div class="page-header">
      <h1>EDIT <?php echo $row->RaceName; ?></h1>
    </div>
    <?php $string = '../insert-race.php?fromCMS=true&RaceID=' . $raceID;?>
    <form method="post" id="add-race-form" action="<?php echo $string; ?>">
      <div class="page-header">
        <h2>EDIT RACE</h2>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Race Type</label>
            <select name="raceType" class="form-control">
              <option value="">Select</option>
              <option value="MTB" <?php if($row->RaceType == 'MTB') echo 'selected';?>>MTB</option>
              <option value="Road" <?php if($row->RaceType == 'Road') echo 'selected';?>>Road</option>
            </select>
          </div>
          <div class="form-group">
            <label>Organiser Name *</label>
            <input type="text" class="form-control" name="organiserName" placeholder="Sheffield MTB" value="<?php echo $row->OrganiserName; ?>"/>
          </div>
          <div class="form-group">
            <label>Organiser Enquiry Email *</label>
            <input type="text" class="form-control" name="organiserEmail" placeholder="organiser@race.com" value="<?php echo $row->OrganiserEmail; ?>"/>
          </div><hr>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Race Name *</label>
            <input type="text" class="form-control" name="raceName" placeholder="MTB Race - Round 1" value="<?php echo $row->RaceName; ?>"/>
          </div>
          <div class="form-group">
            <label>Closing Entry Date *</label>
            <input type="text" class="form-control" id="closingEntryDate" name="closingEntryDate" value="<?php echo $row->ClosingEntryDate; ?>" readonly="readonly"/>
          </div>
          <div class="form-group">
            <label id="test">Race Start Date *</label>
            <input type="text" class="form-control" id="startDate" name="raceStartDate" value="<?php echo $row->RaceDate; ?>" readonly="readonly"/>
            <hr>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Is your race free to enter? *</label>
            <select name="isFree" id="isFreeDropdown" class="form-control">
              <option value="">Select</option>
              <option value="yes">Yes</option>
              <option value="no">No</option>
            </select>
          </div>
          <div class="form-group" id="priceTextBox">
            <label>Entry Price</label>
            <input type="text" class="form-control" name="entryPrice" placeholder="£10.00" value="<?php echo $row->EntryPrice; ?>"/>
          </div>
          <div class="form-group">
            <label>Race Description</label>
            <textarea type="comments" class="form-control" name="raceDesc" placeholder="Provide your race description here to make your race more appealing"><?php echo $row->RaceDescription; ?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Race Address *</label>
            <input type="text" class="form-control" name="raceAddress" value="<?php echo $row->RaceAddress; ?>" placeholder="Address of race start location"/>
          </div>
          <div class="form-group">
            <label>Race Postcode *</label>
            <input type="text" class="form-control" name="racePostcode" value="<?php echo $row->RacePostcode; ?>" placeholder="S11 7TT"/>
          </div>
          <div class="form-group">
            <label>Race Latitude *</label> <label><small>Click on the map to get your latitude and longitude</small></label>
            <input type="text" class="form-control" id="latLong" name="raceLatLong" value="<?php echo $row->RaceLatLong; ?>" readonly="readonly"/>
            <hr>
          </div>
        </div>
        <div class="col-md-4">
          <div id="map"></div>
        </div>
      </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Update" class="btn btn-primary btn-lg" />
        </div>
        <br />
    </form>
  </div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh5LqX12YrJlbySaXrwof1R7XcAURBK1M&callback=myMap"></script>
</body>
</html>
