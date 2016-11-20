<?php $this->start('header');

if (!empty($this->request->data['pais_id'])) {
	$pais_id = $this->request->data['pais_id'];
} else {
	$pais_id = $agencia['Pais']['id'];
}
// Coordenadas por país
$lats_lng = array(
	'18' => array(19.24647, -99.10135), // México
	'34' => array(40.41678, -3.70379), // España
	'51' => array(-12.04637, -77.04279), // Perú
	'54' => array(-34.60372, -58.38159), // Argentina
	'593' => array(-0.18065, -78.46784), // Ecuador
	'595' => array(-25.28220, -57.63510), // Paraguay
	'172' => array(12.13639, -86.25139), // Nicaragua
	'507' => array(8.98333, -79.51667), // Panamá
	'57' => array(4.59806, -74.07583)  // Colombia
);

if (isset($lats_lng[$pais_id])) {
	$lat_lng = $lats_lng[$pais_id];
} else {
	$lat_lng = $lats_lng[34];
}?>
	<script type="text/javascript">

		var $modalMap = null;
		var searchMap = null;
		var selectedShape = null;
		var drawingManager = null;
		var searchMarkers = [];

		var capitalLatLng = [];

		<?php foreach ($lats_lng as $key => $value) {
			$value1 = $value[0];
			$value2 = $value[1];
			echo "capitalLatLng[$key]=[$value1,$value2];";
		} ?>

		/**
		 *
		 */
		function map_initShapes() {

			$('#dataPolygons_hidden').val('');
			$("#dataPolygons_clear").attr("disabled", "disabled");
			$("#dataPolygons_assign").attr("disabled", "disabled");

			if (selectedShape) {
				selectedShape.setMap(null);
				maps_createShapes();
			}
		}

		/**
		 * Se ha terminado de dibujar un polígono
		 */
		function map_on_polygonComplete(drawpolygons) {

			map_addDeleteButton(drawpolygons, 'http://admin.alfainmo.com/img/close-buttons.png');
			drawingManager.setOptions({ drawingMode: null });

			$('#dataPolygons_hidden').val(maps_getPolygonsField(drawpolygons.getPaths()));
			$("#dataPolygons_clear").removeAttr("disabled");
			$("#dataPolygons_assign").removeAttr("disabled");
		}

		/**
		 * Cada vez que ha cambiado un lugar
		 */
		function map_on_placesChanged(searchBox) {
			var places = searchBox.getPlaces();

			// For each place, get the icon, place name, and location.
			for (var i=0, marker; marker = searchMarkers[i]; i++) {
				marker.setMap(null);
			}
			searchMarkers = [];
			var bounds = new google.maps.LatLngBounds();
			for (var i=0, place; place = places[i]; i++) {
				var image = {
					url: place.icon,
					size: new google.maps.Size(71, 71),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(17, 34),
					scaledSize: new google.maps.Size(25, 25)
				};

				// Create a marker for each place.
				var marker = new google.maps.Marker({
					map: searchMap,
					icon: image,
					title: place.name,
					position: place.geometry.location
				});

				searchMarkers.push(marker);

				bounds.extend(place.geometry.location);
			}

			searchMap.fitBounds(bounds);

			if (searchMarkers.length == 1) {
				searchMap.setZoom(17);
			} else if (searchMarkers.length == 2) {
				searchMap.setZoom(12);
			}
		}

    /**
     * Se inicializa el diálogo la primera vez
     */
		function maps_initializeDialog() {

			searchMap = new google.maps.Map(document.getElementById('map-search-canvas'), {
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: new google.maps.LatLng(<?php echo $lat_lng[0] ?>,<?php echo $lat_lng[1] ?>),
				maxZoom: 18,
				minZoom: 10,
				zoom: 14,
				scrollwheel: false
			});

	    var searchInput = document.getElementById('map-search-input');

			//searchMap.fitBounds(defaultBounds);
			searchMap.controls[google.maps.ControlPosition.TOP_LEFT].push(searchInput);

			var searchBox = new google.maps.places.SearchBox(searchInput);
			google.maps.event.addListener(searchBox, 'places_changed', function() {
				map_on_placesChanged(searchBox);
				map_initShapes();
			});

			google.maps.event.addListener(searchMap, 'bounds_changed', function () {
				searchBox.setBounds(searchMap.getBounds());
			});

			google.maps.event.addDomListener(document.getElementById('dataPolygons_clear'), 'click', function() {
				map_initShapes();
			});
		}

		/**
		 *
		 */
		function maps_createShapes() {

			drawingManager = new google.maps.drawing.DrawingManager({
				drawingMode: google.maps.drawing.OverlayType.POLYGON,
				drawingControl: false,
				polygonOptions: {
					strokeColor: '#70b08e',
					fillColor: '#70b08e',
					fillOpacity: 0.5,
					strokeWeight: 3,
					clickable: true,
					editable: true,
					dragable: false,
					zIndex: 1
				}
			});

			google.maps.event.addListener(drawingManager, 'polygoncomplete', function(drawpolygons) {
				map_on_polygonComplete(drawpolygons);
			});

			google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
				selectedShape = e.overlay;
			});

			// Comprueba si hay algún polígono
			var dataPolygons = $("#dataPolygons_hidden").val();
			if (dataPolygons != '') {

				var coordsArray = new Array();
				var j=0;
				var polygonsArray = dataPolygons.split(",");
				for (var i=0; i<polygonsArray.length; i+=2) {
					coordsArray[j++] = new google.maps.LatLng(polygonsArray[i], polygonsArray[i+1]);
				}

				var bounds = new google.maps.LatLngBounds();
				for (j = 0; j < coordsArray.length; j++) {
					bounds.extend(coordsArray[j]);
				}
				searchMap.setCenter(bounds.getCenter());

				selectedShape = new google.maps.Polygon({
					paths: coordsArray,
					map: searchMap,

					strokeColor: '#70b08e',
					fillColor: '#70b08e',
					fillOpacity: 0.5,
					strokeWeight: 3,
					clickable: true,
					editable: true,
					dragable: false,
					zIndex: 1
				});

				map_on_polygonComplete(selectedShape);
			}

			drawingManager.setMap(searchMap);
		}

    /**
     *
     */
		$(document).ready(function() {

			$("#dataPolygons_hidden").val($("#dataPolygons").val());

			$modalMap = $("#modalMap");
			$modalMap.on('shown.bs.modal', function (e) {

				var bodyHeight = $(window).height()
				var dialogHeight =	$('div.modal-header', "#modalMap").height() +	$('div.modal-footer', "#modalMap").height() + 190;

				$('div.modal-body', "#modalMap").height(bodyHeight - dialogHeight);
				if (searchMap == null) {
					maps_initializeDialog();
					maps_createShapes();
				} else {
					google.maps.event.trigger(searchMap, 'resize');
				}

			});

			$("#dataPolygons_assign").on("click", function() {
				var info = $("#map-search-input").val();
				if (info != '') {
					info = 'área definida en ' + info;
				} else {
					info = 'área definida';
				}
				$("#mapInfo").val(info);
				$("#dataPolygons").val($("#dataPolygons_hidden").val());
				$("#busqueda-mapBtn_clear").removeClass("disabled");
				$("#q").val("");
			});

		});
	</script>
<?php $this->end(); ?>
<div class="hidden"><input id="map-search-input" class="map-controls" type="text" placeholder="B&uacute;squeda"></div>
<input id="dataPolygons_hidden" type="hidden" value="">
<div class="modal fade" id="modalMap">
	<div class="modal-dialog" style="width: 95%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<p class="modal-title">Defina pinchando con el bot&oacute;n izquierdo del rat&oacute;n los puntos que formar&aacute;n el &aacute;rea que restringir&aacute; la b&uacute;squeda.</p>
			</div>
			<div class="modal-body">
				<div id="map-search-canvas"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-danger btn-xs" id="dataPolygons_clear" disabled >Borrar</button>
				<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal" id="dataPolygons_assign" disabled>Asignar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
