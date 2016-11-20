<?php

// app/Model/Local.php

class Local extends AppModel {

  public $name = 'Local';
  public $useTable = 'locales';
  public $belongsTo = array(
      'EstadoConservacion' => array('foreignKey' => 'estado_conservacion_id'),
      'TipoCalefaccion' => array('foreignKey' => 'tipo_calefaccion_id'),
      'TipoAguaCaliente' => array('foreignKey' => 'tipo_agua_caliente_id'),
      'TipoAA' => array('foreignKey' => 'tipo_aa_id'),
      'LocalizacionLocal' => array('foreignKey' => 'localizacion_local_id'),
      'CalificacionEnergetica' => array('foreignKey' => 'calificacion_energetica_id'));
  public $hasAndBelongsToMany = array(
      'TipoPuerta' => array(
          'className' => 'TipoPuerta',
          'joinTable' => 'locales_tipo_puerta',
          'foreignKey' => 'local_id',
          'associationForeignKey' => 'tipo_puerta_id',
          'unique' => 'keepExisting',
      ),
      'TipoVentana' => array(
          'className' => 'TipoVentana',
          'joinTable' => 'locales_tipo_ventana',
          'foreignKey' => 'local_id',
          'associationForeignKey' => 'tipo_ventana_id',
          'unique' => 'keepExisting',
      ),
      'TipoSuelo' => array(
          'className' => 'TipoSuelo',
          'joinTable' => 'locales_tipo_suelo',
          'foreignKey' => 'local_id',
          'associationForeignKey' => 'tipo_suelo_id',
          'unique' => 'keepExisting',
      )
  );

}
