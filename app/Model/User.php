<?php

// app/Model/User.php

App::uses('SecurityComponent', 'Controller/Component');

class User extends AppModel {

	public $name = 'User';
	public $useTable = 'users';
  public $belongsTo = array('Agencia', 'Agente');
	public $validate = array(
			'username' => array(
					'required' => array(
							'rule' => array('notBlank'),
							'message' => 'A username is required'
					)
			),
			'password' => array(
					'required' => array(
							'rule' => array('notBlank'),
							'message' => 'A password is required'
					)
			),
			'role' => array(
					'valid' => array(
							'rule' => array('inList', array('admin', 'author')),
							'message' => 'Please enter a valid role',
							'allowEmpty' => false
					)
			)
	);

  /**
   * @param array $options
   * @return bool
   */
  public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password']);
		}
		return true;
	}

}
