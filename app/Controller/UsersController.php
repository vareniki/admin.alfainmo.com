<?php

// app/Controller/UsersController.php
class UsersController extends AppController {

	public $uses = array('Agencia', 'Agente', 'MonedaPais');

	protected function loadInitData($user) {

		// Comprueba si hay un agente, el cual estará asociado a una agencia
		if (!is_null($user['agente_id'])) {
			$this->Agente->id = $user['agente_id'];
			$agente = $this->Agente->read();

			if (isset($agente['Agente'])) {
				$user['agencia_id'] =  $agente['Agente']['agencia_id'];
			}
		}

		// Carga la agencia
		if (!is_null($user['agencia_id'])) {

			$agencia_id = $user['agencia_id'];

      $agencia = $this->Agencia->find('first', array(
          'fields' => array('Agencia.*', 'Pais.*', 'User.*'),
          'conditions' => array('Agencia.id' => $agencia_id, 'Agencia.active' => 't'), 'recursive' => 0));

      if (!is_null($agencia['Pais']['id'])) {
        $pais_id = $agencia['Pais']['id'];
        $tiposMoneda = $this->MonedaPais->find('first', array(
            'fields' => array('TipoMoneda.*'),
            'conditions' => array('MonedaPais.pais_id' => $pais_id),
            'order' => 'MonedaPais.orden',
            'recursive' => 0));
        $agencia['Pais']['TipoMoneda'] = $tiposMoneda;
      }

			if (!is_null($user['agente_id'])) {
				$this->Agencia->hasMany['Agente']['conditions'] = array('Agente.id' => $user['agente_id']);
			}

		} else {
			throw new Exception("No se ha podido cargar la agencia.");
		}

		$this->Session->write('agencia', $agencia);
		if (isset($agente)) {
			$this->Session->write('agente', $agente);
		}

		$agentes = $this->Agente->find('all', array(
		    'fields' => array('Agente.*', 'Agencia.*', 'User.*'),
		    'conditions' => array('Agencia.id' => $agencia_id, 'User.active' => 't'),
        'recursive' => 0,
        'order' => array('Agente.nombre_contacto')));
		$this->Session->write('agentes', $agentes);
		$this->Session->write('user', $user);
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->authenticate = array('Form' => array('scope' => array('User.active' => 't')));
	}

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'), 'default', array('class' => 'alert alert-danger'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'default', array('class' => 'alert alert-danger'));
				$this->redirect(array('url' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'), 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('url' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'), 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('url' => 'index'));
	}

	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'default', array('class' => 'alert alert-danger'));
				$this->redirect(array('url' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data['User']['password']);
		}
	}

	public function login() {
		$this->layout = null;
		if ($this->request->is('post')) {

			if ($this->Auth->login()) {
				try {
					$this->loadInitData($this->Auth->user());
					$this->redirect('/');
				} catch (Exception $e) {
					$this->Session->setFlash(__('Usuario o contrase&ntilde;a no v&aacute;lidos, int&eacute;ntelo de nuevo'), 'default', array('class' => 'alert alert-danger'));
				}

			} else {
				$this->Session->setFlash(__('Usuario o contrase&ntilde;a no v&aacute;lidos, int&eacute;ntelo de nuevo'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

}
