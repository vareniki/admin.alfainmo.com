<?php

/**
 * Description of PropietariosController
 *
 * @author dmonje
 */
class PropietariosController extends AppController {

  public $helpers = array(
    'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
    'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
    'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
    'Number', 'App', 'Text', 'Model');
  public $components = array('PersonasInfo', 'Paginator');
  public $uses = array('Propietario', 'Contacto', 'Pais', 'HorarioContacto', 'TipoEvento');
  public $paginate = array(
    'limit' => 10,
    'recursive' => 1,
    'fields' => array('Propietario.*', 'Inmueble.id', 'Inmueble.agencia_id', 'Inmueble.numero_agencia', 'Inmueble.codigo'),
    'order' => array('Propietario.id' => 'desc'));

  private function getPaises() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('Pais', function() use ($CI) {
          return $CI->Pais->find('all', array('order' => 'description', 'callbacks' => false));
        });
  }

  private function getHorariosContacto() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('HorarioContacto', function() use ($CI) {
          return $CI->HorarioContacto->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

	/**
	 * @param $id
	 * @return mixed
	 */
	private function cargarPropietario($id) {
		$info = $this->Propietario->find('first', array('conditions' => array('Propietario.id' => $id), 'recursive' => 2));
		if (!empty($info)) {
			$info2 = $this->Contacto->find('first', array('conditions' => array('Contacto.inmueble_id' => $info['Propietario']['inmueble_id']), 'recursive' => 1));
			if (isset($info2['Contacto'])) {
				$info['Contacto'] = & $info2['Contacto'];
			}
			if (isset($info2['HorarioContacto'])) {
				$info['HorarioContacto'] = & $info2['HorarioContacto'];
			}
		}
		return $info;
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

    $search = $this->PersonasInfo->crearBusqueda($this->request->data, 'Propietario');
    $search['Inmueble.agencia_id'] = $agencia['id'];

    if (!empty($this->passedArgs['sortBy'])) {
      $sortBy = explode(' ', $this->passedArgs['sortBy']);
      if (!isset($sortBy[1])) {
        $sortBy[1] = 'asc';
      }

      switch ($sortBy[0]) {
        case 'referencia':
          $this->paginate['order'] = array('Inmueble.numero_agencia' => 'asc', 'Inmueble.codigo' => 'asc');
          break;
        default:
          if (strpos($sortBy[0], '.') === false) {
            $sortBy[0] = 'Propietario.' . $sortBy[0];
          }
          $this->paginate['order'] = array($sortBy[0] => $sortBy[1]);
      }
    }

    $this->Paginator->settings = $this->paginate;
    $this->set('info', $this->Paginator->paginate('Propietario', $search));
  }

  /**
   * @param null $id
   * @param null $url_64
   */
  public function view($id = null, $url_64 = null) {
    /*
     * Comprueba si se le pasa un parámetro ($id). En caso de que se le pase dicho parámetro reinicia y obtiene la última página.
     * Si no, entonces busca los parámetros por "post"
     */
    if (isset($id)) {
      $this->request->data['referer'] = $url_64;
    }
	  $info = $this->cargarPropietario($id);

    $this->set('info', $info);
  }

  /**
   * 
   * @param type $id
   * @param type $url_64
   */
  public function edit($id = null, $url_64 = null) {
    /*
     * Comprueba si se le pasa un parámetro ($id). En caso de que se le pase dicho parámetro reinicia y obtiene la última página.
     * Si no, entonces busca los parámetros por "post"
     */
    if ($this->request->is('post')) {
      $info = $this->request->data;

      $id = $info['Propietario']['id'];
      $url_64 = $info['referer'];

      $this->Propietario->save($info['Propietario']);
	    if (isset($info['Contacto'])) {
		    $this->Contacto->save($info['Contacto']);
	    }

      $this->setSuccessFlash("La información se ha guardado correctamente.");
    }
		$info = $this->cargarPropietario($id);

    $this->request->data = $info;
    $this->request->data['referer'] = $url_64;

    $this->set('info', $info);

    $this->set('paises', $this->getPaises());
    $this->set('horariosContacto', $this->getHorariosContacto());
    $this->set('agentes', $this->getAllAgentesAgencia());
  }

}
