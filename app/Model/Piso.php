<?php

// app/Model/Piso.php

class Piso extends AppModel {

  public $name = 'Piso';
  public $useTable = 'pisos';
  public $belongsTo = array(
      'TipoPiso' => array('foreignKey' => 'tipo_piso_id'),
	    'PlantaPiso' => array('foreignKey' => 'piso'),
      'EstadoConservacion' => array('foreignKey' => 'estado_conservacion_id'),
      'TipoCalefaccion' => array('foreignKey' => 'tipo_calefaccion_id'),
      'TipoAguaCaliente' => array('foreignKey' => 'tipo_agua_caliente_id'),
      'TipoAA' => array('foreignKey' => 'tipo_aa_id'),
      'InteriorExterior' => array('foreignKey' => 'interior_exterior_id'),
      'TipoOrientacion' => array('foreignKey' => 'tipo_orientacion_id'),
      'TipoEquipamiento' => array('foreignKey' => 'tipo_equipamiento_id'),
      'TipoTendedero' => array('foreignKey' => 'tipo_tendedero_id'),
      'CalificacionEnergetica' => array('foreignKey' => 'calificacion_energetica_id'));
  public $hasAndBelongsToMany = array(
      'TipoPuerta' => array(
          'className' => 'TipoPuerta',
          'joinTable' => 'pisos_tipo_puerta',
          'foreignKey' => 'piso_id',
          'associationForeignKey' => 'tipo_puerta_id',
          'unique' => 'keepExisting',
      ),
      'TipoVentana' => array(
          'className' => 'TipoVentana',
          'joinTable' => 'pisos_tipo_ventana',
          'foreignKey' => 'piso_id',
          'associationForeignKey' => 'tipo_ventana_id',
          'unique' => 'keepExisting',
      ),
      'TipoSuelo' => array(
          'className' => 'TipoSuelo',
          'joinTable' => 'pisos_tipo_suelo',
          'foreignKey' => 'piso_id',
          'associationForeignKey' => 'tipo_suelo_id',
          'unique' => 'keepExisting',
      )
  );
  /*
  public function beforeSave($options = array()) {
    foreach (array_keys($this->hasAndBelongsToMany) as $model) {
      if (isset($this->data[$this->name][$model])) {
        $this->data[$model][$model] = $this->data[$this->name][$model];
        unset($this->data[$this->name][$model]);
      }
    }
    return true;
  }
  */
}

