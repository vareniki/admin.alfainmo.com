<?php

// app/Model/Evento.php

class Evento extends AppModel {

	public $name = 'Evento';
	public $useTable = 'eventos';
	public $belongsTo = array(
			'TipoEvento' => array('foreignKey' => 'tipo_evento_id'),
			'Agencia' => array('foreignKey' => 'agencia_id'),
			'Agente' => array('foreignKey' => 'agente_id'),
			'Inmueble' => array('foreignKey' => 'inmueble_id'),
			'Propietario' => array('foreignKey' => 'propietario_id'),
			'Demandante' => array('foreignKey' => 'demandante_id'));

}
