<?php
$this->start('header');
echo $this->Html->script(['//maps.google.com/maps/api/js?sensor=false&key=AIzaSyAr6xxQvPWvBslfoELkCuWznJ9Kw4j9-9c']);
//AIzaSyCJQH_jasnyqs929Dk0MpzEC_2xTVTgWTw

?>
<script type="text/javascript">

    var geocoder = null;
    var localizaciones = null;

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

        // Ver mapa más grande
        src = "http://maps.google.com/maps?hl=es&iwloc=A&ll=" + opts.markers + "&center=" + opts.center;

        var link = '<br><p style="float:right"><a href="' + src + '" target="_blank">Ver mapa m&aacute;s grande</a></p>';

        return img + link;
    }



    $(document).ready(function() {
        $("#mapResult").empty();

      <?php if (!empty($info['Inmueble']['coord_x']) && !empty($info['Inmueble']['coord_y'])): ?>
        var latLng = "<?php echo $info['Inmueble']['coord_x'] . ',' . $info['Inmueble']['coord_y']; ?>";
        $("#mapResult").append(getMap({center: latLng, markers: latLng}));
      <?php endif; ?>

        $("#localizarInmueble").on("click", function() {
            maps_dialog({
                title: 'Geolocalizar propiedad',
                pais: $("#InmueblePaisId option:selected").text()
            }, function(item) {
                /*
                 * Al pinchar aplicar se ejecuta esta función
                 */
                $("#mapResult").empty();

                if (item.lat != 0 && item.lng != 0) {
                    var latLng = item.lat + "," + item.lng;
                    $("#mapResult").append(getMap({center: latLng, markers: latLng}));
                }

                $("#InmuebleCoordX").val(item.lat);
                $("#InmuebleCoordY").val(item.lng);

                $("#InmueblePoblacion").val(item.poblacion);
                $("#InmuebleProvincia").val(item.provincia);
                $("#InmuebleCodigoPostal").val(item.cp);

                $("#InmuebleNombreCalle").val(item.calle);
                $("#InmuebleNumeroCalle").val(item.numero);

                actualizarPoblaciones(); // Actualizar poblaciones
            });
        });

        $("#InmuebleCodigoPostal").on("change", function() {
            actualizarPoblaciones();
        });

        function actualizarPoblaciones() {

            $("#InmueblePoblacionId").html('<option value="">(seleccionar población)</option>');

            var provId = $("#InmuebleCodigoPostal").val();
            if (provId.length < 5) {
                return;
            }
            provId = provId.substr(0, 2);

            $.ajax("<?php echo $this->base; ?>/ajax/getPoblacionesProvincia/" + provId, {
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(i, obj) {
                        $("#InmueblePoblacionId").append('<option value="' + obj.id + '">' + obj.description + '</option>');
                    });
                }
            });
        }

        $("#buscarRC_btn").on("click", function () {
            $("#buscarRC_modal").modal();
        });

        $("#refCatastral_form").ajaxForm({
            target: '#refCatastral_results',
            success: function() {

            }
        });

        $('#InmuebleSinRefCatastral[readonly=readonly]').click(function(){
            return false;
        });


    });
</script>
<?php
$this->end();
echo $this->App->horizontalSelect('Inmueble.pais_id', '<span>[*]</span> Pa&iacute;s:', $paises, array('required' => 'required', 'labelClass' => 'obligat'));
?>
<div class="form-group" style="margin-bottom: 0;">
    <div class="col-xs-5 col-lg-4 col-sm-4 text-right">&nbsp;</div>
    <div class="controls col-xs-7 col-lg-8 col-sm-8">
        <p class="text-info">Geolocaliza el inmueble y los datos se rellenan autom&aacute;ticamente</p>
    </div>
</div>
<div class="form-group">
    <label class="col-xs-5 col-lg-4 col-sm-4"></label>
    <div class="controls col-xs-7 col-lg-8 col-sm-8">
        <button class="btn btn-default btn-sm" type="button" id="localizarInmueble">Geolocalizar inmueble...</button>
    </div>
</div>
<?php
$read_only = (empty($info['Inmueble']['coord_x']) || empty($info['Inmueble']['coord_y'])) ? array('readonly' => 'readonly') : array();

echo $this->App->horizontalInput('Inmueble.provincia', 'Provincia:', array('labelClass' => 'obligat') + $read_only);
echo $this->App->horizontalInput('Inmueble.poblacion', 'Poblaci&oacute;n:', array('labelClass' => 'obligat') + $read_only);
echo $this->App->horizontalInput('Inmueble.codigo_postal', 'Código postal:', array('labelClass' => 'obligat') + $read_only);
echo $this->App->horizontalInput('Inmueble.zona', 'Zona:', array('labelClass' => 'obligat'));

echo $this->App->horizontalInput('Inmueble.nombre_calle', 'Calle:', array('labelClass' => 'obligat') + $read_only);
echo $this->App->horizontalInput('Inmueble.numero_calle', 'Número:', array('min' => 0, 'labelClass' => 'obligat') + $read_only);

if ($info['Inmueble']['estado_inmueble_id'] >= '02') {
  $read_only =  array('readonly' => 'readonly');
  $click_rc = array();
} else {
  $read_only =  array();
  //$click_rc = array('click' => array('icon' => 'search', 'id' => 'buscarRC_btn'));
  $click_rc = array();
}
?>
<hr>
<div class="form-group">
    <label class="control-label col-md-5 col-lg-4 col-sm-4"></label>
    <div class="col-md-7 col-lg-8 col-sm-8">
      <?php echo $this->Form->checkbox('Inmueble.sin_ref_catastral', array('value' => 't', 'label' => 'Sin referencia catastral') + $read_only); ?>
    </div>
</div>
<div class="divReferenciaCat">
  <?php echo $this->App->horizontalInput('Inmueble.ref_catastral', 'Referencia catastral:',
      ['minlength' => 20, 'maxlength' => 20, 'labelClass' => 'obligat'] + $read_only + $click_rc); ?>
  <?php if (empty($read_only)): ?>
      <div class="form-group">
          <label class="control-label col-xs-5 col-lg-4 col-sm-4 obligat">&nbsp;</label>
          <div class="controls col-xs-7 col-lg-8 col-sm-8"><a href="https://www1.sedecatastro.gob.es/OVCFrames.aspx?TIPO=CONSULTA" target="_blank">obtener referencia catastral del inmueble</a></div>
      </div>
  <?php endif; ?>
</div>
<div class="divNoReferenciaCat">
    <p class="text-danger">El campo &quot;referencia catastral&quot; es un campo obligatorio para poder detectar duplicidades.
        S&oacute;lo debe marcarse &quot;sin referencia catastral&quot; en caso de no existir dicha referencia.</p>
</div>
<hr>
<p><small>Modificar en caso de que la geolocalizaci&oacute;n no sea exacta, s&oacute;lo a efectos de la marca en el mapa</small></p>
<?php
echo $this->App->horizontalInput('Inmueble.coord_x', 'Latitud:', array('labelClass' => 'obligat') + $read_only);
echo $this->App->horizontalInput('Inmueble.coord_y', 'Longitud:', array('labelClass' => 'obligat') + $read_only);
echo '<hr>';
echo '<p><small>S&oacute;lo a efectos de la compatibilidad con la antigua Web</small></p>';
echo $this->App->horizontalSelect('Inmueble.poblacion_id', '<span>[*]</span> Población:', $poblaciones_ids, array('labelClass' => 'text-danger'));
echo '<hr>';

?>
<div id="mapResult"></div>
<br>
<?php
if (isset($tipoInmueble)) {
  echo $this->element("inmuebles/edit_localizacion_$tipoInmueble");
}
?>
<?php $this->start('dialogs'); ?>
<?php if (empty($read_only)):

  $bloque = '';
  $escalera = '';
  $piso = '';
  $puerta = '';
  if (isset($info['Inmueble']['tipo_inmueble_id'])) {

    switch ($info['Inmueble']['tipo_inmueble_id']) {
      case '01':
        $bloque = $info['Piso']['bloque'];
        $escalera = $info['Piso']['escalera'];
        $piso = $info['Piso']['piso'];
        $puerta = $info['Piso']['puerta'];
        break;
      case '02':
        break;
      case '03':
        $bloque = $info['Local']['bloque'];
        break;
      case '04':
        $bloque = $info['Oficina']['bloque'];
        $escalera = $info['Oficina']['escalera'];
        $piso = $info['Oficina']['piso'];
        $puerta = $info['Oficina']['puerta'];
        break;
      case '05':
        break;
      case '06':
        break;
      case '07':
        break;
      case '08':
        break;
    }

  }

  ?>
    <div class="modal fade" id="buscarRC_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="refCatastral_form" class="form-horizontal form-compressed" action="<?php echo $this->base; ?>/ajax/buscarRefCatastral/">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Buscar referencia catastral</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tabm1" data-toggle="tab">B&uacute;squeda</a></li>
                            <li><a href="#tabm2" data-toggle="tab">Resultados</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tabm1" class="tab-pane active">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Provincia:</label>
                                    <div class="col-sm-10">
                                        <input name="provincia" type="text" class="form-control" placeholder="provincia" value="<?php echo $info['Inmueble']['provincia'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Poblaci&oacute;n:</label>
                                    <div class="col-sm-10">
                                        <input name="municipio" type="text" class="form-control" placeholder="poblaci&oacute;n" value="<?php echo $info['Inmueble']['poblacion'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo de v&iacute;a:</label>
                                    <div class="col-sm-10">
                                        <select name="sigla" class="form-control">
                                            <option value="AV">Avenida</option>
                                            <option value="CL" selected>Calle</option>
                                            <option value="CM">Camino</option>
                                            <option value="FN">Finca</option>
                                            <option value="PS">Paseo</option>
                                            <option value="PB">Poblado</option>
                                            <option value="PT">Puente</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Calle / v&iacute;a:</label>
                                    <div class="col-sm-10">
                                        <input name="calle" type="text" class="form-control" placeholder="nombre de la vía" value="<?php echo $info['Inmueble']['nombre_calle'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">N&uacute;mero:</label>
                                    <div class="col-sm-10">
                                        <input name="numero" type="text" class="form-control" placeholder="número de la calle" value="<?php echo $info['Inmueble']['numero_calle'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Bloque:</label>
                                    <div class="col-sm-10">
                                        <input name="bloque" type="text" class="form-control" placeholder="bloque" value="<?php echo $bloque ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Escalera:</label>
                                    <div class="col-sm-10">
                                        <input name="escalera" type="text" class="form-control" placeholder="escalera" value="<?php echo $escalera ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Piso:</label>
                                    <div class="col-sm-10">
                                        <input name="piso" type="text" class="form-control" placeholder="piso" value="<?php echo $piso ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Puerta:</label>
                                    <div class="col-sm-10">
                                        <input name="puerta" type="text" class="form-control" placeholder="puerta" value="<?php echo $puerta ?>">
                                    </div>
                                </div>
                            </div>
                            <div id="tabm2" class="tab-pane">
                                <div id="refCatastral_results"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $this->end(); ?>
