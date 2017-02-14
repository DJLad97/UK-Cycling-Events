var sent = false;

function raceLocation()
{
  $.get('http://localhost:4321/UK Cycling Events/WAD-Assignment/get-race-location.php', function(data){
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

    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;

    var input = String(latLng);
    var latlngStr = input.split(',', 2);
    var latlngTest = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
    geocoder.geocode({'location': latLng}, function(results, status) {
      if (status === 'OK') {
        if (results[1]) {
          infowindow.setContent(results[1].formatted_address);
          // console.info(sent);
          //
          // if(!sent){
          //   window.location.href += "&address=" + results[3].formatted_address;
          //   sent = true;
          // }
          infowindow.open(map, marker);
        } else {
          window.alert('No results found');
        }
      } else {
        window.alert('Geocoder failed due to: ' + status);
      }
    });
  }, 'json');

}

function ConvertToLatLng(coords){
  var latLng = coords.split(/, ?/);
  return new google.maps.LatLng(parseFloat(latLng[0]), parseFloat(latLng[1]));
}
