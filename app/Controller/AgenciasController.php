<?php

/**
 * Description of ApuntesController
 *
 * @author dmonje
 */
class AgenciasController extends AppController
{

	public $helpers = array(
		'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
		'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
		'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
		'Number', 'App', 'Text', 'Model');
	public $components = array('AgenciasInfo', 'Paginator');
	public $uses = array('Agencia', 'User', 'Pais', 'Poblacion', 'Portal');
	public $paginate = array(
		'limit' => 10,
		'recursive' => 0,
		'fields' => array('Agencia.*', 'User.active'),
		'order' => array('Agencia.id' => 'asc'));

	/**
	 * @return mixed
	 */
	private function getPaises() {
		$CI = $this;
		return $this->Alfa->getTypologyInfo('Pais', function() use ($CI) {
			return $CI->Pais->find('all', array('order' => 'description', 'callbacks' => false));
		});
	}

	private function getPortales() {
		$CI = $this;
		return $this->Alfa->getTypologyInfo('Portal', function() use ($CI) {
			//$conditions = array('OR' => array('central' => 't', 'excluir' => 't'));
			return $CI->Portal->find('all', array('order' => 'description', 'callbacks' => false, 'conditions' => []));
		}, false);
	}

	/**
	 * @param $provincia_id
	 * @return mixed
	 */
	public function getPoblaciones($provincia_id) {

		$CI = $this;
		return $this->Alfa->getTypologyInfo('Poblacion', function() use ($CI, $provincia_id) {
			return $CI->Poblacion->find('all', array('order' => 'Poblacion.description', 'callbacks' => false, 'conditions' => array('provincia_id' => $provincia_id)));
		}, false);
	}

	/**
	 *
	 */
	public function index()
	{

		if ($this->request->is('post')) {
			$this->passedArgs = $this->request->data;
			$this->Session->write("agenciasSearch", $this->request->data);
		} elseif ($this->Session->check("agenciasSearch")) {
			$this->request->data = $this->Session->read("agenciasSearch");
		}

		if (!empty($this->passedArgs)) {
			$this->request->data = $this->request->data + $this->passedArgs;
		}

		$args = $this->request->data;
		if ($this->isCentral()) {
			$args['solo_central'] = 't';
		}

		$search = $this->AgenciasInfo->crearBusqueda($args);

		if (!empty($args['sortBy'])) {
			$sortBy = explode(' ', $args['sortBy']);
			if (!isset($sortBy[1])) {
				$sortBy[1] = 'asc';
			}
			$this->paginate['order'] = array('Agencia.' . $sortBy[0] => $sortBy[1]);
		}

		$this->Paginator->settings = $this->paginate;

		$info = $this->Paginator->paginate('Agencia', $search);
		$this->set('info', $info);
	}

	/**
	 * @param null $id
	 * @param null $url_64
	 */
	public function view($id = null, $url_64 = null)
	{
		/*
		 * Comprueba si se le pasa un parámetro ($id). En caso de que se le pase dicho parámetro
		 * reinicia y obtiene la última página. Si no, entonces busca los parámetros por "post"
		 */
		if (isset($id)) {
			$this->request->data['referer'] = $url_64;
		}

		$info = $this->Agencia->find('first', array('conditions' => array('Agencia.id' => $id), 'recursive' => 2));
		$this->set('info', $info);
	}

	/**
	 *
	 */
	public function add()	{

		if ($this->request->is('post')) {
			$info = $this->request->data;

			$info['Agencia']['active'] = 't';
			$info['User']['active'] = 't';
			try {
				$this->Agencia->save($info['Agencia']);
				$agencia_id = $this->Agencia->getLastInsertID();

				$info['User']['agencia_id'] = $agencia_id;
				$this->User->save($info['User']);

				$this->setSuccessFlash("El alta de agencia se ha realizado correctamente.");
				$this->request->data = null;

			} catch (Exception $ex) {

				CakeLog::error($ex);
				$str = 'La información no se ha guardado.';
				if ($ex->getCode() == 23505) {
					$str .= ' Es probable el email o el número de agencia se encuentre duplicado.';
				}
				$this->setDangerFlash($str);
			}
		}

		$this->set('paises', $this->getPaises());
		if (isset($info['Agencia']['codigo_postal'])) {
			$this->set('poblaciones_ids', array('' => '(seleccionar población)') +  $this->getPoblaciones(substr($info['Agencia']['codigo_postal'], 0, 2)));
		} else {
			$this->set('poblaciones_ids', array('' => '(seleccionar población)'));
		}
		$this->set('portales', $this->getPortales());

		$this->request->data['Agencia']['pais_id'] = 34; // España
		$this->view = '/Agencias/edit';
	}

	/**
	 * @param null $id
	 * @param null $url_64
	 */
	public function edit($id = null, $url_64 = null) {
		/*
		 * Comprueba si se le pasa un parámetro ($id). En caso de que se le pase dicho parámetro partimos de cero y
		 * obtenemos la última página. Si no, entonces busca los parámetros por "post"
		 */
		if ($this->request->is('post')) {
			$info = $this->request->data;

			$id = $info['Agencia']['id'];
			$url_64 = $info['referer'];

			try {
				$this->Agencia->save($info['Agencia']);

				if (empty($info['User']['password'])) {
					unset($info['User']['password']);
				}

				$info['User']['agencia_id'] = $info['Agencia']['id'];
				$info['User']['active'] = $info['Agencia']['active'];

				$this->User->save($info['User']);

				$this->setSuccessFlash("La información se ha guardado correctamente.");

			} catch (Exception $ex) {

				CakeLog::error($ex);
				$str = 'La información no se ha guardado.';
				if ($ex->getCode() == 23505) {
					$str .= ' Es probable que el email, usuario o número de agencia se encuentren duplicados.';
				}
				$this->setDangerFlash($str);
			}
		}

		$info = $this->Agencia->find('first', array('conditions' => array('Agencia.id' => $id), 'recursive' => 2));

		$this->set('paises', $this->getPaises());
		$this->set('poblaciones_ids', array('' => '(seleccionar población)') + $this->getPoblaciones(substr($info['Agencia']['codigo_postal'], 0, 2)));
		$this->set('portales', $this->getPortales());

		$this->request->data = $info;
		$this->request->data['referer'] = $url_64;

		$this->set('info', $info);
	}

}
