<?php
  require('includes/conn.inc.php');
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

  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/meanmenu.css">
  <link rel="stylesheet" href="css/animate.css">
  <script src="js/main.js"></script>
  <script src="js/race-validation.js"></script>
  <script src="js/google-maps.js"></script>

  <script src="js/jquery.easing.js"></script>
  <script src="js/jquery.meanmenu.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <title>Add Race</title>


</head>
<body>
  <?php include('includes/modals.php'); ?>
  <?php include('includes/navbar.php'); ?>
  <div class="container well-custom">
     <div class="form-container">
       <?php
          if(isset($_SESSION['error'])) {
            ?>
            <div class="alert alert-danger">
            <?php
              foreach($_SESSION['error'] as $e) {
                ?>
                <i class="glyphicon glyphicon-warning-sign"> &nbsp; <?php echo $e; ?></i>
                <?php
              }
            }
       ?>
           </div>
        <form method="post" id="add-race-form" action="insert-race.php">
          <div class="page-header">
            <h2>ADD RACE</h2>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Race Type</label>
                <select name="raceType" class="form-control">
                  <option value="">Select</option>
                  <option value="MTB">MTB</option>
                  <option value="Road">Road</option>
                </select>
              </div>
              <div class="form-group">
                <label>Organiser Name *</label>
                <input type="text" class="text-box" name="organiserName" placeholder="Sheffield MTB"/>
              </div>
              <div class="form-group">
                <label>Organiser Enquiry Email *</label>
                <input type="text" class="text-box" name="organiserEmail" placeholder="organiser@race.com"/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Race Name *</label>
                <input type="text" class="text-box" name="raceName" placeholder="MTB Race - Round 1"/>
              </div>
              <div class="form-group">
                <label>Closing Entry Date *</label>
                <input type="text" class="text-box" id="closingEntryDate" name="closingEntryDate" readonly="readonly"/>
              </div>
              <div class="form-group">
                <label id="test">Race Start Date *</label>
                <input type="text" class="text-box" id="startDate" name="raceStartDate" readonly="readonly"/>

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Race Address *</label>
                <input type="text" class="text-box" name="raceAddress" placeholder="Address of race start location"/>
              </div>
              <div class="form-group">
                <label>Race Postcode *</label>
                <input type="text" class="text-box" name="racePostcode" placeholder="S11 7TT"/>
              </div>
              <div class="form-group">
                <label>Race Latitude *</label> <label><small>Click on the map to get your latitude and longitude</small></label>
                <input type="text" class="text-box" id="latLong" name="raceLatLong" readonly="readonly"/>

              </div>
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
                <input type="text" class="text-box" name="entryPrice" placeholder="£10.00" />
              </div>
              <div class="form-group">
                <label>Race Description</label>
                <textarea type="comments" class="text-box" name="raceDesc" placeholder="Provide your race description here to make your race more appealing"></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div id="map"></div>
            </div>
          </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Submit" class="modal-btn" />
            </div>
            <br />
        </form>
       </div>
  </div>

  <!-- <script src="https://maps.googleapis.com/maps/api/staticmap?key=AIzaSyAh5LqX12YrJlbySaXrwof1R7XcAURBK1M&callback=myMap&center=53.396165815536776,-1.2774063110351896&zoom=10&format=png&maptype=roadmap&style=element:geometry%7Ccolor:0xebe3cd&style=element:labels.text.fill%7Ccolor:0x523735&style=element:labels.text.stroke%7Ccolor:0xf5f1e6&style=feature:administrative%7Celement:geometry.stroke%7Ccolor:0xc9b2a6&style=feature:administrative.land_parcel%7Celement:geometry.stroke%7Ccolor:0xdcd2be&style=feature:administrative.land_parcel%7Celement:labels.text.fill%7Ccolor:0xae9e90&style=feature:landscape.natural%7Celement:geometry%7Ccolor:0xdfd2ae&style=feature:poi%7Celement:geometry%7Ccolor:0xdfd2ae&style=feature:poi%7Celement:labels.text.fill%7Ccolor:0x93817c&style=feature:poi.park%7Celement:geometry.fill%7Ccolor:0xa5b076&style=feature:poi.park%7Celement:labels.text.fill%7Ccolor:0x447530&style=feature:road%7Celement:geometry%7Ccolor:0xf5f1e6&style=feature:road.arterial%7Celement:geometry%7Ccolor:0xfdfcf8&style=feature:road.highway%7Cvisibility:off&style=feature:road.highway%7Celement:geometry%7Ccolor:0xf8c967&style=feature:road.highway%7Celement:geometry.stroke%7Ccolor:0xe9bc62&style=feature:road.highway.controlled_access%7Celement:geometry%7Ccolor:0xe98d58&style=feature:road.highway.controlled_access%7Celement:geometry.stroke%7Ccolor:0xdb8555&style=feature:road.local%7Celement:labels.text.fill%7Ccolor:0x806b63&style=feature:transit.line%7Celement:geometry%7Ccolor:0xdfd2ae&style=feature:transit.line%7Celement:labels.text.fill%7Ccolor:0x8f7d77&style=feature:transit.line%7Celement:labels.text.stroke%7Ccolor:0xebe3cd&style=feature:transit.station%7Celement:geometry%7Ccolor:0xdfd2ae&style=feature:water%7Celement:geometry.fill%7Ccolor:0xb9d3c2&style=feature:water%7Celement:labels.text.fill%7Ccolor:0x92998d&size=480x360"></script> -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh5LqX12YrJlbySaXrwof1R7XcAURBK1M&callback=myMap"></script>
</body>
</html>
