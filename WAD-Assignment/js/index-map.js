//Add some warning color to indicate that the closing entry date is coming up

function mtbMap()
{
  var latLng;
  var infowindow = new google.maps.InfoWindow();
  $.get('get-mtb-details.php', function(data){

    var map = new google.maps.Map(document.getElementById('mtbMap'), {
      center: {lat: 53.270722, lng: -1.820286},
      zoom: 6,
      styles:
      [{"featureType":"landscape","stylers":[{"hue":"#FFA800"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#53FF00"},{"saturation":-73},{"lightness":40},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FBFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#00FFFD"},{"saturation":0},{"lightness":30},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00BFFF"},{"saturation":6},{"lightness":8},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#679714"},{"saturation":33.4},{"lightness":-25.4},{"gamma":1}]}]
  });
    google.maps.event.trigger(map, 'resize');
    // console.dir(data);

    for(var i = 0; i < data.length; i++){
      latLng = ConvertToLatLng(data[i].RaceLatLong);

      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: data[i].RaceName
      });

      var model = 'login-model';
      var style = 'block';
      var queryString = '<a class="non-nav" href="race-sign-up.php?RaceID=' + data[i].RaceID + '">'

      var content = '<strong>' + data[i].RaceType + ' Race<br>' + data[i].RaceName +
                    '<br></strong>' + moment(data[i].RaceDate).format('LL') + '<br>' + queryString + 'More Information »</a>';

      google.maps.event.addListener(marker, 'click',
          function(marker, content, infowindow){

            return function() {
              infowindow.setContent(content);
              infowindow.open(map,marker);
            };
          }(marker, content, infowindow));

    }
  }, 'json');

  var latLng2;
  var infowindow2 = new google.maps.InfoWindow();
  $.get('get-road-details.php', function(data){

    var map2 = new google.maps.Map(document.getElementById('roadMap'), {
      center: {lat: 53.270722, lng: -1.820286},
      zoom: 6,
      styles:
      [{"featureType":"landscape","stylers":[{"hue":"#FFA800"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#53FF00"},{"saturation":-73},{"lightness":40},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FBFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#00FFFD"},{"saturation":0},{"lightness":30},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00BFFF"},{"saturation":6},{"lightness":8},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#679714"},{"saturation":33.4},{"lightness":-25.4},{"gamma":1}]}]
  });
    google.maps.event.trigger(map2, 'resize');
    // console.dir(data);

    for(var i = 0; i < data.length; i++){
      latLng2 = ConvertToLatLng(data[i].RaceLatLong);

      var marker2 = new google.maps.Marker({
        position: latLng2,
        map: map2,
        title: data[i].RaceName
      });

      var queryString2 = '<a class="non-nav" href="race-sign-up.php?RaceID=' + data[i].RaceID + '">'

      var content2 = '<strong>' + data[i].RaceType + ' Race<br>' + data[i].RaceName +
                    '<br></strong>' + moment(data[i].RaceDate).format('LL') + '<br>' + queryString2 + 'More Information »</a>';

      google.maps.event.addListener(marker2, 'click',
          function(marker2, content2, infowindow2){

            return function() {
              infowindow.setContent(content2);
              infowindow.open(map2,marker2);
            };
          }(marker2, content2, infowindow2));

    }
  }, 'json');
}

function ConvertToLatLng(coords){
  var latLng = coords.split(/, ?/);
  return new google.maps.LatLng(parseFloat(latLng[0]), parseFloat(latLng[1]));
}
