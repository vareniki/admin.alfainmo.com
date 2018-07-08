<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view2');

$title = 'Modificar referencia ' . $info['Inmueble']['referencia']  . ' - ' . $info['TipoInmueble']['description'];
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('inmuebles_left');
echo $this->element('inmuebles/common_view_left');
$this->end();

$this->start('header');
echo $this->Html->css(['//ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/themes/base/jquery-ui.min.css'], null, ['inline' => false]);
echo $this->Html->script(['//ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.min.js', '//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js', 'alfainmo.ajax.js?ver=1.1.0', 'alfainmo.docs.js?ver=1.1.0']);
?>
<script type="text/javascript">

	var demandasLoaded=false;

  function numberWithPoints(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function mostrarPrecios() {
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
    if ($("#InmuebleEsParvenca").is(":checked"))
          visibles += ",.InmuebleEsParvenca";
    if (visibles != "") {
      visibles = visibles.substr(1);
    }
    $(visibles).show();
  }

  function mostrarRefCatastral() {
    if ($("#InmuebleSinRefCatastral").is(":checked")) {
      $(".divReferenciaCat").hide();
	    $(".divNoReferenciaCat").show();
    } else {
      $(".divReferenciaCat").show();
	    $(".divNoReferenciaCat").hide();
    }
  }

  function mostrarPromocion() {
    if ($("#InmuebleEsPromocion").is(":checked")) {
      $(".divEsPromocion").show();
    } else {
      $(".divEsPromocion").hide();
    }
  }

  function calcularHonorarios() {
    var precioInmueble = parseInt($("#InmueblePrecioVenta").val());
    if (isNaN(precioInmueble) || precioInmueble == 0) {
      precioInmueble = parseInt($("#InmueblePrecioAlquiler").val());
      if (isNaN(precioInmueble) || precioInmueble == 0) {
        precioInmueble = parseInt($("#InmueblePrecioTraspaso").val());
      }
    }
    if (isNaN(precioInmueble)) {
      precioInmueble = 0;
    }

    var honor = $("#InmuebleHonorAgencia").val();
    honor = $.trim(honor);
    if (honor == "") {
      $("#InmueblePrecioPropietario").val("");
      return;
    }

    honor = parseFloat(honor);
    if (isNaN(honor)) {
      honor = 0;
    }

    var unid = $("#InmuebleHonorAgenciaUnid").val();

    var precioProp = 0;
    if (unid != '%') {
      // Euros
      precioProp = numberWithPoints(precioInmueble - honor);
      $("#InmuebleHonorAgencia").attr("max", 999999);

    } else {
      // Porcentaje
	  var precioProp = precioInmueble - (precioInmueble * honor / 100);
	  precioProp = numberWithPoints(Math.round(precioProp));
      $("#InmuebleHonorAgencia").attr("max", 999);
    }
    $("#InmueblePrecioPropietario").val(precioProp);
  }

  function mostrarInfoBaja() {
    if ($("#InmuebleEstadoInmuebleId").val() == '05') {
      $("#InmuebleInfoBaja").show();
    } else {
      $("#InmuebleInfoBaja").hide();
    }

  }

  function mostrarParticularVende() {
	  if ($("#InmuebleTipoContratoId").val() == 'AI' || $("#InmuebleTipoContratoId").val() == 'PV') {
		  $("#ParticularPrecioInfo").show();
	  } else {
		  $("#ParticularPrecioInfo").hide();
	  }

      if ($("#InmuebleTipoContratoId").val() == 'PV') {
          $("#HonorariosCompartidosInfo").hide();
      } else {
          $("#HonorariosCompartidosInfo").show();
      }
  }

  $(document).ready(function() {

    $("[rel=popover]").popover({'trigger': 'hover', 'html': true});
    $("#editForm").validate({
      errorClass: 'text-danger',
      errorPlacement: function(error, element) {
        error.appendTo(element.closest('div'));
      }
    });

    mostrarPrecios();
    $("#tipoOperacion").on("click", "input[type=checkbox]", function() {
      mostrarPrecios();
    });

    mostrarRefCatastral();
    $("#InmuebleSinRefCatastral[readonly!=readonly]").on("click", function() {
      mostrarRefCatastral();
    });

    mostrarPromocion();
    $("#InmuebleEsPromocion").on("click", function() {
      mostrarPromocion();
    });

    calcularHonorarios();
    $("#InmuebleHonorAgencia, #InmuebleHonorAgenciaUnid, #InmueblePrecioVenta, #InmueblePrecioAlquiler, #InmueblePrecioTraspaso, #InmueblePrecioParvenca").on("change", function() {
      calcularHonorarios();
    });

    $("#InmuebleHonorAgenciaUnid").on("change", function() {
      if (this.value == '%') {
        $("#InmuebleHonorAgencia").attr("max", 999999);
      } else {
        $("#InmuebleHonorAgencia").attr("max", 999);
      }

      $("#editForm").validate();
    });

    mostrarInfoBaja();
    $("#InmuebleEstadoInmuebleId").on("click", function() {
      mostrarInfoBaja();
    });

  mostrarParticularVende();
  $("#InmuebleTipoContratoId").on("click", function() {
      mostrarParticularVende();
  });

    <?php if ($agencia['Agencia']['numero_agencia'] != 1521) { ?>
      if ($("#InmuebleDescripcion").val() == '') {
          $("#InmuebleDescripcion").val("NO COBRAMOS HONORARIOS AL COMPRADOR. TRATO DIRECTO CON LA PROPIEDAD, TOTAL TRANSPARENCIA.");
      }

      if ($("#InmuebleDescripcionAbreviada").val() == '') {
          $("#InmuebleDescripcionAbreviada").val("NO COBRAMOS HONORARIOS AL COMPRADOR. TRATO DIRECTO CON LA PROPIEDAD, TOTAL TRANSPARENCIA.");
      }
    <?php } else { ?>
      if ($("#InmuebleDescripcion").val() == '') {
          $("#InmuebleDescripcion").val("HONORARIOS AGENCIA INCLUIDOS EN EL PRECIO. TRATO DIRECTO CON LA PROPIEDAD, TOTAL TRANSPARENCIA.");
      }

      if ($("#InmuebleDescripcionAbreviada").val() == '') {
          $("#InmuebleDescripcionAbreviada").val("HONORARIOS AGENCIA INCLUIDOS EN EL PRECIO. TRATO DIRECTO CON LA PROPIEDAD, TOTAL TRANSPARENCIA.");
      }
    <?php } ?>

    initGalleryButtons();

    $('#myTabs a').click(function(e) {
      var id = $(this).attr('href').substr(1);
      $('#selectedTab').val(id);
	    <?php if ($info['Inmueble']['estado_inmueble_id'] == '01') { ?>
	    if (id == 'tab2') {
		    $("#submitBtn").text("comprobar duplicado y grabar");
		    $("#checkdup").val("1");
	    } else {
		    $("#submitBtn").text("grabar");
		    $("#checkdup").val("");
	    }
      <?php } ?>

	    if (id == 'tab10') {
		    if (!demandasLoaded) {
			    $("#demandasForm").ajaxSubmit({	target: "#demandasForm_results"	});
			    demandasLoaded = true;
		    }
	    }
    });

	  $("#PisoEsVpo, #ChaletEsVpo").on("click", function() {
		  if ($(this).is(":checked")) {
			  alert("Este inmueble es de VPO, para que se publicite en Web, es necesario que nos enviéis la autorización de venta y el precio del módulo.");
		  }
	  });

  });
</script>
<?php
$this->end();

$check_dup = ($info['Inmueble']['estado_inmueble_id'] == '01' && $selectedTab == 'tab2');

echo $this->Form->create(false, array('id' => 'editForm', 'url' => 'edit',
  'class' => 'form-horizontal aviso', 'enctype' => 'multipart/form-data'));
echo $this->Form->hidden('referer');
echo $this->Form->hidden('checkdup', array('name' => '_checkdup', 'value' => ($check_dup ? '1':'') ));
echo $this->Form->hidden('Inmueble.id');
echo $this->Form->hidden('Inmueble.tipo_inmueble_id');

echo $this->Form->hidden('Inmueble.agencia_id');
echo $this->Form->hidden('Inmueble.referencia');

$url_64 = null; //(isset($this->data['referer'])) ? $this->data['referer'] : null;

if (isset($info['Imagen']) && !empty($info['Imagen'])) {
  echo '<input type="hidden" name="_has_imagenes" value="S">';
}
echo $this->Form->hidden('Imagen.id');
echo $this->Form->hidden('_estado_inmueble_id', array('name' => '_estado_inmueble_id', 'value' => $info['Inmueble']['estado_inmueble_id']));
?>
<input type='hidden' name='selectedTab' id='selectedTab' value='<?php echo $selectedTab ?>'>

	<div id="save-buttons" class="text-right">
		<?php
		$link_view = 'view/' . $info['Inmueble']['id'];
		echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i> finalizar edici&oacute;n', $link_view, array('class' => 'btn btn-sm btn-default', 'escape' => false)) . "&nbsp;\n";
		if ($url_64) { ?>
			<a href="<?php echo base64_decode($url_64) ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-list"></i> volver al listado</a>
		<?php
		} else {
			echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> listado', '/inmuebles/index', array('class' => 'btn btn-default btn-sm', 'escape' => false)) . "\n";
		}
		if ($check_dup) {
			$btn_txt = 'comprobar duplicado y grabar';
		} else {
			$btn_txt = 'grabar';
		}

		echo $this->Form->submit($btn_txt, array('id' => 'submitBtn','class' => 'btn btn-sm btn-primary', 'div' => false));
		?>
	</div>
<hr>
<ul id="myTabs" class="nav nav-tabs">
  <li<?php echo($selectedTab == 'tab1') ? ' class="active"' : '' ?>><a href="#tab1" data-toggle="tab">Precio</a></li>
  <li<?php echo($selectedTab == 'tab2') ? ' class="active"' : '' ?>><a href="#tab2" data-toggle="tab">Localizaci&oacute;n</a></li>
  <li<?php echo($selectedTab == 'tab3') ? ' class="active"' : '' ?>><a href="#tab3" data-toggle="tab">Caracter&iacute;sticas</a></li>
  <li<?php echo($selectedTab == 'tab4') ? ' class="active"' : '' ?>><a href="#tab4" data-toggle="tab">Detalles</a></li>
  <li<?php echo($selectedTab == 'tab5') ? ' class="active"' : '' ?>><a href="#tab5" data-toggle="tab">Contacto</a></li>
  <li<?php echo($selectedTab == 'tab6') ? ' class="active"' : '' ?>><a href="#tab6" data-toggle="tab">Internos</a></li>
  <li<?php echo($selectedTab == 'tab7') ? ' class="active"' : '' ?>><a href="#tab7" data-toggle="tab">Gesti&oacute;n</a></li>
  <li<?php echo($selectedTab == 'tab8') ? ' class="active"' : '' ?>><a href="#tab8" data-toggle="tab">Fotos</a></li>
	<li<?php echo($selectedTab == 'tab9') ? ' class="active"' : '' ?>><a href="#tab9" data-toggle="tab">Docs</a></li>
	<li<?php echo($selectedTab == 'tab10') ? ' class="active"' : '' ?>><a href="#tab10" data-toggle="tab">Demandantes</a></li>
</ul>
<div class="tab-content">
  <div id="tab1" class="tab-pane<?php echo($selectedTab == 'tab1') ? ' active' : '' ?>">
    <?php echo $this->element("inmuebles/edit_basico_$tipoInmueble"); ?>
  </div>
  <div id="tab2" class="tab-pane<?php echo($selectedTab == 'tab2') ? ' active' : '' ?>">
    <?php echo $this->element('inmuebles/edit_localizacion'); ?>
  </div>
  <div id="tab3" class="tab-pane<?php echo($selectedTab == 'tab3') ? ' active' : '' ?>">
    <?php echo $this->element("inmuebles/edit_caracteristicas_$tipoInmueble"); ?>
  </div>
  <div id="tab4" class="tab-pane<?php echo($selectedTab == 'tab4') ? ' active' : '' ?>">
    <?php echo $this->element("inmuebles/edit_detalles_$tipoInmueble");


      $placeholder = 'tipo de inmueble, zona, municipio, colegios, metro, autobús, zonas de ocio...';
      echo $this->App->horizontalInput('Inmueble.descripcion', "Descripci&oacute;n completa:<br><small><span style='color:#888'>($placeholder)</span></small>", array('rows' => 6, 'placeholder' =>  $placeholder));
      echo $this->App->horizontalInput('Inmueble.descripcion_abreviada', 'Descripci&oacute;n abreviada:<br><span>(max. 500 caracteres)</span>', array('rows' => 4, 'maxlength' => 500));
      echo $this->App->horizontalInput('Inmueble.observaciones_pvi', 'Observaciones particular vende:<br><span>(max. 250 caracteres)</span>', array('rows' => 2, 'maxlength' => 250));
      echo $this->App->horizontalTextarea('Inmueble.video', 'Vídeos:', array('rows' => 3, 'placeholder' => 'pegue la URL o URLs separadas por salto de línea'));
    echo $this->App->horizontalTextarea('Inmueble.tour_virtual', 'Tours virtuales:', array('rows' => 3, 'placeholder' => 'pegue la URL o URLs separadas por salto de línea'));
    ?>

      <div class="row">
          <label class="control-label col-xs-5 col-lg-4 col-sm-4"></label>
          <div class="controls col-xs-7 col-lg-8 col-sm-8">
              <a data-toggle="collapse" data-target="#ejemploVideos" aria-expanded="false" aria-controls="ejemploVideos">&iquest;Como insertar los vídeos?.</a>
          </div>
      </div>
      <div class="collapse text-right" id="ejemploVideos" style="margin-top:8px">
          <div class="well">
            <?php echo $this->Html->image('obtener-url-youtube.png'); ?><br>
          </div>
      </div>

  </div>
  <div id="tab5" class="tab-pane<?php echo($selectedTab == 'tab5') ? ' active' : '' ?>">
    <?php echo $this->element('inmuebles/edit_contacto'); ?>
  </div>
  <div id="tab6" class="tab-pane<?php echo($selectedTab == 'tab6') ? ' active' : '' ?>">
    <?php echo $this->element('inmuebles/edit_internos'); ?>
  </div>
  <div id="tab7" class="tab-pane<?php echo($selectedTab == 'tab7') ? ' active' : '' ?>">
    <?php echo $this->element('inmuebles/edit_gestion'); ?>
  </div>
  <div id="tab8" class="tab-pane<?php echo($selectedTab == 'tab8') ? ' active' : '' ?>">
    <?php echo $this->element('inmuebles/edit_fotos'); ?>
  </div>
	<div id="tab9" class="tab-pane<?php echo($selectedTab == 'tab9') ? ' active' : '' ?>">
		<?php echo $this->element('inmuebles/edit_documentos'); ?>
	</div>
	<div id="tab10" class="tab-pane<?php echo($selectedTab == 'tab10') ? ' active' : '' ?>">
		<div id="demandasForm_results"></div>
	</div>
</div>
<?php
echo $this->Form->end();

echo $this->Form->create(false, array('id' => 'demandasForm', 'url' => array('action' => 'getDemandasInmueble', 'controller' => 'ajax')));
echo $this->Form->hidden('inmueble_id', array('name' => 'inmueble_id', 'value' => $info['Inmueble']['id']));
echo $this->Form->end();
?>


