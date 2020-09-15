var map, Microsoft, directionsManager;


//Conseguimos la localización del cliente y nos devuelve un objeto con coordenadas
// showPosition es la función que ejecutará si la encuentra, le manda la posición 

navigator.geolocation.getCurrentPosition(showPosition);

/*
 * Función que crea un mapa en un div con id myMap
 */
function GetMap() {
    map = new Microsoft.Maps.Map('#myMap', { mapTypeId: Microsoft.Maps.MapTypeId.aerial, zoom: 10 });
    Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function() {
        directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);
        directionsManager.setRenderOptions({ itineraryContainer: '#directionsItinerary' });
        directionsManager.showInputPanel('directionsPanel');
    });
}

/**
 * Recibe la localidad del piso del anuncio y la enseña en el mapa
 * @param {string} localidad
 */
function localidadDestino(localidad) {
    $('#destino').val(localidad);
    if ($('#origen').val() === '') {
        $('#origen').val(direccion);
    }
    GetDirections();
}


/*
 * Función para conseguir las coordenadas del navegador cliente.
 */
function showPosition(position) {
    let lat = position.coords.latitude;
    let long = position.coords.longitude;
    let direccion = lat + "," + long;
    $('#origen').val(direccion);
    GetDirections();
}

/*
 * Función que le agrega al mapa el origen y el destino de la ruta
 */
function GetDirections() {
    //Limpiamos la variables
    directionsManager.clearAll();
    directionsManager.clearDisplay();
    //Crea los waypoint para la ruta.
    var start = new Microsoft.Maps.Directions.Waypoint({ address: $('#origen').val() });
    var end = new Microsoft.Maps.Directions.Waypoint({ address: $('#destino').val() });
    directionsManager.addWaypoint(start);
    directionsManager.addWaypoint(end);
    directionsManager.calculateDirections();
    directionsManager.calculateDirections();
}