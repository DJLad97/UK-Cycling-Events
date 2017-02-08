function raceLocation()
{
  $.get('get-race-location.php', function(data){
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 53.270722, lng: -1.820286},
      zoom: 6,
      styles:
      [{"featureType":"landscape","stylers":[{"hue":"#FFA800"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#53FF00"},{"saturation":-73},{"lightness":40},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FBFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#00FFFD"},{"saturation":0},{"lightness":30},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00BFFF"},{"saturation":6},{"lightness":8},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#679714"},{"saturation":33.4},{"lightness":-25.4},{"gamma":1}]}]
  });

    var latLng = ConvertToLatLng(data);
    var marker = new google.maps.Marker({
      position: latLng,
      map: map
    });

  }, 'json');

}

function ConvertToLatLng(coords){
  var latLng = coords.split(/, ?/);
  return new google.maps.LatLng(parseFloat(latLng[0]), parseFloat(latLng[1]));
}
