<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view2');

$title = 'Referencia ' . $info['Inmueble']['referencia'] . ' - ' . $info['TipoInmueble']['description'];
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('inmuebles_left');
echo $this->element('inmuebles/common_view_left');
$this->end();

$this->start('header');
echo $this->Html->script(array('alfainmo.docs'));
?>
<script type="text/javascript">
	var eventsLoaded=false;
	var demandasLoaded=false;
	$(document).ready(function () {
		initGalleryButtons();

		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

			switch ($(e.target).prop("hash")) {
				case '#tab5':
					if (!eventsLoaded) {
						$("#eventsForm").ajaxSubmit({	target: "#eventsForm_results"	});
						eventsLoaded = true;
					}
					break;
				case '#tab6':
					if (!demandasLoaded) {
						$("#demandasForm").ajaxSubmit({	target: "#demandasForm_results"	});
						demandasLoaded = true;
					}
					break
			}

		});

	});
</script>
<?php
$this->end();

$subinfo = $this->Inmuebles->getSubtipoInfo($info);
$url_64 = $this->data['referer'];

$ver_todo = $profile['is_central'] || $agencia['Agencia']['id'] == $info['Agencia']['id'];
?>
<div class="tabbable">
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab1" data-toggle="tab">Caracter&iacute;sticas</a></li>
	<li><a href="#tab2" data-toggle="tab">Gesti&oacute;n / internos</a></li>
	<li><a href="#tab3" data-toggle="tab">Fotos / v&iacute;deo</a></li>
	<?php if ($ver_todo): ?>
		<li><a href="#tab4" data-toggle="tab">Documentos</a></li>
	<?php endif; ?>
	<li><a href="#tab5" data-toggle="tab">Seguimiento</a></li>
	<li><a href="#tab6" data-toggle="tab">Demandantes</a></li>
</ul>
<div class="tab-content">
<div id="tab1" class="tab-pane active ficha">
	<p class="titulo">Informaci&oacute;n</p>

	<div class="row">
		<div class="col-xs-12 col-sm-8">
			<p><?php
				$adicional = (!empty($subinfo['urbanizacion'])) ? 'Urbanizaci&oacute;n ' . $subinfo['urbanizacion'] : '';
				echo $this->Inmuebles->printDescripcion($info, $adicional);
				?>
			</p>
			<br>
			<ul>
				<?php
				if ($info['Inmueble']['es_venta'] == 't') {
					$this->Model->printIfExists($info, 'precio_venta', array('label' => 'Precio de venta', 'format' => 'currency'));
				}
				if ($info['Inmueble']['es_alquiler'] == 't' || $info['Inmueble']['es_opcion_compra'] == 't') {
					$this->Model->printIfExists($info, 'precio_alquiler', array('label' => 'Precio de alquiler', 'format' => 'currency'));
				}
				if ($info['Inmueble']['es_traspaso'] == 't') {
					$this->Model->printIfExists($info, 'precio_traspaso', array('label' => 'Precio de traspaso', 'format' => 'currency'));
				}
				if ($info['Inmueble']['es_opcion_compra'] == 't') {
					echo '<p class="text-info">(el inmueble tiene opci&oacute;n a compra)</p>';
				}
				
				if ( isset($tipoInmueble) ) {	
					$tipoUC = ucfirst($tipoInmueble);
					if ( isset($info[$tipoUC]['es_vpo']) && $info[$tipoUC]['es_vpo'] == 't' ) {
						echo '<p class="text-info">(el inmueble es VPO)</p>';
					}
				}
				?>
			</ul>
			<?php
			if ($info['Inmueble']['es_promocion'] == 't') {
				echo '<p class="text-info">El inmueble forma parte de una promoci&oacute;n.</p>';
				echo '<ul>';
				$this->Model->printIfExists($info, 'nombre_promocion', array('label' => 'Nombre promoci&oacute;n'));
				$this->Model->printIfExists($info, 'entrega_promocion', array('label' => 'Entrega promoci&oacute;n'));
				echo '</ul>';
			}

			if (isset($tipoInmueble)) {
				echo $this->element("inmuebles/view_info_$tipoInmueble");
			}
			?>
			<ul>
				<?php
				if (!empty($info['Inmueble']['calidad_precio']) && !empty($calidadPrecio[$info['Inmueble']['calidad_precio']])) {
				echo '<li><span>Calidad / precio</span>' . $calidadPrecio[$info['Inmueble']['calidad_precio']] . '.</li>';
				} ?>
			</ul>
			<?php
			if (!empty($info['Inmueble']['descripcion'])) {
				echo '<p class="titulo">Descripci&oacute;n completa:</p>';
				$this->Model->printIfExists($info, 'descripcion', array('tag' => 'p'));
			}

			if (!empty($info['Inmueble']['descripcion_abreviada'])) {
				echo '<p class="titulo">Descripci&oacute;n abreviada:</p>';
				$this->Model->printIfExists($info, 'descripcion_abreviada', array('tag' => 'p'));
			}
			?>
		</div>

		<div class="col-xs-12 col-sm-4">
			<?php echo $this->Inmuebles->getFirstImage($info, 'm', array('class' => 'img-responsive')); ?>
		</div>
	</div>

</div>

<div id="tab2" class="tab-pane ficha">
	<p class="titulo">Localizaci&oacute;n</p>
	<?php $ciudad = $this->Inmuebles->printCiudad($info);

	if (!empty($ciudad)):
		$this->Inmuebles->printCiudad($info);
		?>
		<ul>
			<li><?php echo $ciudad; ?>.</li>
			<?php if ($ver_todo): ?>
				<li><?php echo $this->Inmuebles->printDireccion($info); ?>.</li>
				<?php
				if (!empty($subinfo['kilometro'])) {
					echo '<li><span>Kil&oacute;metro</span>' . $this->Number->format((int)$subinfo['kilometro'], array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . '</li>';
				}
				if (!empty($subinfo['numero'])) {
					echo '<li><span>N&uacute;mero</span>' . $this->Number->format((int)$subinfo['numero'], array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . '</li>';
				}
				if (!empty($subinfo['numero_plaza'])) {
					echo '<li><span>N&uacute;mero de plaza</span>' . $this->Number->format((int)$subinfo['numero_plaza'], array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . '</li>';
				}
				?>
				<?php if ($ver_todo && !empty($info['Inmueble']['coord_x']) && !empty($info['Inmueble']['coord_y'])): ?>
					<div class="text-right"><a
							href="http://maps.google.com/?q=<?php echo $info['Inmueble']['coord_x'] ?>,<?php echo $info['Inmueble']['coord_y'] ?>"
							target="_blank">Ver mapa m&aacute;s grande.</a></div>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
	<?php endif; ?>

	<p class="titulo">Agencia</p>
	<ul>
		<?php
		if (!empty($info['Agencia']['coord_x']) && !empty($info['Agencia']['coord_y'])) {
			$adicional = '<a href="http://maps.google.com/?q=' . $info['Agencia']['coord_x'] . ',' . $info['Agencia']['coord_y'] . '" target="_blank">[localizar]</a>';
		} else {
			$adicional = '';
		}

		$this->Model->printIfExists($info, array('nombre_agencia', 'numero_agencia'), array('label' => 'Agencia', 'model' => 'Agencia', 'separator' => '-', 'adicional' => $adicional));
		$this->Model->printIfExists($info, array('poblacion', 'provincia'), array('label' => 'Localización', 'model' => 'Agencia'));
		$this->Model->printIfExists($info, array('telefono1_contacto', 'telefono2_contacto'), array('label' => 'Teléfonos', 'format' => 'tel', 'model' => 'Agencia'));
		$this->Model->printIfExists($info, 'email_contacto', array('label' => 'EMail', 'model' => 'Agencia', 'format' => 'email'));
		$this->Model->printIfExists($info, 'web', array('label' => 'Web', 'model' => 'Agencia', 'format' => 'web'));
		$this->Model->printIfExists($info, 'nombre_contacto', array('label' => 'Agente', 'model' => 'Agente'));
		$this->Model->printIfExists($info, 'telefono1_contacto', array('label' => 'Agente', 'model' => 'Tfno. agente'));
		?>
	</ul>

	<p class="titulo">Gesti&oacute;n</p>
	<ul>
		<?php
		$this->Model->printIfExists($info, 'created', array('label' => 'Fecha de alta', 'format' => 'date'));
		$this->Model->printIfExists($info, 'modified', array('label' => 'Fecha de modificación', 'format' => 'date'));
		$this->Model->printIfExists($info, 'description', array('label' => 'Estado', 'model' => 'EstadoInmueble'));
		$this->Model->printIfExists($info, 'description', array('label' => 'Tipo de encargo', 'model' => 'TipoContrato'));
		$this->Model->printIfExists($info, 'description', array('label' => 'Medio captación', 'model' => 'MedioCaptacion'));
		$this->Model->printIfExists($info, 'fecha_captacion', array('label' => 'Fecha de captación', 'format' => 'date'));
		$this->Model->printIfExists($info, 'observaciones', array('label' => 'Observaciones internas', 'format' => 'links_html'));
		?>
	</ul>
	<ul>
		<?php
		$this->Model->printIfExists($info, 'description', array('label' => 'Motivo de baja', 'model' => 'MotivoBaja'));
		$this->Model->printIfExists($info, 'fecha_baja', array('label' => 'Fecha de baja', 'format' => 'date'));
		?>
	</ul>
	<?php if ($ver_todo): ?>
		<ul>
			<?php
			$this->Model->printBooleans($info, array(
					'cartel' => 'cartel',
					'llaves_oficina' => 'llaves oficina'), array('model' => 'Inmueble', 'label' => 'Más información'));
			?>
		</ul>
		<p class="titulo">Contacto</p>
		<ul>
			<?php
			$this->Model->printIfExists($info, 'nombre_contacto', array('label' => 'Nombre', 'model' => 'Cliente'));
			$this->Model->printIfExists($info, 'email_contacto', array('label' => 'EMail', 'format' => 'email', 'model' => 'Cliente'));
			$this->Model->printIfExists($info, array('telefono1_contacto', 'telefono2_contacto'), array('label' => 'Teléfonos', 'format' => 'tel', 'model' => 'Cliente'));
			$this->Model->printIfExists($info, '["Cliente"]["HorarioContacto"]["description"]', array('label' => 'Horario de contacto', 'model' => 'expression'));
			$this->Model->printIfExists($info, 'llaves', array('label' => 'Llaves'));
			?>
		</ul>
	<?php endif; ?>
		<p class="titulo">Colaborador / comisiones</p>
		<ul>
			<?php
			$this->Model->printIfExists($info, array('honor_agencia', 'honor_agencia_unid'), array('label' => 'Honorarios agencia', 'separator' => '', 'format' => 'ud_moneda'));
			$this->Model->printIfExists($info, array('honor_agencia_alq', 'honor_agencia_alq_unid'), array('label' => 'Honorarios alquiler', 'separator' => '', 'format' => 'ud_moneda'));
			?>
			<li><span>Precio propietario:</span><?php echo $this->Inmuebles->getPrecioPropietario($info); ?></li>
		</ul>
		<ul>
			<?php $this->Model->printIfExists($info, 'honor_compartidos', array('label' => 'Honorarios compartidos', 'format' => 'porc')); ?>
		</ul>
	<?php if ($ver_todo): ?>
		<ul>
			<?php
			$this->Model->printIfExists($info, 'nombre_colaborador', array('label' => 'Colaborador'));
			$this->Model->printIfExists($info, array('honor_colaborador', 'honor_colaborador_unid'), array('label' => 'Honorarios colaborador', 'separator' => '', 'format' => 'ud_moneda'));
			?>
		</ul>
	<?php endif; ?>

	<?php if ($ver_todo): ?>
		<p class="titulo">Datos registrales</p>
		<ul>
			<?php
			if ($info['Inmueble']['sin_ref_catastral'] == 't') {
				echo 'sin referencia catastral.';
			} else {
				$this->Model->printIfExists($info, 'ref_catastral', array('label' => 'Ref. Catastral'));
			}
			$this->Model->printIfExists($info, 'registro_de', array('label' => 'Registro de'));
			$this->Model->printIfExists($info, 'registro_numero', array('label' => 'Número'));
			$this->Model->printIfExists($info, 'registro_tomo', array('label' => 'Tomo'));
			$this->Model->printIfExists($info, 'registro_finca', array('label' => 'Finca'));
			$this->Model->printIfExists($info, 'registro_libro', array('label' => 'Libro'));
			$this->Model->printIfExists($info, 'registro_folio', array('label' => 'Folio'));
			echo '<br>';
			$this->Model->printIfExists($info, 'registro_m2', array('label' => 'M2. Registro'));
			?>
		</ul>
	<?php endif; ?>
</div>

<div id="tab3" class="tab-pane ficha">

	<?php if (!empty($info['Inmueble']['video'])): ?>
		<p class="titulo">V&iacute;deo</p>
		<div class='text-right'>
			<?php echo $info['Inmueble']['video']; ?>
		</div>
	<?php endif; ?>
	<p class="titulo">Fotos</p>

	<div id='gallery-buttons' class="btn-group pull-right">
		<button type="button" class="btn btn-default btn-sm active" itemprop='p'><i class='glyphicon glyphicon-th'></i></button>
		<button type="button" class="btn btn-default btn-sm" itemprop='m'><i class='glyphicon glyphicon-th-large'></i></button>
		<button type="button" class="btn btn-default btn-sm" itemprop='g'><i class='glyphicon glyphicon-th-list'></i></button>
	</div>
	<br>
	<div class="image-gallery-panel">
		<div class='image-gallery tam-p'>
			<?php
			$images = $this->Inmuebles->getAllImages($info, array('class' => 'img-responsive', 'no_forzar' => true));
			foreach ($images as $image):
				?>
				<div class="panel panel-default">
					<div class="panel-heading text-center"><?php echo $image['type-desc'] ?></div>
					<div class="panel-body">
						<?php echo $image['url-p'] ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php if ($ver_todo): ?>
	<div id="tab4" class="tab-pane">
		<ul class="list-group">
			<?php
			foreach ($this->Inmuebles->getAllDocuments($info) as $doc):
				?>
				<li class="list-group-item"><i class="glyphicon glyphicon-link"></i> <a
						href="<?php echo $doc['url'] ?>"><?php echo $doc['desc'] ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
<div id="tab5" class="tab-pane">
	<?php
	echo $this->Form->create(false, array('id' => 'eventsForm', 'url' => array('action' => 'getEventosInmueble', 'controller' => 'ajax')));
	echo $this->Form->hidden('inmueble_id', array('name' => 'inmueble_id', 'value' => $info['Inmueble']['id']));
	echo $this->Form->end();
	?>
	<div id="eventsForm_results"></div>
</div>
<div id="tab6" class="tab-pane">
	<?php
	$url_base_64 = base64_encode($this->Html->url($this->request->data));

	echo $this->Form->create(false, array('id' => 'demandasForm', 'url' => array('action' => 'getDemandasInmueble', 'controller' => 'ajax')));
	echo $this->Form->hidden('inmueble_id', array('name' => 'inmueble_id', 'value' => $info['Inmueble']['id']));
	echo $this->Form->hidden('url', array('name' => 'url', 'value' => $url_base_64));
	echo $this->Form->end();
	?>
	<div id="demandasForm_results"></div>
</div>
</div>
</div>
<?php if ($info['Inmueble']['estado_inmueble_id'] == '02'): ?>
	<div>
		<a
			href="http://www.alfainmo.com/referencia/?id=<?php echo $info['Inmueble']['id'] ?>&referencia=<?php echo $info['Inmueble']['numero_agencia'] ?>-<?php echo $info['Inmueble']['codigo'] ?>"
			target="_blank">Ficha en la Web</a>
	</div>
<?php endif; ?>
<hr>
<div class="text-right">
	<?php
	echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> nuevo apunte', '/agenda/add/inmueble_id/' . $info['Inmueble']['id'] . '/' . $url_64, array('escape' => false, 'class' => 'btn btn-sm btn-default')) . "\n\n";
	echo $this->Html->link('Ficha de escaparate', 'fichaEscaparate/' . $info['Inmueble']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm')) . "\n";
	echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> volver al listado', '/inmuebles/index', array('class' => 'btn btn-default btn-sm', 'escape' => false)) . "&nbsp;";

	$can_edit = $this->Inmuebles->canEdit($profile, $info, $agencia, $agente);
	if ($can_edit) {
		$edit = 'edit/' . $info['Inmueble']['id'] . '/' . $url_64;
		echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i> editar', $edit, array('class' => 'btn btn-sm btn-default', 'escape' => false)) . "&nbsp;\n";
	}
	?>
</div>