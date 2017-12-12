<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view2');

$title = "Alta de inmueble";
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('inmuebles_left');
$this->end();

$this->start('header');
?>
<script type="text/javascript">
  var $traspasoCheck;
  $(document).ready(function() {
    $traspasoCheck = $("#InmuebleEsTraspaso").closest("label");
    $traspasoCheck.hide();

    $("[rel=popover]").popover({'trigger': 'hover', 'html': true});
    $("#addForm").validate({
      errorClass: 'text-danger',
      errorPlacement: function(error, element) {
        error.appendTo(element.closest('div'));
      }
    });

    $("input[name='data[Inmueble][tipo_inmueble_id]'][type='radio']").on("click", function() {
      $("div[class*=InmuebleTipoInmuebleId]").hide();
      $("div." + this.id).show();

      $("#tipoOperacion input[type=checkbox]").prop("checked", false);

      if (this.value == '03' || this.value == '04' || this.value == '07') {
        $traspasoCheck.show();
      } else {
        $("#InmuebleEsTraspaso").prop("checked", false);
        $traspasoCheck.hide();
        $(".InmuebleEsTraspaso").hide();
      }
    });

	  $("#PisoEsVpo, #ChaletEsVpo").on("click", function() {
		  if ($(this).is(":checked")) {
			  alert("Este inmueble es de VPO, para que se publicite en Web, es necesario que nos enviéis la autorización de venta y el precio del módulo.");
		  }
	  });

    $("#tipoOperacion").on("click", "input[type=checkbox]", function() {
      $("div[class*=InmuebleEs]").hide();
      var visibles = "";
      if ($("#InmuebleEsVenta").is(":checked"))
        visibles += ",.InmuebleEsVenta";
      if ($("#InmuebleEsAlquiler").is(":checked"))
        visibles += ",.InmuebleEsAlquiler";
      if ($("#InmuebleEsTraspaso").is(":checked"))
        visibles += ",.InmuebleEsTraspaso";
      if ($("#InmuebleEsOpcionCompra").is(":checked"))
        visibles += ",.InmuebleEsOpcionCompra";
      if (visibles != "") {
        visibles = visibles.substr(1);
        $("#siguiente-btn").prop("disabled", false);
      } else {
        $("#siguiente-btn").prop("disabled", "disabled");
      }
      $(visibles).show();
    });

    $("#InmuebleEsPromocion").on("click", function() {
      if ($("#InmuebleEsPromocion").is(":checked")) {
        $(".divEsPromocion").show();
      } else {
        $(".divEsPromocion").hide();
      }
    });

  });
</script>
<?php
$this->end();
echo $this->Form->create(false, array('id' => 'addForm', 'url' => 'edit', 'class' => 'form-horizontal aviso'));
echo $this->Form->hidden('Inmueble.agencia_id', array('value' => $agencia['Agencia']['id']));
echo $this->Form->hidden('Inmueble.numero_agencia', array('value' => $agencia['Agencia']['numero_agencia']));
echo $this->Form->hidden('Inmueble.estado_inmueble_id', array('value' => '01'));
echo $this->Form->hidden('Inmueble.pais_id', array('value' => $agencia['Agencia']['pais_id']));
?>
<input type='hidden' name='selectedTab' id='selectedTab' value='tab2'>
<?php
if (!empty($agente)) {
  echo $this->Form->hidden('Inmueble.agente_id', array('value' => $agente['Agente']['id']));
}
echo $this->Form->hidden('Inmueble.numero_agencia', array('value' => $agencia['Agencia']['numero_agencia']));

echo $this->App->horizontalRadio('Inmueble.tipo_inmueble_id', '<span>[*]</span> Tipo de inmueble:', $tiposInmueble, array('required' => 'true'));
echo $this->App->horizontalRadio('Piso.tipo_piso_id', '<span>[*]</span> Tipo de piso:', $tiposPiso, array('required' => 'true', 'divClass' => 'oculto InmuebleTipoInmuebleId01'));
echo $this->App->horizontalRadio('Chalet.tipo_chalet_id', '<span>[*]</span> Tipo de chalet:', $tiposChalet, array('required' => 'true', 'divClass' => 'oculto InmuebleTipoInmuebleId02'));
echo $this->App->horizontalRadio('Oficina.tipo_oficina_id', '<span>[*]</span> Tipo de oficina:', $tiposOficina, array('required' => 'true', 'divClass' => 'oculto InmuebleTipoInmuebleId04'));
echo $this->App->horizontalRadio('Garaje.tipo_garaje_id', '<span>[*]</span> Tipo de garaje:', $tiposGaraje, array('required' => 'true', 'divClass' => 'oculto InmuebleTipoInmuebleId05'));
echo $this->App->horizontalRadio('Terreno.tipo_terreno_id', '<span>[*]</span> Tipo de terreno:', $tiposTerreno, array('required' => 'true', 'divClass' => 'oculto InmuebleTipoInmuebleId06'))
?>
<hr>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4"><span>[*]</span> Operaci&oacute;n:</label>
  <div class="col-xs-7 col-lg-8 col-sm-8" id="tipoOperacion">
    <?php
    echo $this->Form->checkbox('Inmueble.es_venta', array('value' => 't', 'label' => 'venta'));
    echo $this->Form->checkbox('Inmueble.es_alquiler', array('value' => 't', 'label' => 'alquiler'));
    echo $this->Form->checkbox('Inmueble.es_traspaso', array('value' => 't', 'label' => 'traspaso'));
    echo $this->Form->checkbox('Inmueble.es_opcion_compra', array('value' => 't', 'label' => 'opción a compra'));
    echo '<br>';
    echo $this->Form->checkbox('Inmueble.es_promocion', array('value' => 't', 'label' => 'promoción'));
    ?>
    <div class="oculto InmuebleTipoInmuebleId01">
      <?php echo $this->Form->checkbox('Piso.es_vpo', array('value' => 't', 'label' => 'vpo')); ?>
    </div>
    <div class="oculto InmuebleTipoInmuebleId02 ">
      <?php echo $this->Form->checkbox('Chalet.es_vpo', array('value' => 't', 'label' => 'vpo')); ?>
    </div>
  </div>
</div>
<?php
echo $this->App->horizontalInput('Inmueble.nombre_promocion', '<span>[*]</span> Nombre de la promoción:', array(
  'required' => true, 'maxlength' => 64, 'divClass' => 'oculto divEsPromocion'));

echo $this->App->horizontalInput('Inmueble.entrega_promocion', 'Entrega aproximada:', array(
  'type' => 'text', 'maxlength' => 64, 'placeholder' => 'escriba una fecha aproximada de entrega', 'divClass' => 'oculto divEsPromocion'));
?>
<div class="oculto InmuebleEsVenta InmuebleEsAlquiler InmuebleEsTraspaso InmuebleEsOpcionCompra">
  <br>
  <?php
  echo $this->App->horizontalInput('Inmueble.precio_venta', '<span>[*]</span> Precio de venta:', array(
    'type' => 'number', 'required' => true, 'min' => 100, 'max' => 9999999999, 'divClass' => 'oculto InmuebleEsVenta InmuebleEsOpcionCompra'));
  echo $this->App->horizontalInput('Inmueble.precio_alquiler', '<span>[*]</span> Precio de alquiler:', array(
    'type' => 'number', 'required' => true, 'min' => 10, 'max' => 9999999, 'divClass' => 'oculto InmuebleEsAlquiler InmuebleEsOpcionCompra'));
  echo $this->App->horizontalInput('Inmueble.precio_traspaso', '<span>[*]</span> Precio de traspaso:', array(
    'type' => 'number', 'required' => true, 'min' => 100, 'max' => 9999999999, 'divClass' => 'oculto InmuebleEsTraspaso'));

  echo $this->App->horizontalSelect('Inmueble.moneda_id', '<span>[*]</span> Moneda:', $monedas, array('style' => 'width:64px'));
  ?>
</div>
<!-- Gastos de comunidad -->
<div class="oculto InmuebleTipoInmuebleId01 InmuebleTipoInmuebleId02 InmuebleTipoInmuebleId03 InmuebleTipoInmuebleId04 InmuebleTipoInmuebleId05 InmuebleTipoInmuebleId07">
  <br>
  <div class="form-group">
    <label class="control-label col-xs-5 col-lg-4 col-sm-4">Gastos de comunidad:</label>
    <div class="controls col-xs-7 col-lg-8 col-sm-8">
      <div class="oculto InmuebleTipoInmuebleId01">
        <?php
        echo $this->Form->input('Piso.gastos_comunidad', array('label' => false,
          'type' => 'number', 'div' => false, 'min' => 5, 'max' => 1000, 'class' => 'form-control'));
        ?>
      </div>
      <div class="oculto InmuebleTipoInmuebleId02">
        <?php
        echo $this->Form->input('Chalet.gastos_comunidad', array('label' => false,
          'type' => 'number', 'div' => false, 'min' => 5, 'max' => 1000, 'class' => 'form-control'));
        ?>
      </div>
      <div class="oculto InmuebleTipoInmuebleId03">
        <?php
        echo $this->Form->input('Local.gastos_comunidad', array('label' => false,
          'type' => 'number', 'div' => false, 'min' => 5, 'max' => 1000, 'class' => 'form-control'));
        ?>
      </div>
      <div class="oculto InmuebleTipoInmuebleId04">
        <?php
        echo $this->Form->input('Oficina.gastos_comunidad', array('label' => false,
          'type' => 'number', 'div' => false, 'min' => 5, 'max' => 1000, 'class' => 'form-control'));
        ?>
      </div>
      <div class="oculto InmuebleTipoInmuebleId05">
        <?php
        echo $this->Form->input('Garaje.gastos_comunidad', array('label' => false,
          'type' => 'number', 'div' => false, 'min' => 5, 'max' => 1000, 'class' => 'form-control'));
        ?>
      </div>
      <div class="oculto InmuebleTipoInmuebleId07">
        <?php
        echo $this->Form->input('Nave.gastos_comunidad', array('label' => false,
          'type' => 'number', 'div' => false, 'min' => 5, 'max' => 1000, 'class' => 'form-control'));
        ?>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="text-right">
  <?php
  echo $this->Form->submit('<i class="glyphicon glyphicon-plus-sign"></i> añadir propiedad', array('class' => 'btn btn-sm btn-primary', 'div' => false, 'disabled' => 'disabled', 'id' => 'siguiente-btn'));
  echo $this->Form->end();
  ?>
</div>
