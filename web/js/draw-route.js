function initMap() {
    var mapa = new google.maps.Map(document.getElementById('mapa'), {
        mapTypeControl: false,
        center: {lat: 36.777035, lng: -6.352707},
        zoom: 14
    });
    var mapaResponsive = new google.maps.Map(document.getElementById('mapaResponsive'), {
        mapTypeControl: false,
        center: {lat: 36.777035, lng: -6.352707},
        zoom: 14
    });
    var geocoder = new google.maps.Geocoder();
    var origen = document.getElementById('origen').value;
    var destino = document.getElementById('destino').value;

    new AutocompleteDirectionsHandler(mapa);
    calcRoute(origen, destino, geocoder, mapa);
    new AutocompleteDirectionsHandler(mapaResponsive);
    calcRoute(origen, destino, geocoder, mapaResponsive);
}

function calcRoute(origen, destino, geocoder, mapa) {
    var latLngOri, latLngDest;
    var latLngOrigen = new Array(2);
    geocoder.geocode({'address': origen}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            latLngOrigen[0] = results[0].geometry.location.lat();
            latLngOrigen[1] = results[0].geometry.location.lng();
            latLngOri = latLngOrigen.join();
            var latLngDestino = new Array(2);
            geocoder.geocode({'address': destino}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    latLngDestino[0] = results[0].geometry.location.lat();
                    latLngDestino[1] = results[0].geometry.location.lng();
                    latLngDest = latLngDestino.join();
                    var request = {
                        origin: latLngOri,
                        destination: latLngDest,
                        travelMode: google.maps.TravelMode.DRIVING
                    };
                    var directionsService = new google.maps.DirectionsService();
                    var directionsDisplay = new google.maps.DirectionsRenderer;
                    directionsService.route(request, function(response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                            directionsDisplay.setMap(mapa);
                        } else {
                            alert("Error: " + status);
                        }
                    });
                } else {
                    console.log("Geocode was not successful for the following reason: " + status);
                }
            });
        } else {
            console.log("Geocode was not successful for the following reason: " + status);
        }
    });
}
