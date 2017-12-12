<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helpers = array(
			'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
			'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
			'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
			'Js', 'Number', 'App');

	public $components = array('Session', 'Auth', 'Alfa');
	public $uses = array('TipoMoneda');

  private $flashed = array();

	/**
	 * 
	 */
	function beforeFilter() {

		Configure::load('alfainmo');
		$this->set('config', Configure::read('alfainmo'));

		$user = $this->Session->read('user');
		if (!is_null($user['agencia_id']) ) {
			$this->set('agencia', $this->Session->read('agencia'));
		} else {
			$this->set('agencia', array());
		}
		if (!is_null($user['agente_id'])) {
			$this->set('agente', $this->Session->read('agente'));
		} else {
			$this->set('agente', array());
		}
		$this->set('user', $user);

		$monedas = array();

		// Para una agencia normal carga los tipos de moneda
		$agencia = $this->Session->read('agencia');
		if (!empty($agencia)) {
			if (isset($agencia['Pais']['TipoMoneda'])) {
				foreach ($agencia['Pais']['TipoMoneda'] as $moneda) {
          if (isset($moneda['id'])) {
            $id = $moneda['id'];
            $symbol = $moneda['symbol'];
          } else {
            $id = $moneda['TipoMoneda']['id'];
            $symbol = $moneda['TipoMoneda']['symbol'];
          }

					$monedas[$id] = $symbol;
				}
			}
		}

		if ($this->isCentral()) {

			// Carga todas las monedas
			$all_monedas = $this->TipoMoneda->find('all', array('order' => 'id', 'callbacks' => false));
			foreach ($all_monedas as $moneda) {
				$id = $moneda['TipoMoneda']['id'];

				if (!isset($monedas[$id])) {
					$symbol = $moneda['TipoMoneda']['symbol'];
					$monedas[$id] = $symbol;
				}

			}

		}

		$this->set('agentes', $this->Session->read('agentes'));

		$this->set('monedas', $monedas);
		$this->set('profile', array(
				'is_central' => $this->isCentral(),
				'is_agencia' => $this->isAgencia(),
				'is_agente' => $this->isAgente(),
				'is_coordinador' => $this->isCoordinador(),
				'is_consultor' => $this->isConsultor(),
				'is_editor' => $this->isEditor()));
	}

	/*
	 * 
	 */
	public function afterFilter() {
		parent::afterFilter();

		if (empty($this->request->query['callback']) || $this->response->type() != 'application/json') {
			return;
		}
		$callbackFnc = strip_tags($this->request->query['callback']);
		$out = sprintf("%s(%s)", $callbackFnc, $this->response->body());
		$this->response->body($out);
	}

	/**
	 * @return array
	 */
	protected function getAllAgentesAgencia() {
		$agentes = $this->viewVars['agentes'];

		$result = array();
		foreach ($agentes as $agente) {
		  if ($agente['User']['active'] != 't') {
		    continue;
      }
			$result[$agente['Agente']['id']] = $agente['Agente']['nombre_contacto'];
		}

		return $result;
	}

	/**
	 * 
	 * @param type $msg
	 */
	protected function setSuccessFlash($msg) {
    if (in_array('info', $this->flashed) || in_array('warning', $this->flashed) || in_array('danger', $this->flashed)) {
      return;
    }
    $this->flashed[] = 'success';
		$this->Session->setFlash($msg, 'default', array('class' => 'alert alert-success text-center'));
	}

	/**
	 * 
	 * @param type $msg
	 */
	protected function setInfoFlash($msg) {
    if (in_array('warning', $this->flashed) || in_array('danger', $this->flashed)) {
      return;
    }
    $this->flashed[] = 'info';
		$this->Session->setFlash($msg, 'default', array('class' => 'alert alert-info text-center'));
	}

	/**
	 * 
	 * @param type $msg
	 */
	protected function setWarningFlash($msg) {
    if (in_array('danger', $this->flashed)) {
      return;
    }
		$this->Session->setFlash($msg, 'default', array('class' => 'alert alert-warning text-center'));
	}

	/**
	 * 
	 * @param type $msg
	 */
	protected function setDangerFlash($msg) {
    $this->flashed[] = 'danger';
		$this->Session->setFlash($msg, 'default', array('class' => 'alert alert-danger text-center'));
	}

	protected function isCentral() {
		$user = $this->Session->read('user');
		return ($user['agencia_id'] == 1);
	}

	protected function isAgencia() {
		$user = $this->Session->read('user');
		return (is_null($user['agente_id']));
	}

	protected function isAgente() {
		$user = $this->Session->read('user');
		return !is_null($user['agente_id']);
	}

	protected function isConsultor() {
		$user = $this->Session->read('user');
		return !is_null($user['agente_id'])	&& $user['Agente']['tipo'] == 'c';
	}

	protected function isCoordinador() {
		$user = $this->Session->read('user');
		return !is_null($user['agente_id'])	&& $user['Agente']['tipo'] == 'o';
	}

	protected function isEditor() {
		$user = $this->Session->read('user');
		return !is_null($user['agente_id'])	&& $user['Agente']['tipo'] == 'e';
	}

}
