<?php

// app/Model/Demandante.php

class Demandante extends AppModel {

	public $name = 'Demandante';
	public $useTable = 'demandantes';
	public $belongsTo = array(
			'Agencia' => array('foreignKey' => 'agencia_id'),
			'Agente' => array('foreignKey' => 'agente_id'),
			'Pais' => array('foreignKey' => 'pais_id'),
			'HorarioContacto' => array('foreignKey' => 'horario_contacto_id'),
      'ClasificacionDemandante' => array('foreignKey' => 'clasificacion_demandante_id'),
      'Demanda' => array('foreignKey' => 'demanda_id')
	);
	public $hasMany = array(
			'Evento' => array('className' => 'Evento', 'foreignKey' => 'demandante_id', 'order' => 'Evento.fecha DESC'));

  public $virtualFields = array(
    'referencia' => 'Demandante.numero_agencia || \'/\' || Demandante.codigo'
  );

  /**
   * @param array $options
   * @return bool|void
   */
  public function beforeSave($options = array()) {
		if (empty($this->data[$this->alias]['id'])) {

			$info = $this->find('first', array(
				'fields' => 'Demandante.codigo',
				'conditions' => array('Demandante.agencia_id' => $this->data[$this->alias]['agencia_id']),
				'order'=>'Demandante.codigo DESC',
				'callbacks' => false,
				'recursive' => 0));

			if (isset($info['Demandante']['codigo'])) {
				$new_id = ((int) $info['Demandante']['codigo']) + 1;
			} else {
				$new_id = 1;
			}

			$this->data[$this->alias]['codigo'] = $new_id;
		}
	}

}
