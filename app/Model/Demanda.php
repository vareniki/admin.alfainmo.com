<?php

// app/Model/Demandante.php

class Demanda extends AppModel {

	public $name = 'Demanda';
	public $useTable = 'demandas';
	public $hasOne = 'Demandante';

	public $belongsTo = array(
		'TipoInmueble' => array('foreignKey' => 'tipo'),
		'EstadoConservacion' => array('foreignKey' => 'estado_conservacion'));
}
