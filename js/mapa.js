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
autoSrc = new google.maps.places.Autocomplete((document.getElementById("dirSource")), { types: ['geocode'] });
//codeAddress(geocoder, map);


};

function codeAddress() {
  if (typeof marker != 'undefined') {
  marker.setMap(null);
  }
  var address = document.getElementById('dirSource').value;
  geocoder = new google.maps.Geocoder();
  geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.panTo(results[0].geometry.location);
        map.setZoom(16);
        var marker = new google.maps.Marker({
            map: map,
            title: "Dirección de entrega",
            position: results[0].geometry.location
        });
      } else {
        //alert('Error: ' + status);
      }
    });
  };

  function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = new google.maps.LatLng(
            position.coords.latitude, position.coords.longitude);
        var circle = new google.maps.Circle({
          center: geolocation,
          radius: position.coords.accuracy
        });
        autoSrc.setBounds(circle.getBounds());
      });
    }
  }

  $(document).ready(function() {
    $('#dirSource').on('change',function(){
      //codeAddress();
      });

    $('#calcular').on('click' , function(){
      var direccion = document.getElementById('dirSource').value;
      var direccionconsulta = direccion.replace(/\s/g,"+");
      var consulta = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=espana+299+lomas+de+zamora&destinations="+direccionconsulta+"&mode=car&language=es-SP&key=AIzaSyBGzi4W4pDJNiB2VCpjIA3yKSvJDTsX-3o"
      $.ajax('mapa.php', {
        type: 'POST',
        dataType: 'json',
        data: {'consulta': direccion }

      })
      .done(function(response){
            var distancia = parseFloat(response['rows'][0]['elements'][0]['distance'].text);
            var tiempo = parseFloat(response['rows'][0]['elements'][0]['duration'].text);

            var costo = Math.round(distancia * 37,1);
            if (costo <= 74) {
              costo = 50;
            } else if ((costo >= 75) && (costo <= 100)) {
              costo = 100;
            } else if ((costo >= 101) && (costo <= 130)) {
              costo = 130;
            } else if ((costo >= 131) && (costo <= 150)) {
              costo = 160;
            } else if ((costo >= 151) && (costo <= 180)) {
              costo = 200;
            } else if ((costo >= 181) && (costo <= 195)) {
              costo = 200;
            } else if ((costo >= 196) && (costo <= 220)) {
              costo = 250;
            } else if ((costo >= 221) && (costo <= 280)) {
              costo = 300;
            } else if ((costo >= 281) && (costo <= 350)) {
              costo = 350;
            } else if ((costo >= 351) && (costo <= 400)) {
              costo = 400;
            } else if (costo >= 401) {

            }

          $('#costo').html(costo);
          $('#distancia').html(distancia);
          $('#tiempo').html(tiempo);
      });

    });

  });
