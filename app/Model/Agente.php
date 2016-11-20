<?php

// app/Model/Demandante.php

class Agente extends AppModel {

	public $name = 'Agente';
	public $useTable = 'agentes';
	public $belongsTo = array('Agencia', 'Pais');
	public $hasOne = 'User';
}
