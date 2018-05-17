function AutocompleteDirectionsHandler(mapa) {
    this.mapa = mapa;
    this.originPlaceId = null;
    this.destinationPlaceId = null;
    this.travelMode = 'DRIVING';

    var origen = document.getElementById('origen');
    var destino = document.getElementById('destino');

    this.directionsService = new google.maps.DirectionsService;
    this.directionsDisplay = new google.maps.DirectionsRenderer;
    this.directionsDisplay.setMap(mapa);

    var limite = new google.maps.LatLngBounds(
        new google.maps.LatLng(36.777035, -6.352707),
        new google.maps.LatLng(36.777035, -6.352707));

    var autocompletadoOrigen = new google.maps.places.Autocomplete(
        origen, {
            bounds: limite, types: ['address'], componentRestrictions: {country: 'es'}
        }
    );
    var autocompletadoDestino = new google.maps.places.Autocomplete(
        destino, {
            bounds: limite, types: ['address'], componentRestrictions: {country: 'es'}
        }
    );

    this.setupPlaceChangedListener(autocompletadoOrigen, 'ORIG');
    this.setupPlaceChangedListener(autocompletadoDestino, 'DEST');
}

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
    var me = this;
    autocomplete.bindTo('bounds', this.mapa);
    autocomplete.addListener('place_changed', function() {
        initMap();
        var place = autocomplete.getPlace();
        if (!place.place_id) {
            window.alert('Por favor, seleccione una opción de la lista.');
            return;
        }
        if (mode === 'ORIG') {
            me.originPlaceId = place.place_id;
        } else {
            me.destinationPlaceId = place.place_id;
        }
        me.route();
    });
};

AutocompleteDirectionsHandler.prototype.route = function() {
    if (!this.originPlaceId || !this.destinationPlaceId) {
        return;
    }
    var me = this;
    this.directionsService.route({
        origin: {'placeId': this.originPlaceId},
        destination: {'placeId': this.destinationPlaceId},
        travelMode: this.travelMode
    }, function(response, status) {
        if (status === 'OK') {
            me.directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
};
