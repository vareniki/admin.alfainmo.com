<?php

// app/Model/Agencia.php

class Agencia extends AppModel {

	public $name = 'Agencia';
	public $useTable = 'agencias';
  public $hasOne = 'User';
	public $hasMany = 'Agente';
	public $belongsTo = 'Pais';

	public $hasAndBelongsToMany = array(
			'Portal' => array(
					'className' => 'Portal',
					'joinTable' => 'agencias_portal',
					'foreignKey' => 'agencia_id',
					'associationForeignKey' => 'portal_id',
					'unique' => 'keepExisting',
			)
	);
}
