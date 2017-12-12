<?php

$config['logQueries'] = 1;
$config['alfainmo'] = array(
  'images.path' => '/Users/dmonje/Public/imagenes_alfa/',
	'documents.path' => '/Users/dmonje/Public/documentos_alfa/',
  'catastro.url' => 'http://ovc.catastro.meh.es/ovcservweb/ovcswlocalizacionrc/ovccallejero.asmx/Consulta_DNPLOC'
);

$config['portales'] = array(
	array('img' => 'inmogeo.gif',           'link' => 'inmogeo',                'title' => 'Inmogeo',           'info' => 'texto texto texto'),
	array('img' => 'en_alquiler.gif',       'link' => 'en_alquiler',            'title' => 'En Alquiler',       'info' => 'texto texto texto'),
	array('img' => 'casas_con_jardin.gif',  'link' => 'casas_con_jardin',       'title' => 'Casas con Jardín',  'info' => 'texto texto texto'),
	array('img' => 'tevagustar.gif',        'link' => 'tevagustarinmobiliaria', 'title' => 'Te va a gustar Inmobiliaria', 'info' => 'texto texto texto'),
	array('img' => 'trovit.png',            'link' => 'trovit',                 'title' => 'Trovit',            'info' => 'texto texto texto'));



Configure::write('Froala.editorOptions', array('height' => '300px'));