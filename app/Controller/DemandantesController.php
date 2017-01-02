<?php

/**
 * Description of ApuntesController
 *
 * @author dmonje
 */
class DemandantesController extends AppController {

    public $helpers = array(
        'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
        'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
        'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
        'Number', 'App', 'Text', 'Model');

    public $components = array('PersonasInfo', 'Paginator');

    public $uses = array('Demandante',
        'Pais',
        'HorarioContacto',
        'ClasificacionDemandante',
        'TipoEvento',
        'TipoEquipamiento',
        'TipoCalefaccion',
        'EstadoConservacion',
        'TipoPiso',
        'TipoChalet',
        'TipoGaraje',
        'TipoOficina',
        'TipoTerreno');

    public $paginate = array(
        'limit' => 10,
        'recursive' => 2,
        'fields' => array('Demandante.*', 'Demanda.tipo', 'Demanda.operacion', 'Agente.id', 'Agente.nombre_contacto'),
        'order' => array('Demandante.id' => 'desc'));

    private static $tiposInmueble = array(
        '01' => 'piso',
        '02' => 'chalet',
        '03' => 'local',
        '04' => 'oficina',
        '05' => 'garaje',
        '06' => 'terreno',
        '07' => 'nave',
        '08' => 'otro');

    private static $operaciones = array(
        'ven' => 'venta',
        'alq' => 'alquiler',
        'tra' => 'traspaso',
        'opc' => 'opción a compra');

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

    private function getClasificacionesDemandante() {
        $CI = $this;
        return $this->Alfa->getTypologyInfo('ClasificacionDemandante', function() use ($CI) {
            return $CI->ClasificacionDemandante->find('all', array('order' => 'id', 'callbacks' => false));
        });
    }

    private function getEstadosInmueble() {
        $CI = $this;
        return $this->Alfa->getTypologyInfo('EstadoConservacion', function() use ($CI) {
            return $CI->EstadoConservacion->find('all', array('order' => 'id', 'callbacks' => false));
        });
    }

    private function getTiposEquipamiento() {
        $CI = $this;
        return $this->Alfa->getTypologyInfo('TipoEquipamiento', function() use ($CI) {
            return $CI->TipoEquipamiento->find('all', array('order' => 'id', 'callbacks' => false));
        });
    }

    private function getTiposCalefaccion() {
        $CI = $this;
        return $this->Alfa->getTypologyInfo('TipoCalefaccion', function() use ($CI) {
            return $CI->TipoCalefaccion->find('all', array('order' => 'id', 'callbacks' => false));
        });
    }

    private function getSubtiposInmueble($tipo_inmueble_id) {

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

        if (isset($class)) {
            foreach ($info_array as $info) {
                $result[$info[$class]['id']] = $info[$class]['description'];
            }
        }

        return $result;
    }

    /**
     * @param $tipo_inmueble_id
     */
    private function cargarInfoBusqueda($tipo_inmueble_id) {
        $this->set('tiposInmueble', array('' => '-- tipo --') + self::$tiposInmueble);

        $subtipos = array('' => '-- subtipo --');
        if (!empty($tipo_inmueble_id)) {
            $subtipos += $this->getSubtiposInmueble($tipo_inmueble_id);
        }
        $this->set('subtiposInmueble', $subtipos);

        $this->set('operaciones', array('' => '-- operación --') + self::$operaciones);
        $this->set('maximoAnios', array('' => '-- max. años --', 'on' => 'obra nueva', '10' => 'hasta 10 años', '20' => 'hasta 20 años', '30' => 'hasta 30 años'));
        $this->set('minimoDormitorios', array('' => '-- min. dormit. --', '1' => '1+', '2' => '2+', '3' => '3+', '4' => '4+'));
        $this->set('minimoBannos', array('' => '-- min. baños --', '1' => '1+', '2' => '2+', '3' => '3+', '4' => '4+'));
        $this->set('estadosConservacion', array('' => '-- conservación --') + self::getEstadosInmueble());

        $this->set('tiposEquipamiento', array('' => '-- equipamiento --') + $this->getTiposEquipamiento());
        $this->set('tiposCalefaccion', array('' => '-- calefacción --') + $this->getTiposCalefaccion());

        $this->set('paises', $this->getPaises());
        $this->set('horariosContacto', $this->getHorariosContacto());
        $this->set('clasificaciones', array('' => '') + $this->getClasificacionesDemandante());

        $this->set('agentes', $this->getAllAgentesAgencia());
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

        $search = $this->PersonasInfo->crearBusqueda($this->request->data, 'Demandante');
        $search['Demandante.agencia_id'] = $agencia['id'];

		    if ($this->isAgente() && !$this->isCoordinador()) {
			    $agente = $this->viewVars['agente']['Agente'];
			    $search['Demandante.agente_id'] = $agente['id'];
		    }

        if (!empty($this->passedArgs['sortBy'])) {
            $sortBy = explode(' ', $this->passedArgs['sortBy']);
            if (!isset($sortBy[1])) {
                $sortBy[1] = 'asc';
            }
            switch ($sortBy[0]) {
                case 'referencia':
                    $this->paginate['order'] = array('Demandante.numero_agencia' => 'asc', 'Demandante.codigo' => 'asc');
                    break;
                default:
                    $this->paginate['order'] = array('Demandante.' . $sortBy[0] => $sortBy[1]);
            }
        }

        $this->Paginator->settings = $this->paginate;
        $this->set('clasificaciones', array('' => '-- clasificación --') + $this->getClasificacionesDemandante());
        $this->set('info', $this->Paginator->paginate('Demandante', $search));
    }

    /**
     *
     */
    public function add() {

        if ($this->request->is('post')) {
            $info = $this->request->data;

            $datasource = $this->Demandante->getDataSource();
            try {
                $this->Demandante->saveAssociated($info);
                $datasource->commit();

                $this->setSuccessFlash("El demandante se ha creado correctamente.");
                $this->request->data = null;
            } catch (Exception $ex) {
                $datasource->rollback();

                CakeLog::error($ex);
                if ($ex->getCode() == 23505) {
                    $this->setDangerFlash("Se ha producido un error al salvar la información.");
                }
            }
        }

        $agencia = $this->viewVars['agencia']['Agencia'];
        $this->request->data['Demandante']['pais_id'] = $agencia['pais_id'];

        $tipo_inmueble_id = (isset($this->request->data['Demanda']['tipo'])) ? $this->request->data['Demanda']['tipo'] : '';
        $this->cargarInfoBusqueda($tipo_inmueble_id);

        $this->view = '/Demandantes/edit';
    }

    /**
     * @param null $id
     * @param null $url_64
     */
    public function view($id = null, $url_64 = null) {

        if (!isset($id)) {
            return $this->redirect(array('controller' => 'demandantes', 'action' => 'index'));
        }

        $info = $this->Demandante->find('first', array('conditions' => array('Demandante.id' => $id), 'recursive' => 2));
        $this->request->data = $info;
        $this->request->data['referer'] = $url_64;

        $this->set('tiposInmueble', array('' => '-- tipo --') + self::$tiposInmueble);
        $this->set('operaciones', array('' => '-- operación --') + self::$operaciones);
        $this->set('maximoAnios', array('' => '-- años --', 'on' => 'obra nueva', '10' => 'hasta 10 años', '20' => 'hasta 20 años', '30' => 'hasta 30 años'));
        $this->set('estadosConservacion', array('' => '-- conservación --') + self::getEstadosInmueble());

        $subtipos = array('' => '-- subtipo --');
        $tipo_inmueble_id = (isset($info['Demanda']['tipo'])) ? $info['Demanda']['tipo'] : '';
        if (!empty($tipo_inmueble_id)) {
            $subtipos += $this->getSubtiposInmueble($tipo_inmueble_id);
        }
        $this->set('subtiposInmueble', $subtipos);

        $this->set('tiposEquipamiento', array('' => '-- equipamiento --') + $this->getTiposEquipamiento());
        $this->set('tiposCalefaccion', array('' => '-- calefacción --') + $this->getTiposCalefaccion());

        $this->set('info', $info);
    }

    /**
     * @param null $id
     * @param null $url_64
     */
    /*
    public function edit($id = null, $url_64 = null) {

      if ($this->request->is('post')) {
        $info = $this->request->data;

        $id = $info['Demandante']['id'];
        $url_64 = $info['referer'];

          $this->Demandante->saveAssociated($info);

        $this->setSuccessFlash("La información se ha guardado correctamente.");
      }

      $info = $this->Demandante->find('first', array('conditions' => array('Demandante.id' => $id), 'recursive' => 2));
      $this->request->data = $info;
      $this->request->data['referer'] = $url_64;

      $this->set('info', $info);

      $tipo_inmueble_id = (isset($this->request->data['Demanda']['tipo'])) ? $this->request->data['Demanda']['tipo'] : '';
      $this->cargarInfoBusqueda($tipo_inmueble_id);
    }*/

    public function edit($id = null, $url_64 = null) {

        if ($this->request->is('post')) {
            $info = $this->request->data;

            $id = $info['Demandante']['id'];
            $url_64 = $info['referer'];

            $this->Demandante->saveAssociated($info);

            $this->view($id, $url_64);

            $this->view = '/Demandantes/view';

            //$this->setSuccessFlash("La información se ha guardado correctamente.");
        } else {

            $info = $this->Demandante->find('first', array('conditions' => array('Demandante.id' => $id), 'recursive' => 2));
            $this->request->data = $info;
            $this->request->data['referer'] = $url_64;

            $this->set('info', $info);

            $tipo_inmueble_id = (isset($this->request->data['Demanda']['tipo'])) ? $this->request->data['Demanda']['tipo'] : '';
            $this->cargarInfoBusqueda($tipo_inmueble_id);
        }

    }

}
