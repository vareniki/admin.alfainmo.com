<?php
$this->start('header');
?>
<script type="text/javascript">

  var map;
  function mapCallBack() {
      map = new Microsoft.Maps.Map('#mapResult', {
          disableZooming: true,
          mapTypeId: Microsoft.Maps.MapTypeId.road, zoom: 15 });

      Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', function () {
          var options = {
              maxResults: 4,
              map: map
          };
          var manager = new Microsoft.Maps.AutosuggestManager(options);
          manager.attachAutosuggest('#localizarInmueble', '#localizarInmuebleContainer', localizarInmuebleResult);
      });

    <?php if (!empty($info['Inmueble']['coord_x']) && !empty($info['Inmueble']['coord_y'])): ?>
      var center = new Microsoft.Maps.Location(<?php echo $info['Inmueble']['coord_x'] ?>, <?php echo $info['Inmueble']['coord_y'] ?>);
      map.setView({center: center })

      var pins = [];
      pins.push(new Microsoft.Maps.Pushpin(center, { icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png' }));
      map.entities.push(pins);

      $("#mapResult").css('height', '200px');
    <?php endif; ?>
  }

  /**
   *
   * @param item
   */
  function localizarInmuebleResult(item) {

      map.entities.clear();
      map.setView({ bounds: item.bestView });
      map.entities.push(new Microsoft.Maps.Pushpin(item.location));

      $("#InmuebleZona").val('');
      $("#InmueblePoblacion").val(item.address.locality);
      $("#InmuebleProvincia").val(item.address.adminDistrict);
      $("#InmuebleCodigoPostal").val(item.address.postalCode);

      $("#InmuebleCoordX").val(item.location.latitude);
      $("#InmuebleCoordY").val(item.location.longitude);

      if (item.address.addressLine != null) {
          var streetNumber = item.address.addressLine.split(',');
          $("#InmuebleNombreCalle").val(streetNumber[0]);
          if (streetNumber.length > 1) {
              $("#InmuebleNumeroCalle").val(parseInt(streetNumber[1]));
          }
      }
  }

  $(document).ready(function() {
	$("#mapResult").empty();

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
<div class="form-group"><label class="control-label col-xs-5 col-lg-4 col-sm-4">Geolocalizar inmueble:</label>
    <div id='localizarInmuebleContainer' class="controls col-xs-7 col-lg-8 col-sm-8">
        <input class="form-control" type="text" id="localizarInmueble" aria-invalid="false" placeholder="Escriba una direcci&oacute;n para geolocalizar el inmueble" style="background-color: #fff6d0;">
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
	<?php echo $this->App->horizontalInput('Inmueble.ref_catastral', 'Referencia catastral:', array('minlength' => 20, 'maxlength' => 20, 'labelClass' => 'obligat') + $read_only + $click_rc); ?>
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
//echo '<p><small>S&oacute;lo a efectos de la compatibilidad con la antigua Web</small></p>';
//echo $this->App->horizontalSelect('Inmueble.poblacion_id', '<span>[*]</span> Población:', $poblaciones_ids, array('labelClass' => 'text-danger'));
//echo '<hr>';
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
