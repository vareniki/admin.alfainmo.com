<?php

// app/Model/Chalet.php

class Chalet extends AppModel {

  public $name = 'Chalet';
  public $useTable = 'chalets';
  public $belongsTo = array(
      'TipoChalet' => array('foreignKey' => 'tipo_chalet_id'),
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
          'joinTable' => 'chalets_tipo_puerta',
          'foreignKey' => 'chalet_id',
          'associationForeignKey' => 'tipo_puerta_id',
          'unique' => 'keepExisting'
      ),
      'TipoVentana' => array(
          'className' => 'TipoVentana',
          'joinTable' => 'chalets_tipo_ventana',
          'foreignKey' => 'chalet_id',
          'associationForeignKey' => 'tipo_ventana_id',
          'unique' => 'keepExisting',
      ),
      'TipoSuelo' => array(
          'className' => 'TipoSuelo',
          'joinTable' => 'chalets_tipo_suelo',
          'foreignKey' => 'chalet_id',
          'associationForeignKey' => 'tipo_suelo_id',
          'unique' => 'keepExisting',
      )
  );

}
