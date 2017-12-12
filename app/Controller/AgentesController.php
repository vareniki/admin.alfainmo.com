<?php

/**
 * Description of ApuntesController
 *
 * @author dmonje
 */
class AgentesController extends AppController {

  public $helpers = array(
    'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
    'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
    'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
    'Number', 'App', 'Text', 'Model');
  public $components = array('PersonasInfo', 'Paginator');
  public $uses = array('Agente', 'Pais');
  public $paginate = array(
    'limit' => 10,
    'recursive' => 0,
    'fields' => array('Agente.*', 'User.active'),
    'order' => array('Agente.id' => 'desc'));


	private static function getTiposAgente() {
		return array('e' => 'Editor', 'c' => 'Consultor', 'o' => 'Coordinador');
	}

  private function getPaises() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('Pais', function() use ($CI) {
          return $CI->Pais->find('all', array('order' => 'description', 'callbacks' => false));
        });
  }

  /**
   * 
   */
  public function index() {

    if ($this->request->is('post')) {
      $this->passedArgs = $this->request->data;
    } elseif (!empty($this->passedArgs)) {
	    $this->request->data = $this->passedArgs;
    }
    $agencia = $this->viewVars['agencia']['Agencia'];

    $search = $this->PersonasInfo->crearBusqueda($this->request->data, 'Agente');
    $search['Agente.agencia_id'] = $agencia['id'];

    if (!empty($this->passedArgs['sortBy'])) {
      $sortBy = explode(' ', $this->passedArgs['sortBy']);
      if (!isset($sortBy[1])) {
        $sortBy[1] = 'asc';
      }
      $this->paginate['order'] = array('Agente.' . $sortBy[0] => $sortBy[1]);
    }

    $this->Paginator->settings = $this->paginate;
    $this->set('info', $this->Paginator->paginate('Agente', $search));
  }

  /**
   *
   */
  public function add() {

    if ($this->request->is('post')) {
      $info = $this->request->data;
      try {
        $info['User']['username'] = $info['Agente']['email_contacto'];
        $info['User']['active'] = 't';

        $this->Agente->saveAssociated($info);

        $this->setSuccessFlash("El alta de agente se ha realizado correctamente. 
          Para realizar gestiones con este nuevo usuario, ser&aacute; preciso salir y volver a entrar en la aplicaci&oacute;n.");
        $this->request->data = null;
      } catch (Exception $ex) {
        CakeLog::error($ex);
        $str = 'La información no se ha guardado.';
        if ($ex->getCode() == 23505) {
          $str .= ' Es probable el email se encuentre duplicado.';
        }
        $this->setDangerFlash($str);
      }
    }

    $this->set('paises', $this->getPaises());
	  $this->set('tipos_agente', self::getTiposAgente());
    $agencia = $this->viewVars['agencia']['Agencia'];
    $this->request->data['Agente']['pais_id'] = $agencia['pais_id'];

    $this->view = '/Agentes/edit';
  }

	/**
	 * @param null $id
	 * @param null $url_64
	 */
	public function view($id = null, $url_64 = null) {

		$info = $this->Agente->find('first', array('conditions' => array('Agente.id' => $id), 'recursive' => 2));
		$this->request->data = $info;
		$this->request->data['referer'] = $url_64;

		$this->set('info', $info);
	}

  /**
   * @param null $id
   */
  public function edit($id = null) {

    /*
     * Comprueba si se le pasa un parámetro ($id). En caso de que se le pase dicho parámetro reinicia y obtiene la última página.
     * Si no, entonces busca los parámetros por "post"
     */
    if ($this->request->is('post')) {
      $info = $this->request->data;

      $id = $info['Agente']['id'];

      if (empty($info['User']['password'])) {
        unset($info['User']['password']);
      }
      $info['User']['username'] = $info['Agente']['email_contacto'];

      $datasource = $this->Agente->getDataSource();
      try {
        $this->Agente->saveAssociated($info);
        $datasource->commit();

        $this->setSuccessFlash("La información se ha guardado correctamente. Para que los cambios se hagan efectivos es necesario salir y volver a entrar en la aplicación.");

      } catch (Exception $ex) {
        $datasource->rollback();

        CakeLog::error($ex);
        $str = 'La información no se ha guardado.';
        if ($ex->getCode() == 23505) {
          $str .= ' Es probable que el email o usuario se encuentren duplicados.';
        }
        $this->setDangerFlash($str);
      }

    }

    $info = $this->Agente->find('first', array('conditions' => array('Agente.id' => $id), 'recursive' => 2));

    $this->request->data = $info;

    $this->set('info', $info);
	  $this->set('paises', $this->getPaises());
	  $this->set('tipos_agente', self::getTiposAgente());
  }

}
