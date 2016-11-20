var geocoder = null;
var localizaciones = null;

/**
 *
 * @param path
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
 * @param loc
 * @returns {Object}
 */
function convertMap2Info(loc) {
    var item = new Object();

    item.calle = "";
    item.numero = "";
    item.cp = "";
    item.poblacion = "";
    item.provincia = "";
    item.direccion = "";
    item.provincia_id = "";

    for (var j = 0; j < loc.address_components.length; j++) {
        var obj = loc.address_components[j];
        var type = obj['types'][0];
        switch (type) {
            case 'street_number':
                item.numero = loc.address_components[j]['long_name'];
                break;
            case 'route':
                item.calle = loc.address_components[j]['long_name'];
                break;
            case 'postal_code':
                item.cp = loc.address_components[j]['long_name'];
                item.provincia_id = item.cp.substr(0, 2);
                break;
            case 'locality':
                item.poblacion = loc.address_components[j]['long_name'];
                break;
            case 'administrative_area_level_1':
                if (item.provincia == '') {
                    item.provincia = loc.address_components[j]['long_name'];
                }
                break;
            case 'administrative_area_level_2':
                item.provincia = loc.address_components[j]['long_name'];

                break;
        }
    }
    item.lat = loc.geometry.location.lat();
    item.lng = loc.geometry.location.lng();
    item.direccion = loc.formatted_address;

    return item;
}

/**
 *
 * @param {type} opts
 * @returns {String}
 */
var getMap = function (opts, center) {
    // Mapa
    var src = "http://maps.googleapis.com/maps/api/staticmap?", params = $.extend({
        center: 'Lisboa, Spain',
        markers: 'Madrid, Spain',
        zoom: 16,
        size: '640x240',
        maptype: 'roadmap',
        sensor: true
    }, opts), query = [];

    $.each(params, function (k, v) {
        query.push(k + '=' + encodeURIComponent(v));
    });
    src += query.join('&');

    var img = '<p style="width:100%;float:right"><img src="' + src + '" alt="" class="img-responsive"></p>';

    // Ver mapa m�s grande
    src = "http://maps.google.com/maps?hl=es&iwloc=A&ll=" + opts.markers + "&center=" + opts.center;

    var link = '<br><p style="float:right"><a href="' + src + '" target="_blank">Ver mapa m&aacute;s grande</a></p>';

    return img + link;
}

/**
 *
 * @param direccion
 * @param callback
 */
var getMapAddresses = function (direccion, callback) {
    if (geocoder == null) {
        geocoder = new google.maps.Geocoder();
    }

    geocoder.geocode({'address': direccion}, function (results, status) {

        if (status != google.maps.GeocoderStatus.OK) {
            return;
        }

        $.map(results, function (loc) {
            callback(convertMap2Info(loc));
        });
    });
}

/**
 *
 * @param lat
 * @param lng
 * @param callback
 */
var getMapAddressByPos = function (lat, lng, callback) {
    if (geocoder == null) {
        geocoder = new google.maps.Geocoder();
    }

    var latlng = new google.maps.LatLng(lat, lng);

    geocoder.geocode({'latLng': latlng}, function (results, status) {

        if (status != google.maps.GeocoderStatus.OK) {
            return;
        }

        $.map(results, function (loc) {
            callback(convertMap2Info(loc));
        });
    });
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
    getMapAddresses(direccion, function (item) {
        localizaciones[localizaciones.length] = item;
        var html = '<p><a class="bootbox-close-button" href="#" rel="' + localizaciones.length + '">' + item.direccion + '</a></p>';
        $("#buscarMapa_results").append(html);
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
        var id = parseInt(this.rel) - 1;
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

/**
 *
 * @param poly
 * @param imageUrl
 */
function map_addDeleteButton(poly, imageUrl) {
    var path = poly.getPath();
    path["btnDeleteClickHandler"] = {};
    path["btnDeleteImageUrl"] = imageUrl;

    google.maps.event.addListener(poly.getPath(),'set_at', map_pointUpdated);
    google.maps.event.addListener(poly.getPath(),'insert_at', map_pointUpdated);
}

/**
 *
 * @param imageUrl
 * @returns {*|jQuery|HTMLElement}
 */
function map_getDeleteButton(imageUrl) {
    return jQuery("img[src$='" + imageUrl + "']");
}

/**
 *
 * @param index
 */
function map_pointUpdated(index) {
    var path = this;
    var btnDelete = map_getDeleteButton(path.btnDeleteImageUrl);

    if(btnDelete.length === 0) {
        var undoimg = jQuery("img[src*='maps.gstatic.com/mapfiles/undo_poly.png']");

        undoimg.parent().css('height', '21px !important');
        undoimg.parent().parent().append('<div style="overflow-x: hidden; overflow-y: hidden; position: absolute; width: 30px; height: 27px;top:21px;"><img src="' + path.btnDeleteImageUrl + '" class="deletePoly" style="height:auto; width:auto; position: absolute; left:0;"/></div>');

        // now get that button back again!
        btnDelete = map_getDeleteButton(path.btnDeleteImageUrl);
        btnDelete.hover(function() {
            jQuery(this).css('left', '-30px');
            return false;
        },
        function() {
            jQuery(this).css('left', '0px');
            return false;
        });
        btnDelete.mousedown(function() { jQuery(this).css('left', '-60px'); return false;});
    }

    // if we've already attached a handler, remove it
    if(path.btnDeleteClickHandler) {
        btnDelete.unbind('click', path.btnDeleteClickHandler);
    }
    // now add a handler for removing the passed in index
    path.btnDeleteClickHandler = function() {
        path.removeAt(index);
        return false;
    };
    btnDelete.click(path.btnDeleteClickHandler);

    $('#dataPolygons_hidden').val(maps_getPolygonsField(selectedShape.getPaths()));
}
