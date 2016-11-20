<?php

// app/Model/Garaje.php

/**
 * Description of Garaje
 *
 * @author dmonje
 */
class Garaje extends AppModel {

  public $name = 'Garaje';
  public $useTable = 'garajes';
  public $belongsTo = array(
      'TipoGaraje' => array('foreignKey' => 'tipo_garaje_id'),
      'EstadoConservacion' => array('foreignKey' => 'estado_conservacion_id'));
}
