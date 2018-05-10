function initMap() {
    var mapa = new google.maps.Map(document.getElementById('mapa'));
    new autocompletadoDirecciones(mapa);
}

function autocompletadoDirecciones() {
    var origen = document.getElementById('origen');
    var destino = document.getElementById('destino');

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
}
