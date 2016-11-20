<?php

$config['logQueries'] = 1;
$config['alfainmo'] = array(
  'images.path' => '/Users/dmonje/Public/imagenes_alfa/',
	'documents.path' => '/Users/dmonje/Public/documentos_alfa/',
  'jquery.ie8.js' => 'http://code.jquery.com/jquery-1.11.3.min.js',
  'jquery.js' => 'http://code.jquery.com/jquery-2.1.4.min.js',
  'maps.api.js' => 'http://maps.google.com/maps/api/js?sensor=false',
  'catastro.url' => 'http://ovc.catastro.meh.es/ovcservweb/ovcswlocalizacionrc/ovccallejero.asmx/Consulta_DNPLOC'
);

$config['portales'] = array(
	array('img' => 'inmogeo.gif',           'link' => 'inmogeo',                'title' => 'Inmogeo',           'info' => 'texto texto texto'),
	array('img' => 'en_alquiler.gif',       'link' => 'en_alquiler',            'title' => 'En Alquiler',       'info' => 'texto texto texto'),
	array('img' => 'casas_con_jardin.gif',  'link' => 'casas_con_jardin',       'title' => 'Casas con Jardín',  'info' => 'texto texto texto'),
	array('img' => 'tevagustar.gif',        'link' => 'tevagustarinmobiliaria', 'title' => 'Te va a gustar Inmobiliaria', 'info' => 'texto texto texto'),
	array('img' => 'trovit.png',            'link' => 'trovit',                 'title' => 'Trovit',            'info' => 'texto texto texto'));



Configure::write('Froala.editorOptions', array('height' => '300px'));