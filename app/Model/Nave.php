<?php

// app/Model/Nave.php

class Nave extends AppModel {

  public $name = 'Nave';
  public $useTable = 'naves';
  public $belongsTo = array(
	    'PlantaPiso' => array('foreignKey' => 'piso'),
      'EstadoConservacion' => array('foreignKey' => 'estado_conservacion_id'),
      'TipoCalefaccion' => array('foreignKey' => 'tipo_calefaccion_id'),
      'TipoAguaCaliente' => array('foreignKey' => 'tipo_agua_caliente_id'),
      'TipoAA' => array('foreignKey' => 'tipo_aa_id'),
      'CalificacionEnergetica' => array('foreignKey' => 'calificacion_energetica_id'));
  public $hasAndBelongsToMany = array(
      'TipoPuerta' => array(
          'className' => 'TipoPuerta',
          'joinTable' => 'naves_tipo_puerta',
          'foreignKey' => 'nave_id',
          'associationForeignKey' => 'tipo_puerta_id',
          'unique' => 'keepExisting',
      ),
      'TipoVentana' => array(
          'className' => 'TipoVentana',
          'joinTable' => 'naves_tipo_ventana',
          'foreignKey' => 'nave_id',
          'associationForeignKey' => 'tipo_ventana_id',
          'unique' => 'keepExisting',
      ),
      'TipoSuelo' => array(
          'className' => 'TipoSuelo',
          'joinTable' => 'naves_tipo_suelo',
          'foreignKey' => 'nave_id',
          'associationForeignKey' => 'tipo_suelo_id',
          'unique' => 'keepExisting',
      )
  );

}
