<?php

// app/Model/Poblacion.php

class Poblacion extends AppModel {

  public $name = 'Poblacion';
  public $useTable = 'tgis_poblaciones';
	public $displayField = 'description';

	public $belongsTo = array('Provincia' => array('foreignKey' => 'provincia_id'));
}
