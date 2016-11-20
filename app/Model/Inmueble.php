<?php

// app/Model/Inmueble.php

class Inmueble extends AppModel {

	public $name = 'Inmueble';
	public $useTable = 'inmuebles';
	public $belongsTo = array(
			'TipoInmueble' => array('foreignKey' => 'tipo_inmueble_id'),
			'Agencia' => array('foreignKey' => 'agencia_id'),
			'Agente' => array('foreignKey' => 'agente_id'),
			'Pais' => array('foreignKey' => 'pais_id'),
			'TipoContrato' => array('foreignKey' => 'tipo_contrato_id'),
			'MedioCaptacion' => array('foreignKey' => 'medio_captacion_id'),
			'MotivoBaja' => array('foreignKey' => 'motivo_baja_id'),
			'EstadoInmueble' => array('foreignKey' => 'estado_inmueble_id'),
			'TipoMoneda' => array('foreignKey' => 'moneda_id')
	);
	public $hasOne = array('Piso', 'Chalet', 'Garaje', 'Oficina', 'Local', 'Terreno', 'Nave', 'Otro', 'Contacto', 'Propietario');
	public $hasMany = array(
		'Imagen'    => array('className' => 'Imagen',    'order' => 'Imagen.orden ASC'),
		'Documento' => array('className' => 'Documento', 'order' => 'Documento.descripcion'));

  public $virtualFields = array(
    'referencia' => 'Inmueble.numero_agencia || \'/\' || Inmueble.codigo'
  );

	public $actsAs = array(
			'FilterHabtm.FilterHabtm',
			'Containable' // If you use containable it's very important to load it AFTER FilterHabtm
	);

	public $hasAndBelongsToMany = array(
		'Portal' => array(
			'className' => 'Portal',
			'joinTable' => 'inmuebles_portal',
			'foreignKey' => 'inmueble_id',
			'associationForeignKey' => 'portal_id',
			'unique' => 'keepExisting',
		),
		'NoPortal' => array(
				'className' => 'Portal',
				'joinTable' => 'inmuebles_portal_no',
				'foreignKey' => 'inmueble_id',
				'associationForeignKey' => 'portal_id',
				'unique' => 'keepExisting',
		),
		'CentralPortal' => array(
				'className' => 'Portal',
				'joinTable' => 'inmuebles_portal_central',
				'foreignKey' => 'inmueble_id',
				'associationForeignKey' => 'portal_id',
				'unique' => 'keepExisting',
		)
	);

  /**
   * @param array $options
   * @return bool|void
   */
  public function beforeSave($options = array()) {

	  $info = & $this->data[$this->alias];

		if (!isset($info['id'])) {

			$new_info = $this->find('first', array(
				'fields' => 'Inmueble.codigo',
				'conditions' => array('Inmueble.numero_agencia' => $info['numero_agencia']),
				'order'=>'Inmueble.codigo DESC',
				'callbacks' => false,
				'recursive' => 0));

			$new_id = (int) $new_info['Inmueble']['codigo'] + 1;

			$info['codigo'] = $new_id;
			if (isset($info['precio_venta'])) {
				$info['precio_venta_ini'] = $info['precio_venta'];
			}
			if (isset($info['precio_alquiler'])) {
				$info['precio_alquiler_ini'] = $info['precio_alquiler'];
			}
			if (isset($info['precio_traspaso'])) {
				$info['precio_traspaso_ini'] = $info['precio_traspaso'];
			}
		}
    $estado = (!isset($info['estado_inmueble_id'])) ? '01' : $info['estado_inmueble_id'];

	  if (empty($info['es_venta']) && empty($info['es_opcion_compra'])) {
		  $info['precio_venta'] = null;
	  }
	  if (empty($info['es_alquiler']) && empty($info['es_opcion_compra'])) {
		  $info['precio_alquiler'] = null;
	  }
	  if (empty($info['es_traspaso'])) {
		  $info['precio_traspaso'] = null;
	  }

		// Si el inmueble ha sido captado pero no tiene fecha entonces hay que asignarla la actual, y al contrario
    switch ($estado) {
      case '01':
        $info['fecha_captacion'] = null;
        break;
      case '02':
        if ($info['fecha_captacion'] == null) {
          $info['fecha_captacion'] = date('Y-m-d H:i');
        }
        break;
      case '05':
        if ($info['fecha_baja'] == null) {
          $info['fecha_baja'] = date('Y-m-d H:i');
        }
        break;
    }

    if ($estado != '05') {
      $info['motivo_baja_id'] = null;
      $info['fecha_baja'] = null;
    }

	}

}
