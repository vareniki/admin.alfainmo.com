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
    var drawingTools = null;
    var drawingManager = null;

    var capitalLatLng = [];

    <?php foreach ($lats_lng as $key => $value) {
        $value1 = $value[0];
        $value2 = $value[1];
        echo "capitalLatLng[$key]=[$value1,$value2];";
    } ?>

    function maps_initializeDialog() {

        if (searchMap != null) {
            return;
        }
        searchMap = new Microsoft.Maps.Map('#map-search-canvas', {
            //credentials: 'Aqfs7CzJhu8QXpKYvNvVOUmcPjD5wfDqi2sUqsjLiMqAs6Vz-49N-1oy06OscqOl',
            center: new Microsoft.Maps.Location(<?php echo $lat_lng[0] ?>, <?php echo $lat_lng[1] ?>),
            disableZooming: false,
            mapTypeId: Microsoft.Maps.MapTypeId.road, zoom: 16 });

        Microsoft.Maps.loadModule('Microsoft.Maps.DrawingTools', function () {
            drawingTools = new Microsoft.Maps.DrawingTools(searchMap);
            drawingTools.showDrawingManager(function (manager) {

                drawingManager = manager;

                var da = Microsoft.Maps.DrawingTools.DrawingBarAction;
                manager.setOptions({
                    drawingBarActions: da.polygon | da.erase
                });

                Microsoft.Maps.Events.addHandler(manager, 'drawingStarted', function () {
                    $("#dataPolygons_assign").removeAttr("disabled");
                });

                Microsoft.Maps.Events.addHandler(manager, 'drawingEnded', function () {
                    $("#dataPolygons_assign").removeAttr("disabled");
                });

                Microsoft.Maps.Events.addHandler(manager, 'drawingErased', function () {
                    //printText('Drawing erased.');
                });

                maps_createShapes();
            });
        });
    }

    function maps_getPolygonsFieldArray() {
        var result='';

        var primitives = drawingManager.getPrimitives();
        for (var i=0; i<primitives.length; i++) {
            var locations = primitives[i].getLocations();
            for (var j=0; j< locations.length -1; j++) {
                result += ',' + locations[j].latitude + ',' + locations[j].longitude;
            }
            result += "\n";
        }

        if (result.length > 0) {
            result = result.substring(1);
        }
        return result;
    }

    function maps_createShapes() {

        var dataPolygons = $("#dataPolygons_hidden").val();
        var newShape = null;
        if (dataPolygons != '') {
            var linesArray = dataPolygons.split("\n");
            for (var l=0; l<linesArray.length; l++) {

                if (linesArray[l] == '') {
                    continue;
                }

                var polygonsArray = linesArray[l].split(",");
                var coordsArray = new Array();
                var j=0;
                for (var i=0; i<polygonsArray.length; i+=2) {
                    coordsArray[j++] = new Microsoft.Maps.Location(polygonsArray[i], polygonsArray[i+1])
                }
                newShape = new Microsoft.Maps.Polygon(coordsArray, null);
                drawingManager.add(newShape);
            }
        }
        if (newShape != null) {
            $("#dataPolygons_assign").removeAttr("disabled");
        }
    }

    function maps_initializeSearch() {
        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', function () {
            var options = {
                maxResults: 5,
                map: searchMap
            };
            var manager = new Microsoft.Maps.AutosuggestManager(options);
            manager.attachAutosuggest('#map-search-input', '#map-search-container', map_searchResults);
        });
    }

    function map_searchResults(item) {
        drawingManager.clear();
        searchMap.entities.clear();
        searchMap.setView({ bounds: item.bestView, zoom: 14 });
    }

    $(document).ready(function() {

        $("#dataPolygons_hidden").val($("#dataPolygons").val());

        $modalMap = $("#modalMap");
        $modalMap.on('shown.bs.modal', function (e) {

            var bodyHeight = $(window).height()
            var dialogHeight =	$('div.modal-header', "#modalMap").height() +	$('div.modal-footer', "#modalMap").height() + 190;
            $('div.modal-body', "#modalMap").height(bodyHeight - dialogHeight);

            maps_initializeDialog();
            maps_initializeSearch();
        });

        $("#dataPolygons_assign").on("click", function() {

            $("#dataPolygons_hidden").val(maps_getPolygonsFieldArray());
            $("#dataPolygons").val($("#dataPolygons_hidden").val());
            $("#busqueda-mapBtn_clear").removeClass("disabled");
            $("#q").val("");
        });
    });
</script>
<?php $this->end(); ?>
<input id="dataPolygons_hidden" type="hidden" value="">
<div class="modal fade" id="modalMap">
	<div class="modal-dialog" style="width: 95%">
		<div class="modal-content">
			<div class="modal-header">
                <div class="col-xs-6">
                    <div id="map-search-container"><input id="map-search-input" class="form-control" type="text" placeholder="B&uacute;squeda" autocomplete="off" /></div>
                </div>
                <div class="col-xs-6 text-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>
			</div>
			<div class="modal-body">
				<div id="map-search-canvas"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal" id="dataPolygons_assign" disabled>Asignar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
