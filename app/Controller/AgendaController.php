<?php

/**
 * Description of AgendaController
 *
 * @author dmonje
 */
class AgendaController extends AppController {

	public $helpers = array(
			'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
			'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
			'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
			'Number', 'App', 'Inmuebles');

	public $components = array('InmueblesInfo', 'AgendaInfo', 'Paginator');
	public $uses = array('Inmueble','Evento',	'Pais',	'Contacto',	'HorarioContacto',
		'TipoImagen', 'TipoEvento', 'MedioPublicidad', 'Demandante', 'Propietario', 'User');

	public $paginate = array(
			'recursive' => 2,
			'order' => 'fecha DESC',
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
					'TipoEvento.*'),
			'order' => array('Evento.id' => 'desc')
	);

	private static $estados = array(
		'0' => 'por realizar',
		'1' => 'realizada',
		'2' => 'anulada');

	/**
	 * @return mixed
	 */
	private function getAccionesLst() {
		$acciones_lst = $this->TipoEvento->find('all',
			array('callbacks' => false,	'conditions' => array('type' => 1), 'order' => array('TipoEvento.orden')));

		$acciones = array();
		foreach ($acciones_lst as $accion) {
			$acciones[] = array(
				'name'  => $accion['TipoEvento']['description'],
				'value' => $accion['TipoEvento']['id'],
				'data-type1' => $accion['TipoEvento']['type'],
				'data-type2' => $accion['TipoEvento']['info_type']);
		}

		return $acciones;
	}

	/**
	 * @return mixed
	 */
	private function getTareasLst() {
		$tareas_lst = $this->TipoEvento->find('all',
			array('callbacks' => false,	'conditions' => array('type' => 2), 'order' => array('TipoEvento.orden')));

		$tareas = array();
		foreach ($tareas_lst as $tarea) {
			$tareas[] = array(
				'name'  => $tarea['TipoEvento']['description'],
				'value' => $tarea['TipoEvento']['id'],
				'data-type1' => $tarea['TipoEvento']['type'],
				'data-type2' => $tarea['TipoEvento']['info_type']);
		}

		return $tareas;
	}

	/**
	 * @return array
	 */
	private function getMediosLst() {
		$medios_lst = $this->MedioPublicidad->find('all',	array('callbacks' => false,	'order' => array('MedioPublicidad.id')));

		$medios = array();
		foreach ($medios_lst as $medio) {
			$medios[] = $medio['MedioPublicidad']['description'];
		}
		return $medios;
	}

	/**
	 * @param $user
	 *
	 * @return string
	 */
	private function getDatosUsuario($user) {
		if (!is_array($user)) {
			if (!empty($user)) {
				$user = $this->User->findById($user);
			} else {
				$user = null;
			}
		}

		if ($user != null) {
			if ($user['Agente']['id'] != null) {
				$result = 'Agente: ' . $user['Agente']['nombre_contacto'] . '.';
			} else {
				$result = 'Oficina: ' . $user['Agencia']['nombre_agencia'] . '.';
			}
		} else {
			$result = '';
		}

		return $result;
	}

	/**
	 *
	 */
	function index() {

		$this->set('agentes', array('' => '-- todos los agentes comerciales --') + $this->getAllAgentesAgencia());

		if ($this->request->is('post')) {
			$info = $this->request->data;

			if ($info['delete'] == '1') {
				$this->Evento->delete($info['Evento']['id']);
				$this->setSuccessFlash("Evento eliminado.");
			} else {
				$this->Evento->save($info);
				$this->setSuccessFlash("La información se ha guardado correctamente.");
			}
		}
	}

	/**
	 *
	 */
	function listado() {

		if ($this->request->is('post')) {
			$this->passedArgs = $this->request->data;
		} elseif (!empty($this->passedArgs)) {
			$this->request->data = $this->passedArgs;
		}
		$agencia = $this->viewVars['agencia']['Agencia'];

		if (!empty($this->passedArgs['sortBy'])) {
			$sortBy = explode(' ', $this->passedArgs['sortBy']);
			if (!isset($sortBy[1])) {
				$sortBy[1] = 'asc';
			}
			$this->paginate['order'] = array('Agente.' . $sortBy[0] => $sortBy[1]);
		} else {
			$this->paginate['order'] = array('Evento.fecha' => 'desc');
		}

		$search = $this->AgendaInfo->crearBusqueda($this->request->data, 'Evento');
		$search['Evento.agencia_id'] = $agencia['id'];

		$this->Paginator->settings = $this->paginate;
		$this->set('info', $this->Paginator->paginate('Evento', $search));

		$this->set('tiposEvento', array('' => '-- todas las acciones --') + array('Acciones con clientes' => $this->getAccionesLst(), 'Tareas' => $this->getTareasLst()));
		$this->set('agentes', array('' => '-- cualquier agente --') + $this->getAllAgentesAgencia());
		$this->set('estados', self::$estados);
	}

	public function getEventosInmueble() {
		$this->set('infoaux', array('33' => $this->getTiposEstado(), '38' => $this->getTiposContrato()));
		$this->set('eventos', $this->getEventos(array('Evento.inmueble_id' => $this->request->data['inmueble_id']), true));
	}

	public function getEventosDemandante() {
		$this->set('eventos', $this->getEventos(array('Evento.demandante_id' => $this->request->data['demandante_id'])));
	}

	public function getEventosPropietario() {
		$this->set('eventos', $this->getEventos(array('Evento.propietario_id' => $this->request->data['propietario_id'])));
	}

	/**
	 *
	 */
	public function add() {

		if (isset($this->passedArgs[0])) {
			switch ($this->passedArgs[0]) {
				case 'inmueble_id':
					$this->set('inmueble_id', $this->passedArgs[1]);
					$info = $this->Inmueble->find('first', array(
						'conditions' => array('Inmueble.id' => $this->passedArgs[1]), 'recursive' => 0,
						'fields' => array('Inmueble.numero_agencia', 'Inmueble.codigo')));
					$this->set('info', $info);
					break;
				case 'propietario_id':
					$this->set('propietario_id', $this->passedArgs[1]);
					$info = $this->Propietario->find('first', array(
						'conditions' => array('Propietario.id' => $this->passedArgs[1]), 'recursive' => 0,
						'fields' => array('Propietario.nombre_contacto')));
					$this->set('info', $info);
					break;
				case 'demandante_id':
					$this->set('demandante_id', $this->passedArgs[1]);
					$info = $this->Demandante->find('first', array(
						'conditions' => array('Demandante.id' => $this->passedArgs[1]), 'recursive' => 0,
						'fields' => array('Demandante.nombre_contacto')));
					$this->set('info', $info);
					break;
			}
		}

		$user = $this->viewVars['user'];
		$this->set('user_id', $user['id']);
		$this->set('user_name', $this->getDatosUsuario($user));

		$this->set('tipos_evento', array('Acciones con clientes' => $this->getAccionesLst(), 'Tareas' => $this->getTareasLst()));
		$this->set('medios', $this->getMediosLst());
		$this->set('estados', self::$estados);
		$this->set('agentes', $this->getAllAgentesAgencia());

		$this->view = '/Agenda/edit';
	}

	/**
	 * @param null $id
	 */
	public function edit($id = null) {

		if ($id != null) {
			$agencia_id = $this->viewVars['agencia']['Agencia']['id'];

			$info = $this->Evento->find('first', array('conditions' => array('Evento.id' => $id, 'Evento.agencia_id' => $agencia_id), 'recursive' => 2));
			$this->request->data = $info;
			$this->set('info', $info);

			if ($info['Evento']['user_id'] == null) {
				$user = $this->viewVars['user'];
				$this->set('user_id', $user['id']);
				$info['Evento']['user_id'] = $user['id'];
			}

			$this->set('user_name', $this->getDatosUsuario($info['Evento']['user_id']));
		}

		$this->set('tipos_evento', array('Acciones con clientes' => $this->getAccionesLst(), 'Tareas' => $this->getTareasLst()));
		$this->set('medios', $this->getMediosLst());
		$this->set('estados', self::$estados);
		$this->set('agentes', $this->getAllAgentesAgencia());
	}

}
