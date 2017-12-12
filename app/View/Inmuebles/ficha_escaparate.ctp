<?php
$config = Configure::read('alfainmo');
$img_path = $config ['images.path'];
$rtf_file = 'ficha-escaparate-' . $info['Inmueble']['numero_agencia'] . '-' . $info['Inmueble']['codigo'] . '.rtf';

header('Content-Disposition: attachment; filename="' . $rtf_file . '"');

App::import('Vendor', 'phprtflite', array('file' => 'phprtf' . DS . 'PHPRtfLite.php'));

PHPRtfLite::registerAutoloader();
$rtf = new PHPRtfLite();

$rtf->setMarginLeft(1);
$rtf->setMarginRight(1);
$rtf->setMarginTop(1);
$rtf->setMarginBottom(1);

$sect = $rtf->addSection();

// Formatos
$centerFormat = new PHPRtfLite_ParFormat('center');

$font = new PHPRtfLite_Font(16, 'Arial');
// Titular de la ficha de escaparate

$sect->addImage(realpath('img/cab-ficha-escaparate.png'), $centerFormat, 19);

$sect->writeText('<br>');
$sect->writeText('Referencia ' . $info['Inmueble']['referencia'], new PHPRtfLite_Font(16, 'Arial'), new PHPRtfLite_ParFormat('center'));

$paragraph = new PHPRtfLite_ParFormat();
$paragraph->setTextAlignment('center');

$sect->writeText('<hr><br>Hoja informativa. No incluidos gastos de Escrituración, Registro e Impuestos.'
                 . ' El comprador solo pagará honorarios si figura así expresamente en el apartado descripción. Los arrendadores tienen la obligación legal'
                 . ' de efectuar el depósito de la fianza legal ante el organismo autonómico que corresponda.'
                 . ' Para estas y otras informaciones ver aviso legal.', new PHPRtfLite_Font(7, 'Arial'), $paragraph);

/**
 * TABLA DE IMÁGENES
 */
$table = $sect->addTable();
$table->addRow();
$table->addColumnsList([6, 6, 6]);

$left_cell = $table->getCell(1, 1);
$center_cell = $table->getCell(1, 2);
$right_cell = $table->getCell(1, 3);

$left_cell->setCellPaddings(0.2, 0.2, 0.2, 0.2);
$center_cell->setPaddingLeft(0.2, 0.2, 0.2, 0.2);
$right_cell->setPaddingLeft(0.2, 0.2, 0.2, 0.2);

// Foto 1
$img = $img_path . $this->Inmuebles->getFirstImage($info, 'm', array('nohtml' => true, 'no_forzar' => true));
if (file_exists($img)) {
	$left_cell->addImage($img);
}

// Foto 2
$img = $img_path . $this->Inmuebles->getImageIndex($info, 'm', 1, array('nohtml' => true, 'no_forzar' => true));
if (file_exists($img)) {
	$center_cell->addImage($img);
}

// Foto 3
$img = $img_path . $this->Inmuebles->getImageIndex($info, 'm', 2, array('nohtml' => true, 'no_forzar' => true));
if (file_exists($img)) {
	$right_cell->addImage($img);
}

/**
 *
 */

if (!empty($info['Inmueble']['descripcion'])) {
	$sect->writeText($info['Inmueble']['descripcion'] . '<br>', new PHPRtfLite_Font(10, 'Arial'));
}
$sect->writeText($this->Inmuebles->printDescripcion($info) . '<br>', new PHPRtfLite_Font(12, 'Arial'), $centerFormat);

// Descripción
$subtipo = $this->Inmuebles->getSubtipo($info);

$lines = [];

if ($info['Inmueble']['es_venta'] == 't') {
	$lines[] = $this->Model->getIfExists($info, 'precio_venta', array('label' => 'Precio de venta:', 'format' => 'currency'));
}
if ($info['Inmueble']['es_alquiler'] == 't') {
	$lines[] = $this->Model->getIfExists($info, 'precio_alquiler', array('label' => 'Precio de alquiler:', 'format' => 'currency'));
}
if ($info['Inmueble']['es_traspaso'] == 't') {
	$lines[] = $this->Model->getIfExists($info, 'precio_traspaso', array('label' => 'Precio de traspaso::', 'format' => 'currency'));
}

$lines[] = $this->Model->getIfExists($info, 'anio_construccion', array('label' => 'A&ntilde;o de construcci&oacute;n:', 'model' => $subtipo, 'format' => 'number'));
$lines[] = $this->Model->getIfExists($info, 'area_total_construida', array('label' => 'M2 Construidos:', 'model' => $subtipo, 'format' => 'area'));
$lines[] = $this->Model->getIfExists($info, '["' . $subtipo . '"]["PlantaPiso"]["description"]', array('label' => 'Piso:', 'model' => 'expression'));
$lines[] = $this->Model->getIfExists($info, 'numero_habitaciones', array('label' => 'Habitaciones:', 'model' => $subtipo));
$lines[] = $this->Model->getIfExists($info, 'numero_banos', array('label' => 'Ba&ntilde;os:', 'model' => $subtipo));
$lines[] = $this->Model->getIfExists($info, 'numero_aseo_', array('label' => 'Aseos:', 'model' => $subtipofermin));
$lines[] = $this->Model->getIfExists($info, 'numero_ascensores', array('label' => 'Ascensores:', 'model' => $subtipo));

$lines[] = $this->Model->getBooleans($info, array(
		'con_piscina' => 'piscina',
		'con_parking' => 'parking',
		'con_areas_verdes' => 'áreas verdes',
		'con_zonas_infantiles' => 'zona de juego infantil',
		'con_trastero' => 'trastero'), array('model' => $subtipo, 'label' => 'Con '));

$lines[] = $this->Model->getIfExists($info, '["' . $subtipo . '"]["TipoSuelo"]', array('label' => 'Suelos:', 'model' => 'expression'));
$lines[] = $this->Model->getIfExists($info, '["' . $subtipo . '"]["TipoPuerta"]', array('label' => 'Puertas:', 'model' => 'expression'));
$lines[] = $this->Model->getIfExists($info, '["' . $subtipo . '"]["TipoVentana"]', array('label' => 'Ventanas:', 'model' => 'expression'));

$lines[] = $this->Model->getBooleans($info, array(
		'["' . $subtipo . '"]["TipoCalefaccion"]["description"]' => 'calefacción',
		'["' . $subtipo . '"]["TipoAA"]["description"]' => 'aire acondicionado ',
		'["' . $subtipo . '"]["TipoAguaCaliente"]["description"]' => 'agua caliente',
		'["' . $subtipo . '"]["TipoTendedero"]["description"]' => 'tendedero',
		'["' . $subtipo . '"]["TipoEquipamiento"]["description"]' => ''), array('model' => 'expression', 'label' => 'Equipamiento: '));

$lines[] = $this->Model->getIfExists($info, '["' . $subtipo . '"]["CalificacionEnergetica"]["description"]', array('label' => 'Calificación energética:', 'model' => 'expression'));

$format = new PHPRtfLite_ParFormat('left');
$font = new PHPRtfLite_Font(10, 'Arial');

foreach ($lines as $line) {
	if (!empty($line)) {
		$sect->writeText(' - ' . strip_tags($line), $font, $format);
	}
}

$sect->writeText('<br><br>');
$sect->addImage(realpath('img/calificacion-energetica.png'), new PHPRtfLite_ParFormat('right'), 2);

$rtf->sendRtf($rtf_file);