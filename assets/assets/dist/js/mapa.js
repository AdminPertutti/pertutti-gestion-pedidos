window.onload = function() {

var mapOptions = {
center:new google.maps.LatLng(-34.7756444,-58.3933317),
zoom:13,
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

var infoWindow;
infoWindow = new google.maps.InfoWindow;
// Try HTML5 geolocation.
       if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(function(position) {
           var pos = {
             lat: position.coords.latitude,
             lng: position.coords.longitude
           };

           //infoWindow.setPosition(pos);
           //infoWindow.setContent('Location found.');
           //infoWindow.open(map);
           map.setCenter(pos);
         }, function() {
           handleLocationError(true, infoWindow, map.getCenter());
         });
       } else {
         // Browser doesn't support Geolocation
         handleLocationError(false, infoWindow, map.getCenter());
       }

       function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: No autorizaste la localización.' :
                              'Error: El navegador no soporta la localización');
        infoWindow.open(map);
      }


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
        //autoSrc.setBounds(circle.getBounds());
      });
    }
  }


  $(document).ready(function() {
    document.getElementById('dirSource').focus();
    document.getElementById("loading").style.display = "none";
    geolocate();
    $('#dirSource').keyup(function(event){
      event.preventDefault();
          if (event.keyCode === 13){ //Si se pulsa enter
          codeAddress();
          }
      });
      //Funcion para sacar los acentos
      var normalize = (function() {
      var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};

        for(var i = 0, j = from.length; i < j; i++ )
        mapping[ from.charAt( i ) ] = to.charAt( i );

        return function( str ) {
          var ret = [];
          for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
            }
            return ret.join( '' );
          }

          })();

    $('#reset').on('click' , function(){ //Funcion para Resetear la búsqueda
      $('#costo').html("");
      $('#distancia').html("");
      $('#tiempo').html("");
      document.getElementById("dirSource").disabled = false;
      document.getElementById("calcular").disabled = false;
      document.getElementById('dirSource').focus();
    })

    $('#calcular').on('click' , function(){ //Función para calcular el costo de envío
      var direccion = document.getElementById('dirSource').value;
      var local = document.getElementById('direccion').value;
      var precio = document.getElementById('precio').value;
      document.getElementById("dirSource").disabled = true;
      document.getElementById("calcular").disabled = true;
      document.getElementById("loading").style.display = "block";

      direccion = normalize(direccion);
      local = normalize(local);
      var request = $.ajax('/assets/dist/js/mapa.php',  //Hace el requerimiento a mapa.php
        {
        type: 'POST',
        data: {'destino': direccion,
                'inicio': local},
        dataType: 'json'
      });
      request.done(function(response){
            var distancia = parseFloat(response['rows'][0]['elements'][0]['distance'].text);
            var tiempo = parseFloat(response['rows'][0]['elements'][0]['duration'].text);
            var costo = Math.round(distancia * precio, 1);
            var minimo = precio * 2;
            if (costo <= minimo) {
              costo = 80;
            } else if ((costo >= 50) && (costo <= 130)) {
              costo = 130;
            } else if ((costo >= 131) && (costo <= 150)) {
              costo = 160;
            } else if ((costo >= 151) && (costo <= 195)) {
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
          document.getElementById("loading").style.display = "none";
        });

      request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
      });

    });

  });
