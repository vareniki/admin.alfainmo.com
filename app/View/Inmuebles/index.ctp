<?php
// app/View/Inmuebles/view.ctp
$this->extend('/Common/view2top');
$this->set('title_for_layout', 'B&uacute;squeda de Inmuebles');

$url_64 = base64_encode($this->Html->url($this->request->data));
$selectedTab = (!empty($this->passedArgs['selectedTab'])) ? $this->passedArgs['selectedTab'] : 'tab1';

$this->start('header');
echo $this->Html->script(array('http://maps.googleapis.com/maps/api/js?sensor=false&libraries=drawing,places', 'alfainmo.maps'));
?>
<script type="text/javascript">

  var markers = [ <?php echo $this->Inmuebles->getMarkersMap($info, $agencia); ?> ];
  var infoWindowContent = [ <?php echo $this->Inmuebles->getInfoMarkersMap($info, $url_64); ?> ];

  $(document).ready(function() {

    $("#listado").find("thead").on("click", "a", function(e) {
      var href = this.href.split("#");
      if (href.length < 2) {
        return;
      }
      var field=href[1];

      $("#sortBy").val(field);
      $("#searchForm").submit();

	    e.preventDefault();

    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var tab = $(this).attr("data-tab");
      $("#selectedTab").val(tab);
    });

	  $("#busqueda-mapBtn").on("click", function() {
		  if ($modalMap != undefined) {
			  $modalMap.modal();
		  }
	  });

	  $("#busqueda-mapBtn_clear").on("click", function() {
		  if ($(this).hasClass("disabled")) {
			  return;
		  }
		  $("#mapInfo").val("");
		  $("#dataPolygons").val("");

		  $(this).addClass("disabled");
	  });

	  $("#busqueda-clear").on("click", function() {

		  $("#searchForm").find(':input').each(function() {
			  switch(this.type) {
				  case 'select-multiple':
				  case 'select-one':
				  case 'text':
				  case 'textarea':
					  $(this).val('');
					  break;
				  case 'checkbox':
				  case 'radio':
					  this.checked = false;
			  }
		  });

		  $("#dataPolygons").val("");
		  $("#busqueda-mapBtn_clear").addClass("disabled");

		  map_initShapes();

		  return false;
		});

	  $("#q").on("change", function() {
		  $("#dataPolygons").val($("#dataPolygons_hidden").val());
		  $("#mapInfo").val("");

		  if (selectedShape) {
			  selectedShape.setMap(null);
			  maps_createShapes();
		  }
	  });

	  $("#con-direcciones").on("click", function() {
			$("div.addr-inmueble").removeClass("hidden");
	  });

	  $("#pais_id").on("change", function() {
		  $("#mapInfo").val("");
		  $("#dataPolygons").val("");
		  $("#busqueda-mapBtn_clear").addClass("disabled");
		  map_initShapes();
	  });

	  maps_createMarkers(markers, infoWindowContent);
  });
</script>
<?php $this->end();

$this->start('sidebar');
echo $this->element('inmuebles_top');
$this->end();

echo $this->element('common/map_dialog');
echo $this->element('inmuebles/index_form_busqueda');
?>
<?php if (count($info) > 0): ?>
<ul class="nav nav-tabs nav-justified">
  <li<?php echo (($selectedTab == 'tab1')?" class='active'":""); ?>><a href="#listado" data-toggle="tab" data-tab="tab1"><i class="glyphicon glyphicon-list"></i> Listado</a></li>
  <li<?php echo (($selectedTab == 'tab2')?" class='active'":""); ?>><a href="#mapa" data-toggle="tab" data-tab="tab2" id="lnk-mapa"><i class="glyphicon glyphicon-map-marker"></i> Mapa</a></li>
  <li<?php echo (($selectedTab == 'tab3')?" class='active'":""); ?>><a href="#fotos" data-toggle="tab" data-tab="tab3"><i class="glyphicon glyphicon-th"></i> Fotos</a></li>
</ul>
<div class="tab-content">
  <br>
  <div id="listado" class="tab-pane fade<?php echo (($selectedTab == 'tab1')?" active in":""); ?>">
    <table class="table table-striped vertical-align-middle" id="listado">
      <thead>
      <?php
      echo $this->Html->tableHeaders(array(
        '',
        '<a href="#referencia">Ref.</a>',
        '<a href="#resumen">Resumen</a> / <a href="#poblacion">Poblaci&oacute;n</a> / <a href="#zona">Zona</a>',
        array('<a href="#precio">Precio</a>' => array('class' => 'text-right')),
	      array('m<sup>2</sup>' => array('class' => 'text-right')),
        array('precio/m<sup>2</sup>' => array('class' => 'text-right')),
	      'Estado',
	      'M&aacute;s info.',
        '<a href="#created desc">Fecha alta</a>', ''));
      ?>
      </thead>
      <tbody>
      <?php
      foreach ($info as $item) {
        $icons = '';
	      $can_edit = $this->Inmuebles->canEdit($profile, $item, $agencia, $agente);
	      if ($can_edit) {
          $icons = $this->Html->link('<i class="glyphicon glyphicon-edit"></i> editar', 'edit/' . $item['Inmueble']['id'] . '/' . $url_64, array('escape' => false));
        }
        $link = 'view/' . $item['Inmueble']['id'] . '/' . $url_64;
	      $baja = (!empty($item['Inmueble']['fecha_baja'])) ? ' baja' : '';

	      $tipo = $this->Inmuebles->getSubtipo($item);
			if (isset($item[$tipo]['estado_conservacion_id'])) {
				switch ($item[$tipo]['estado_conservacion_id']) {
					case '01':
						$estado = 'reformar';
						break;
					case '02':
						$estado = 'bueno';
						break;
					case '03':
						$estado = 'nuevo';
						break;
					default:
						$estado = '';
				}
			} else {
				$estado = '';
			}
	      $area = (!empty($item[$tipo]['area_total_construida'])) ? number_format($item[$tipo]['area_total_construida'], 0, ',', '.') : '';

	      if (empty($area)) {
		      $area = (!empty($item[$tipo]['area_total'])) ? number_format($item[$tipo]['area_total'], 0, ',', '.') : '';
	      }

	      $description = $this->Html->link($this->Inmuebles->printDescripcion($item), $link);

	      $can_view_address = $this->Inmuebles->canEdit($profile, $item, $agencia);
				if ($can_view_address) {
					$description .= '<div class="hidden addr-inmueble">' . $this->Inmuebles->printDireccion($item, false) . '</div>';
				}

        echo $this->Html->tableCells(array(
          $this->Html->link($this->Inmuebles->getFirstImage($item, 'p', array('width' => '50', 'no_forzar' => true)), $link, array('escape' => false)),
          $this->Html->link($item['Inmueble']['referencia'], $link),
	        $description,
          array($this->Html->link($this->Inmuebles->printPrecios($item), $link, array('escape' => false)), array('class' => 'text-right nowrap')),
	        array($this->Html->link($area, $link), array('class' => 'text-right nowrap')),
          array($this->Html->link($this->Inmuebles->getPrecioMedioMetro($item), $link, array('escape' => false)), array('class' => 'text-right nowrap')),
	        $this->Html->link($estado, $link),
	        $this->Html->link($this->Inmuebles->printDetalles($item, array('plantas' => $plantasPiso)), $link, array('escape' => false)),
          array($this->Html->link(substr($item['Inmueble']['created'], 0, 10), $link, array('escape' => false)), array('class' => 'nowrap')),
          array($icons, array('class' => 'nowrap'))), array('class' => "odd$baja"), array('class' => "even$baja", 'valign' => 'middle', 'escape' => false));
      }
      ?>
      </tbody>
    </table>

	  <p class="text-info text-right">Mostrados <?php echo count($info) ?> inmuebles.</p>

	  <div class="text-center">
      <ul class="pagination">
        <?php
        if (!empty($this->passedArgs['q'])) {
          $this->passedArgs['q'] = str_replace('/', '|', $this->passedArgs['q']);
        }
        $this->Paginator->options(array('url' => $this->passedArgs));
        echo $this->Paginator->numbers();
        ?>
      </ul>
    </div>

  </div>
  <div id="mapa" class="tab-pane fade<?php echo (($selectedTab == 'tab2')?" active in":""); ?>">

    <div id="map_wrapper">
      <div id="map_canvas"></div>
    </div>
  </div>
  <div id="fotos" class="tab-pane fade<?php echo (($selectedTab == 'tab3')?" active in":""); ?>">

    <div class="image-gallery-panel">
      <div class='image-gallery tam-m'>
        <?php foreach ($info as $item):
            $link = 'view/' . $item['Inmueble']['id'] . '/' . $url_64;
          ?>
          <div class="panel panel-default">
            <div class="panel-heading text-center"><?php echo $this->Inmuebles->printDescripcion($item); ?></div>
            <div class="panel-body">
              <?php echo $this->Html->link($this->Inmuebles->getFirstImage($item, 'm', array('no_forzar' => true)), $link, array('escape' => false)) ?>
            </div>
            <div class="panel-footer text-center"><?php echo $this->Html->link('REF. ' . $item['Inmueble']['referencia'], $link, array('escape' => false)); ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="text-center">
      <ul class="pagination">
        <?php
        if (!empty($this->passedArgs['q'])) {
          $this->passedArgs['q'] = str_replace('/', '|', $this->passedArgs['q']);
        }
        $this->Paginator->options(array('url' => $this->passedArgs));
        echo $this->Paginator->numbers();
        ?>
      </ul>
    </div>
  </div>
	<?php else: ?>
		<hr>
		<p class="text-info text-center">No se han encontrado resultados. Si est&aacute; buscando informaci&oacute;n dentro de otras agencias entonces ser&aacute; necesario
		que defina un &aacute;rea de b&uacute;squeda.</p>
	<?php endif; ?>
</div>

<div id="map_canvas"></div>