<?php

// app/Model/Pais.php

class Pais extends AppModel {

  public $name = 'Pais';
  public $useTable = 'tgis_paises';
	public $displayField = 'description';

	public $hasAndBelongsToMany = array(
		'TipoMoneda' => array(
			'className' => 'TipoMoneda',
			'joinTable' => 'monedas_pais',
			'foreignKey' => 'pais_id',
			'associationForeignKey' => 'tipo_moneda_id',
			'order' => 'orden',
			'unique' => 'keepExisting',
      'alias' => 'MonedaPais'
		)
	);
}
