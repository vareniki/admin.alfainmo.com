<?php

class AjaxController extends AppController {

  public $helpers = array(
    'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
    'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
    'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
    'Number',
	  'Text',
	  'App',
	  'Inmuebles');

  public $uses = array('Propietario', 'Demandante', 'Inmueble', 'Evento', 'Zona', 'TipoChalet', 'TipoGaraje',
	  'TipoOficina', 'TipoPiso', 'TipoTerreno', 'Poblacion', 'Provincia', 'TipoContrato', 'EstadoInmueble');

	/**
	 * @return mixed
	 */
	private function getTiposContrato() {
		$CI = $this;
		return $this->Alfa->getTypologyInfo('TipoContrato', function() use ($CI) {
			return $CI->TipoContrato->find('all', array('order' => 'id', 'callbacks' => false));
		});
	}

	/**
	 * @return mixed
	 */
	private function getTiposEstado() {
		$CI = $this;
		return $this->Alfa->getTypologyInfo('EstadoInmueble', function() use ($CI) {
			return $CI->EstadoInmueble->find('all', array('order' => 'id', 'callbacks' => false));
		});
	}

	/**
	 * @param $conditions
	 * @return mixed
	 */
	private function getEventos($conditions, $cambios=false) {

	  if ( !$this->isCentral() ) {
      $conditions['Evento.agencia_id'] = $this->viewVars['agencia']['Agencia']['id'];
    }

		if (!$cambios) {
			$conditions[] = 'TipoEvento.type IN (1,2)';
		} else {
			$conditions[] = 'TipoEvento.type IN (1,2,3)';
		}

		$eventos = $this->Evento->find('all', array(
			'recursive' => 1,
			'order' => 'fecha DESC',
			'conditions' => $conditions,
			'fields' => array('Evento.*',
				'Agencia.id',
				'Agencia.numero_agencia',
				'Agencia.nombre_agencia',
				'Propietario.id',
				'Propietario.nombre_contacto',
				'Propietario.telefono1_contacto',
				'Propietario.telefono2_contacto',
				'Propietario.email_contacto',
				'Demandante.id',
				'Demandante.nombre_contacto',
				'Demandante.telefono1_contacto',
				'Demandante.telefono2_contacto',
				'Demandante.email_contacto',
				'Agente.id',
				'Agente.nombre_contacto',
				'Inmueble.id',
				'Inmueble.numero_agencia',
				'Inmueble.codigo',
				'TipoEvento.*')
		));
		return $eventos;
	}

	/**
	 * @param null $request
	 * @param null $response
	 */
	public function __construct($request = null, $response = null) {
    parent::__construct($request, $response);
    $this->layout = 'ajax';
  }

	/**
	 *
	 */
	public function buscarRefCatastral() {
		if (!$this->request->is('ajax')) {
			return;
		}
	}

	/**
	 *
	 * @return type
	 */
	public function getDemandantesOficina() {

		if (!$this->request->is('ajax')) {
			return;
		}

		$params = $this->request->query;
		$q = str_replace("'", "''", strtolower(trim($params['q'])));
		$altas = !(isset($params['bajas']));
		$agencia_id = $this->viewVars['agencia']['Agencia']['id'];

		$subcond = array('OR' => array(
				'Demandante.nombre_contacto ILIKE' => "%$q%",
				'Demandante.telefono1_contacto ILIKE' => "%$q%",
				'Demandante.telefono2_contacto ILIKE' => "%$q%"));

		$conditions = array($subcond, 'Demandante.agencia_id' => $agencia_id);
		if ($altas) {
			$conditions[] = 'Demandante.fecha_baja IS NULL';
		}

		$items = $this->Demandante->find('all', array(
			'callbacks' => false,
			'order' => 'Demandante.nombre_contacto',
			'limit' => 10,
			'fields' => array(
				'Demandante.id',
				'Demandante.numero_agencia',
				'Demandante.codigo',
				'Demandante.nombre_contacto',
				'Demandante.pais_id',
				'Demandante.codigo_postal',
				'Demandante.poblacion',
				'Demandante.provincia',
				'Demandante.direccion',
				'Demandante.email_contacto',
				'Demandante.telefono1_contacto',
				'Demandante.telefono2_contacto',
				'Demandante.dni',
				'Demandante.horario_contacto_id',
				'Demandante.fecha_baja'),
			'conditions' => $conditions));

		$this->set('items', $items);
	}

	/**
	 *
	 */
	public function getInmueblesAlta() {
		if (!$this->request->is('ajax')) {
			return;
		}

		$params = $this->request->query;
		$q = strtolower($params['q']);
		$altas = !(isset($params['bajas']));
		//$agencia_id = $this->viewVars['agencia']['Agencia']['id'];

		if (strpos($q, '/') !== false) {

			$ref = explode('/', $q);
			$conditions = array('Inmueble.numero_agencia' =>  (int) $ref[0], 'Inmueble.codigo' => (int) $ref[1]);

		} else {

			$conditions = array('OR' => array(
					'Inmueble.poblacion ILIKE ' => "%$q%",
					'Inmueble.provincia ILIKE ' => "%$q%",
					'Inmueble.nombre_calle ILIKE ' => "%$q%"));
		}

		//$conditions['Inmueble.agencia_id'] = $agencia_id;
		if ($altas) {
			$conditions[] = 'Inmueble.fecha_baja IS NULL';
		}

		$items = $this->Inmueble->find('all', array(
			'callbacks' => false,
			'order' => array('Inmueble.numero_agencia', 'Inmueble.codigo'),
			'limit' => 250,
			'fields' => array(
				'Inmueble.id',
				'Inmueble.numero_agencia',
				'Inmueble.codigo',
				'Inmueble.created',
				'Inmueble.fecha_baja',
				'TipoInmueble.id',
				'TipoInmueble.description',
				'Inmueble.es_venta',
				'Inmueble.es_alquiler',
				'Inmueble.es_traspaso',
				'Inmueble.es_opcion_compra',
				'Inmueble.precio_venta',
				'Inmueble.precio_alquiler',
				'Inmueble.precio_traspaso',
				'Inmueble.poblacion',
				'Inmueble.provincia',
				'Inmueble.nombre_calle',
				'Agencia.nombre_agencia',
				'Agencia.numero_agencia'),
			'conditions' => $conditions
		));

		$this->set('items', $items);
	}

	/**
	 *
	 * @return type
	 */
	public function getPropietariosOficina() {

		if (!$this->request->is('ajax')) {
			return;
		}

		$params = $this->request->query;

		$q = str_replace("'", "''", strtolower($params['q']));
		$altas = !(isset($params['bajas']));
		$agencia_id = $this->viewVars['agencia']['Agencia']['id'];


		$subcond = array('OR' => array(
				'Propietario.nombre_contacto ILIKE' => "%$q%",
				'Propietario.telefono1_contacto ILIKE' => "%$q%",
				'Propietario.telefono2_contacto ILIKE' => "%$q%"));

		$conditions = array($subcond, 'Inmueble.agencia_id' => $agencia_id);
		if ($altas) {
			$conditions[] = 'Inmueble.fecha_baja IS NULL';
		}

		$items = $this->Inmueble->find('all', array(
			'callbacks' => false,
			'order' => 'Propietario.nombre_contacto',
			'limit' => 10,
			'fields' => array(
				'Propietario.id',
				'Inmueble.id',
				'Inmueble.numero_agencia',
				'Inmueble.codigo',
				'Inmueble.fecha_baja',
				'Propietario.nombre_contacto',
				'Propietario.dni',
				'Propietario.pais_id',
				'Propietario.codigo_postal',
				'Propietario.poblacion',
				'Propietario.provincia',
				'Propietario.direccion',
				'Propietario.email_contacto',
				'Propietario.telefono1_contacto',
				'Propietario.telefono2_contacto',
				'Propietario.observaciones',
				'Contacto.nombre_contacto',
				'Contacto.email_contacto',
				'Contacto.telefono1_contacto',
				'Contacto.telefono2_contacto',
				'Contacto.horario_contacto_id',
				'Contacto.observaciones'
			),
			'recursive' => 1,
			'conditions' => $conditions));

		$this->set('items', $items);
	}

	/**
	 * @param $tipo_inmueble_id
	 */
	public function getSubtiposInmueble($tipo_inmueble_id=null) {

		$this->layout = null;
		$this->autoRender = false;

		if (!$this->request->is('ajax')) {
			return;
		}

		if ($tipo_inmueble_id != null) {
			switch ($tipo_inmueble_id) {
				case '01': // Piso
					$class = 'TipoPiso';
					$info_array = $this->TipoPiso->find('all', array('callbacks' => false, 'order' => 'id'));
					break;
				case '02': // Chalet/casa
					$class = 'TipoChalet';
					$info_array = $this->TipoChalet->find('all', array('callbacks' => false, 'order' => 'id'));
					break;
				case '04': // Oficina
					$class = 'TipoOficina';
					$info_array = $this->TipoOficina->find('all', array('callbacks' => false, 'order' => 'id'));
					break;
				case '05': // Garaje
					$class = 'TipoGaraje';
					$info_array = $this->TipoGaraje->find('all', array('callbacks' => false, 'order' => 'id'));
					break;
				case '06': // Terreno
					$class = 'TipoTerreno';
					$info_array = $this->TipoTerreno->find('all', array('callbacks' => false, 'order' => 'id'));
					break;
				default:
					$result = array();
					break;
			}
		}

		if (isset($class)) {
			foreach ($info_array as $info) {
				$result[] = $info[$class];
			}
		} else {
			$result = '';
		}

		echo json_encode($result);
	}

	/**
	 * @param $provincia_id
	 */
	public function getPoblacionesProvincia($provincia_id) {
		$this->layout = null;
		$this->autoRender = false;

		if (!$this->request->is('ajax')) {
			return;
		}

		$pob_array = $this->Poblacion->find('all', array(
			'order' => 'Poblacion.description ASC',	'conditions' => array('provincia_id' => $provincia_id)
		));

		$result = array();

		foreach ($pob_array as $poblac) {
			$result[] = array('id' => $poblac['Poblacion']['id'], 'description' => $poblac['Poblacion']['description']);
		}

		echo json_encode($result);
	}

	/**
	 * @return string
	 */
	public function changeEventDate() {

		$this->layout = null;
		$this->autoRender = false;

		if (!$this->request->is('ajax')) {
			return;
		}

		$eventId = $this->request->query['eventId'];
		$dateTime = $this->request->query['dateTime'];
		if (empty($eventId) || empty($dateTime)) {
			return;
		}

		$this->Evento->save(array('id' => $eventId, 'fecha' => $dateTime));
	}

	/* Eventos */

	/**
	 *
	 */
	public function getEventosAgenda() {

		$this->layout = null;
		$this->autoRender = false;

		if (!$this->request->is('ajax')) {
			return;
		}
    $agencia_id = $this->viewVars['agencia']['Agencia']['id'];

		$conditions = array(
			'Evento.fecha >= ' => date('Y-m-d', $this->request->query['start']),
			'Evento.fecha <= ' => date('Y-m-d', $this->request->query['end']),
      'Evento.agencia_id' => $agencia_id
		);
/*
		if ($this->isAgente()) {
			$conditions['Evento.agente_id'] = $this->viewVars['agente']['Agente']['id'];
		}
*/

		$eventos = $this->getEventos($conditions);

		echo json_encode($eventos);
	}

	/**
	 *
	 */
	public function getEventosInmueble() {

		if (!$this->request->is('ajax')) {
			return;
		}
		$inmueble_id = $this->request->data['inmueble_id'];

		$conditions = array(
			'Evento.inmueble_id' => $inmueble_id,
		);

		$this->set('infoaux', array(
			'33' => $this->getTiposEstado(),
			'38' => $this->getTiposContrato()
		));

		$this->set('eventos', $this->getEventos($conditions, true));
	}

	/**
	 *
	 */
	public function getEventosDemandante() {
		if (!$this->request->is('ajax')) {
			return;
		}

		$conditions = array(
			'Evento.demandante_id' => $this->request->data['demandante_id']
		);

		$this->set('eventos', $this->getEventos($conditions));
	}

	/**
	 *
	 */
	public function getEventosPropietario() {
		if (!$this->request->is('ajax')) {
			return;
		}

		$conditions = array(
			'Evento.propietario_id' => $this->request->data['propietario_id']
		);

		$this->set('eventos', $this->getEventos($conditions));
	}

	/**
	 *
	 */
	public function getEventosAgente() {
		if (!$this->request->is('ajax')) {
			return;
		}

		$conditions = array(
			'Evento.agente_id' => $this->request->data['agente_id']
		);

		$this->set('eventos', $this->getEventos($conditions));
	}

	/*
	 * Demandantes por inmueble
	 */

	public function getDemandasInmueble() {
		if (!$this->request->is('ajax')) {
			return;
		}

		$inmueble = $this->Inmueble->find('first', array(
			'conditions' => array('Inmueble.id' => $this->request->data['inmueble_id']), 'recursive' => 1));

		if (empty($inmueble['Inmueble']['coord_x']) || empty($inmueble['Inmueble']['coord_y'])) {
			$this->set('info', array());
			return;
		}

		$busq = array();
		switch ($inmueble['Inmueble']['tipo_inmueble_id']) {
			case '01': // piso
				$subtipo = 'Piso';
				$busq['subtipo'] = $inmueble['Piso']['tipo_piso_id'];
				break;
			case '02': // chalet
				$subtipo = 'Chalet';
				$busq['subtipo'] = $inmueble['Chalet']['tipo_chalet_id'];
				break;
			case '03': // local
				$subtipo = 'Local';
				$busq['subtipo'] = null;
				break;
			case '04': // oficina
				$subtipo = 'Oficina';
				$busq['subtipo'] = $inmueble['Oficina']['tipo_oficina_id'];
				break;
			case '05': // garaje
				$subtipo = 'Garaje';
				$busq['subtipo'] = $inmueble['Garaje']['tipo_garaje_id'];
				break;
			case '06': // terreno
				$subtipo = 'Terreno';
				$busq['subtipo'] = $inmueble['Terreno']['tipo_terreno_id'];
				break;
			case '07': // nave
				$subtipo = 'Nave';
				$busq['subtipo'] = null;
				break;
			case '08': // otro
				$subtipo = 'Otro';
				$busq['subtipo'] = null;
				break;

		}
		$busq['tipo_equipamiento'] = (isset($inmueble[$subtipo]['tipo_equipamiento_id'])) ? $inmueble[$subtipo]['tipo_equipamiento_id'] : null;
		$busq['tipo_calefaccion'] = (isset($inmueble[$subtipo]['tipo_calefaccion_id'])) ? $inmueble[$subtipo]['tipo_calefaccion_id'] : null;
		$busq['estado_conservacion'] = (isset($inmueble[$subtipo]['estado_conservacion_id'])) ? $inmueble[$subtipo]['estado_conservacion_id'] : null;
		$busq['habitaciones'] = (isset($inmueble[$subtipo]['numero_habitaciones'])) ? $inmueble[$subtipo]['numero_habitaciones'] : null;
		$busq['banos'] = (isset($inmueble[$subtipo]['numero_banos'])) ? $inmueble[$subtipo]['numero_banos'] : null;

		$busq['con_piscina'] = (isset($inmueble[$subtipo]['con_piscina'])) ? $inmueble[$subtipo]['con_piscina'] : null;
		$busq['con_trastero'] = (isset($inmueble[$subtipo]['con_trastero'])) ? $inmueble[$subtipo]['con_trastero'] : null;

		if (isset($inmueble[$subtipo]['plazas_parking'])) {
			$busq['con_garaje'] = ((int)$inmueble[$subtipo]['plazas_parking'] > 0) ? 't' : 'f';
		} else {
			$busq['con_garaje'] = null;
		}
		if (isset($inmueble[$subtipo]['numero_ascensores'])) {
			$busq['con_ascensor'] = ((int)$inmueble[$subtipo]['numero_ascensores'] > 0) ? 't' : 'f';
		} else {
			$busq['con_ascensor'] = null;
		}
		if (isset($inmueble[$subtipo]['tipo_aa_id'])) {
			$busq['con_aire'] = ($inmueble[$subtipo]['tipo_aa_id'] >= '01') ? 't' : 'f';
		} else {
			$busq['con_aire'] = null;
		}

		$busq['piso'] = (isset($inmueble[$subtipo]['piso'])) ? $inmueble[$subtipo]['piso'] : null;
		$busq['plantas_edificio'] = (isset($inmueble[$subtipo]['plantas_edificio']) && (int) $inmueble[$subtipo]['plantas_edificio'] > 0) ? (int) $inmueble[$subtipo]['plantas_edificio'] : null;

		if ($inmueble['Inmueble']['es_promocion'] == 't') {
			$busq['anios'] = 'on';
		} else {
			$busq['anios'] = (isset($inmueble[$subtipo]['anio_construccion'])) ? ((int) date('Y')) - $inmueble[$subtipo]['anio_construccion'] : null;
		}

		$conditions = array();

		$conditions[] = 'Demandante.fecha_baja IS NULL';
		$conditions['Demanda.tipo'] = $inmueble['Inmueble']['tipo_inmueble_id'];

		if ($inmueble['Inmueble']['es_venta'] == 't') {

			$conditions['Demanda.operacion'] = 'ven';
			$conditions[] = '(Demanda.precio >= ' . $inmueble['Inmueble']['precio_venta'] . ' OR Demanda.precio IS NULL)';
      $conditions[] = '(Demanda.precio_min <= ' . $inmueble['Inmueble']['precio_venta'] . ' OR Demanda.precio_min IS NULL)';

		} else if ($inmueble['Inmueble']['es_alquiler'] == 't') {

			$conditions['Demanda.operacion'] = 'alq';
			$conditions[] = '(Demanda.precio >= ' . $inmueble['Inmueble']['precio_alquiler'] . ' OR Demanda.precio IS NULL)';
      $conditions[] = '(Demanda.precio_min <= ' . $inmueble['Inmueble']['precio_alquiler'] . ' OR Demanda.precio_min IS NULL)';

		} else if ($inmueble['Inmueble']['es_traspaso'] == 't') {

			$conditions['Demanda.operacion'] = 'tra';
			$conditions[] = '(Demanda.precio >= ' . $inmueble['Inmueble']['precio_traspaso'] . ' OR Demanda.precio IS NULL)';
      $conditions[] = '(Demanda.precio_min <= ' . $inmueble['Inmueble']['precio_traspaso'] . ' OR Demanda.precio_min IS NULL)';
		}

		if ($busq['subtipo'] == null) {
			$conditions[] = "(Demanda.subtipo = '" . $busq['subtipo'] . "' OR Demanda.subtipo IS NULL OR Demanda.subtipo = '')";
		}
		if ($busq['tipo_equipamiento'] != null) {
			$conditions[] = "(Demanda.tipo_equipamiento = '" . $busq['tipo_equipamiento'] . "' OR Demanda.tipo_equipamiento IS NULL OR Demanda.tipo_equipamiento = '')";
		}
		if ($busq['tipo_calefaccion'] != null) {
			$conditions[] = "(Demanda.tipo_calefaccion = '" . $busq['tipo_calefaccion'] . "' OR Demanda.tipo_calefaccion IS NULL OR Demanda.tipo_calefaccion = '')";
		}
		if ($busq['estado_conservacion'] != null) {
			$conditions[] = "(Demanda.estado_conservacion = '" . $busq['estado_conservacion'] . "' OR Demanda.estado_conservacion IS NULL OR Demanda.estado_conservacion = '')";
		}
		if ($busq['habitaciones'] != null) {
			$conditions[] = "(Demanda.habitaciones <= " . (int) $busq['habitaciones'] . " OR Demanda.habitaciones IS NULL)";
		}
		if ($busq['banos'] != null) {
			$conditions[] = "(Demanda.banos <= " . (int) $busq['banos'] . " OR Demanda.banos IS NULL)";
		}
		if ($busq['anios'] != null) {
			if ($busq['anios'] == 'on') {
				$conditions[] = "(Demanda.anios = 'on' OR Demanda.anios IS NULL OR Demanda.anios = '')";
			} else {
				$conditions[] = "(Demanda.anios >= '" . $busq['anios']  . "' OR Demanda.anios IS NULL OR Demanda.anios = '')";
			}
		}
		// Comprobar no bajo y no último
		if ($busq['piso'] != null) {
			if ($busq['piso'] == '00') { // Bajo
				$conditions[] = "Demanda.no_bajo <> 't'";
			} else if ($busq['plantas_edificio'] != null && (int) $busq['plantas_edificio'] == (int) $busq['piso']) { // último
				$conditions[] = "Demanda.no_ultimo <> 't'";
			}
		}

		$busq_con = array('con_garaje', 'con_trastero', 'con_ascensor', 'con_piscina', 'con_aire');
		foreach ($busq_con as $con) {
			if ($busq[$con] != null && $busq[$con] == 'f') {
				$conditions[] = "Demanda.$con <> 't'";
			}
		}

		// Agencias activas y no central
		$conditions['Agencia.active'] = 't';

    $subconds = [];
    $subconds['Demandante.agencia_id'] = $this->viewVars['agencia']['Agencia']['id'];
    $subconds[] = "Agencia.solo_central <> 't'";

    $subconds_or[] = array('OR' => $subconds);
    $conditions[] = $subconds_or;
		// Lugar
		$coord_x = $inmueble['Inmueble']['coord_x'];
		$coord_y = $inmueble['Inmueble']['coord_y'];

		$conditions[] = "Demanda.data_polygons <> '' AND strpos(Demanda.data_polygons, E'\n') = 0 AND polygon(Demanda.data_polygons) @> point($coord_x,$coord_y)";

		$info = $this->Demandante->find('all', array(
			'order' => 'Demandante.agencia_id, Demandante.nombre_contacto',	'conditions' => $conditions));

		$this->set('info', $info);
	}

}
