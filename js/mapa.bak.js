(function(mapDemo, $, undefined) {
mapDemo.Directions = (function() {
function _Directions() {
var map,
directionsService, directionsDisplay,
autoSrc, autoDest,
$Selectors = {
dirSrc: jQuery('#dirSource'),
paneResetBtn: jQuery('#paneReset')
},
autoCompleteSetup = function() {
autoSrc = new google.maps.places.Autocomplete($Selectors.dirSrc[0]);
},

trafficSetup = function() {
var controlDiv = document.createElement('div'),
controlUI = document.createElement('div'),
trafficLayer = new google.maps.TrafficLayer();
jQuery(controlDiv).addClass('gmap-controlcontainer').addClass('gmnoprint');
jQuery(controlUI).text('Traffic').addClass('gmap-control');
jQuery(controlDiv).append(controlUI);
google.maps.event.addDomListener(controlUI, 'click', function() {
if (typeof trafficLayer.getMap() == 'undefined' ||
trafficLayer.getMap() === null) {
jQuery(controlUI).addClass('gmap-control-active');
trafficLayer.setMap(map);
} else {
trafficLayer.setMap(null);
jQuery(controlUI).removeClass('gmap-control-active');
}
});
map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
},
mapSetup = function() {
map = new google.maps.Map(document.getElementById("mapa2"), {
zoom: 15,
center: new google.maps.LatLng(-34.7756444,-58.3933317),
mapTypeControl: false,
mapTypeControlOptions: {
style: google.maps.MapTypeControlStyle.DEFAULT,
position: google.maps.ControlPosition.TOP_RIGHT
},
panControl: true,
panControlOptions: {
position: google.maps.ControlPosition.RIGHT_TOP
},
zoomControl: true,
zoomControlOptions: {
style: google.maps.ZoomControlStyle.LARGE,
position: google.maps.ControlPosition.RIGHT_TOP
},
scaleControl: true,
streetViewControl: false,
overviewMapControl: false,
mapTypeId: google.maps.MapTypeId.ROADMAP
});
autoCompleteSetup();
trafficSetup();
},
directionsRender = function(source, destination) {
$Selectors.dirSteps.find('.msg').hide();
directionsDisplay.setMap(map);
var request = {
origin: source,
destination: destination,
provideRouteAlternatives: false,
travelMode: google.maps.DirectionsTravelMode.DRIVING
};
directionsService.route(request, function(response, status) {
if (status == google.maps.DirectionsStatus.OK) {
directionsDisplay.setDirections(response);
}
});
},
fetchAddress = function(p) {
  var Position = new google.maps.LatLng(p.coords.latitude,
  p.coords.longitude),
  Locater = new google.maps.Geocoder();
  Locater.geocode({'latLng': Position}, function (results, status) {
  //if (status == google.maps.GeocoderStatus.OK) {
  //var _r = results[0];
  //$Selectors.dirSrc.val(_r.formatted_address);
//  }
  });
  },
_init = function() {
mapSetup();
};
this.init = function() {
_init();
return this;
}
return this.init(); // Refers to: mapDemo.Directions.init()
}
return new _Directions(); // Creating a new object of _Directions rather than

}());
})(window.mapDemo = window.mapDemo || {}, jQuery);
window.onload = function() {
var mapOptions = {
center:new google.maps.LatLng(-34.7756444,-58.3933317),
zoom:15,
mapTypeControl: false,
mapTypeControlOptions: {
style: google.maps.MapTypeControlStyle.DEFAULT,
position: google.maps.ControlPosition.TOP_RIGHT
},
panControl: true,
panControlOptions: {
position: google.maps.ControlPosition.RIGHT_TOP
},
zoomControl: true,
zoomControlOptions: {
style: google.maps.ZoomControlStyle.LARGE,
position: google.maps.ControlPosition.RIGHT_TOP
},
scaleControl: true,
streetViewControl: false,
overviewMapControl: false,
mapTypeId: google.maps.MapTypeId.ROADMAP
 };


map = new google.maps.Map(document.getElementById("mapa"), mapOptions);
var marker;
geocoder = new google.maps.Geocoder();
//codeAddress(geocoder, map);

google.maps.event.addListener(map, 'click', function(event) {
   placeMarker(event.latLng);
});



function placeMarker(location) {

    if (marker == null)
    {
          marker = new google.maps.Marker({
             position: location,
             map: map
          });
    }
    else
    {
        marker.setPosition(location);
    }
}
}

function codeAddress() {
  elemento = document.getElementById('dirSource');
  elemento.blur();
  boton = document.getElementById('boton');
  boton.focus();
  var address = document.getElementById('dirSource').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.panTo(results[0].geometry.location);
        map.setZoom(16);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });

      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
