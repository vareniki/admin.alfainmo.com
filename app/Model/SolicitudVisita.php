<?php

// app/Model/Evento.php

class SolicitudVisita extends AppModel {

	public $name = 'SolicitudVisita';
	public $useTable = 'solicitud_visitas';
	public $belongsTo = [
      'Inmueble'   => ['foreignKey' => 'inmueble_id'],
			'FntAgencia' => ['className'  => 'Agencia', 'foreignKey' => 'fnt_agencia_id'],
			'FntAgente'  => ['className'  => 'Agente',  'foreignKey' => 'fnt_agente_id'],
      'DstAgencia' => ['className'  => 'Agencia', 'foreignKey' => 'dst_agencia_id']
  ];
}
