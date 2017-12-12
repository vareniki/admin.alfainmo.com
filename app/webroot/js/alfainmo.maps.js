var searchManager = null;
var localizaciones = null;
var map = null;

function geocodeQuery(query, callBackFunc) {
    var searchRequest = {
        where: query,
        callback: function (r) {
            callBackFunc(r);
        },
        errorCallback: function (e) {
            alert("No results found.");
        }
    };

    searchManager.geocode(searchRequest);
}

/**
 *
 * @param direccion
 * @param callback
 */
var getMapAddresses = function (direccion, callback) {

    Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
        searchManager = new Microsoft.Maps.Search.SearchManager(map);
        geocodeQuery(direccion, callback);
    });
}


/**
 *
 * @param path
 * @returns {string}
 */
function maps_getPolygonsField(path) {

    var polygons = new Array();

    path.forEach(function(poli) {
        var polygon = new Array();
        poli.forEach(function(path) {

            var line = path.lat() + "," + path.lng();
            polygon.push(line);
        });
        polygons.push(polygon);
    });

    return polygons.join('^');
}

/**
 *
 * @param {type} opts
 * @returns {String}
 */

var getMap = function (opts) {

    $("#mapResult").css({'height': '200px'});

    map = new Microsoft.Maps.Map('#mapResult', {
        center: new Microsoft.Maps.Location(opts.latitude, opts.longitude),
        disableZooming: true,
        mapTypeId: Microsoft.Maps.MapTypeId.road, zoom: 15 }
    );
}

/**
 *
 * @returns {string}
 */
function maps_get_html_dialog() {
    var result = '<form id="buscarMapa_form" class="form-inline" action="#">';
    result += '<div class="input-group">';
    result += '<input type="text" class="form-control col-xs-12" id="buscarMapa_input" placeholder="ej.: calle palos de la frontera 4, madrid" autofocus>';
    result += '<span class="input-group-btn"><button id="buscarMapa_button" class="btn btn-default" type="button">Buscar</button></span>';
    result += '</div>';
    result += '</form><br>';
    result += '<div id="buscarMapa_results"></div>';

    return result;
}

/**
 *
 * @param direccion
 * @param pais
 */
function maps_begin_search(direccion, pais) {
    if (direccion.length < 3) {
        return;
    }
    direccion += "," + pais;

    localizaciones = Array();

    $("#buscarMapa_results").empty();
    getMapAddresses(direccion, function (items) {

        for (var i=0; i<items.results.length; i++) {
            localizaciones[i] = items.results[i];
            $("#buscarMapa_results").append(
                '<p><a class="bootbox-close-button" href="#" rel="' + i+ '">' + items.results[i].name + '</a></p>'
            );
        }
    });

}

/**
 *
 * @param properties
 * @param callback
 * @returns {*}
 */
function maps_dialog(properties, callback) {
    var dialog_obj = bootbox.dialog({
        message: maps_get_html_dialog(properties.pais),
        title: properties.title + ' en ' + properties.pais,
        buttons: {
        }
    });


    $("#buscarMapa_input").on("keyup", function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            maps_begin_search(this.value, properties.pais);
        }
    }).on("keypress", function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    $("#buscarMapa_button").on("click", function () {
        maps_begin_search($("#buscarMapa_input").val(), properties.pais);
    });

    $("#buscarMapa_results").on("click", "a", function () {
        var id = parseInt(this.rel);
        callback(localizaciones[id]);

        return true;
    });


    $(dialog_obj).on('shown.bs.modal', function () {
        $("#buscarMapa_input").focus();
    });

    return dialog_obj;
}

/**
 *
 * @param markers
 * @param infoWindowContent
 */
function maps_createMarkers(markers, infoWindowContent) {

    var bounds = new google.maps.LatLngBounds();
    var mapOptions = { mapTypeId: 'roadmap' };

    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    var icons = [
        iconURLPrefix + 'blue-dot.png',
        iconURLPrefix + 'red-dot.png'
    ]

    // Display a map on the page
    var map = new google.maps.Map(jQuery("#map_canvas")[0], mapOptions);
    map.setTilt(45);

    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

    // Loop through our array of markers & place each one on the map
    var position = null;
    for (i = 0; i < markers.length; i++) {
        position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);

        var icon_image = icons[markers[i][3]];

        marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: icon_image,
            title: markers[i][0]
        });

        // Allow each marker to have an info window
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));
    }
    // Automatically center the map fitting all markers on the screen
    map.fitBounds(bounds);

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });

    jQuery('a#lnk-mapa').on('shown.bs.tab', function (e) {
        google.maps.event.trigger(map, 'resize');
        if (position != null) {
            map.setCenter(position);
        }
    });

}
