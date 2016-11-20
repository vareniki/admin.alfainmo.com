<?php

// app/Model/Oficina.php

class Oficina extends AppModel {

  public $name = 'Oficina';
  public $useTable = 'oficinas';
  public $belongsTo = array(
      'TipoOficina' => array('foreignKey' => 'tipo_oficina_id'),
	    'PlantaPiso' => array('foreignKey' => 'piso'),
      'EstadoConservacion' => array('foreignKey' => 'estado_conservacion_id'),
      'TipoCalefaccion' => array('foreignKey' => 'tipo_calefaccion_id'),
      'TipoAguaCaliente' => array('foreignKey' => 'tipo_agua_caliente_id'),
      'TipoAA' => array('foreignKey' => 'tipo_aa_id'),
      'InteriorExterior' => array('foreignKey' => 'interior_exterior_id'),
      'TipoOrientacion' => array('foreignKey' => 'tipo_orientacion_id'),
      'TipoCableado' => array('foreignKey' => 'tipo_cableado_id'),
      'CalificacionEnergetica' => array('foreignKey' => 'calificacion_energetica_id'));
  public $hasAndBelongsToMany = array(
      'TipoPuerta' => array(
          'className' => 'TipoPuerta',
          'joinTable' => 'oficinas_tipo_puerta',
          'foreignKey' => 'oficina_id',
          'associationForeignKey' => 'tipo_puerta_id',
          'unique' => 'keepExisting',
      ),
      'TipoVentana' => array(
          'className' => 'TipoVentana',
          'joinTable' => 'oficinas_tipo_ventana',
          'foreignKey' => 'oficina_id',
          'associationForeignKey' => 'tipo_ventana_id',
          'unique' => 'keepExisting',
      ),
      'TipoSuelo' => array(
          'className' => 'TipoSuelo',
          'joinTable' => 'oficinas_tipo_suelo',
          'foreignKey' => 'oficina_id',
          'associationForeignKey' => 'tipo_suelo_id',
          'unique' => 'keepExisting',
      )
  );

}
