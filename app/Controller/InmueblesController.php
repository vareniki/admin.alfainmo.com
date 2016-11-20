<?php

/**
 * Class InmueblesController
 */
class InmueblesController extends AppController {

  public $helpers = array(
    'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
    'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
    'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
    'Number', 'App', 'Model', 'Inmuebles');

  public $components = array('Paginator', 'InmueblesInfo');

  public $uses = array('Piso', 'Chalet', 'Local', 'Nave', 'Oficina', 'Garaje', 'Terreno', 'Otro',
    'Propietario', 'Demandante', 'Inmueble', 'Imagen', 'Documento', 'Evento', 'Portal', 'Pais',
    'PlantaPiso', 'PuertaPiso', 'TipoInmueble', 'TipoPiso', 'TipoChalet', 'TipoGaraje', 'TipoOficina', 'TipoTerreno',
    'TipoAA', 'SubtipoCalefaccion', 'TipoCalefaccion', 'TipoAguaCaliente', 'TipoOrientacion', 'TipoSuelo',
    'TipoPuerta', 'TipoVentana', 'TipoTendedero', 'TipoEquipamiento', 'TipoCableado', 'EstadoConservacion',
    'Contacto', 'TipoContrato', 'MedioCaptacion', 'InteriorExterior', 'CalificacionEnergetica', 'LocalizacionLocal',
    'HorarioContacto', 'TipoImagen', 'TipoEvento', 'MotivoBaja', 'EstadoInmueble', 'Provincia', 'Poblacion', 'Agente');

  private static $tiposInmueble = array(
    '01' => 'piso',
    '02' => 'chalet',
    '03' => 'local',
    '04' => 'oficina',
    '05' => 'garaje',
    '06' => 'terreno',
    '07' => 'nave',
    '08' => 'otro');
	private static $tiposInmueble_desc = array(
		'01' => 'piso',
		'02' => 'chalet/casa',
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

	private static $calidadPrecio = array(
		'01' => 'muy bien',
		'02' => 'normal',
		'03' => 'caro');

	private static $metros = array(
		'40' => '40 m2',
		'60' => '60 m2',
		'80' => '80 m2',
		'100' => '100 m2',
		'120' => '120 m2',
		'140' => '140 m2',
		'160' => '160 m2',
		'180' => '180 m2',
		'200' => '200 m2',
		'400' => '400 m2',
		'600' => '600 m2',
		'700' => '700 m2',
		'800' => '800 m2'
	);

  public $paginate = array(
    'limit' => 50,
    'recursive' => 1,
    'fields' => array(
      'Inmueble.id',
      'Inmueble.referencia',
      'Inmueble.numero_agencia',
      'Inmueble.codigo',
      'Inmueble.es_venta',
      'Inmueble.es_alquiler',
      'Inmueble.es_traspaso',
      'Inmueble.es_opcion_compra',
      'Inmueble.coord_x',
      'Inmueble.coord_y',
      'Inmueble.precio_venta',
      'Inmueble.precio_alquiler',
      'Inmueble.precio_traspaso',
	    'Inmueble.moneda_id',
      'Inmueble.poblacion',
      'Inmueble.provincia',
      'Inmueble.fecha_baja',
      'Inmueble.fecha_captacion',
      'Inmueble.created',
      'Inmueble.updated',
      'Inmueble.modified',
      'Inmueble.agencia_id',
      'Inmueble.agente_id',
	    'Inmueble.nombre_calle',
	    'Inmueble.numero_calle',
	    'Inmueble.zona',
      'Piso.area_total_construida',
	    'Piso.numero_habitaciones',
	    'Piso.numero_banos',
	    'Piso.numero_aseos',
	    'Piso.con_parking',
	    'Piso.numero_ascensores',
	    'Piso.plazas_parking',
			'Piso.estado_conservacion_id',
	    'Piso.tipo_piso_id',
	    'Piso.piso',
      'Chalet.area_total_construida',
	    'Chalet.numero_habitaciones',
	    'Chalet.numero_banos',
	    'Chalet.numero_aseos',
	    'Chalet.con_ascensor',
	    'Chalet.plazas_parking',
	    'Chalet.estado_conservacion_id',
	    'Chalet.tipo_chalet_id',
      'Local.area_total_construida',
	    'Local.numero_aseos',
	    'Local.plazas_parking',
	    'Local.estado_conservacion_id',
      'Nave.area_total_construida',
	    'Nave.numero_aseos',
	    'Nave.plazas_parking',
	    'Nave.plazas_parking',
	    'Nave.anio_construccion',
      'Oficina.area_total_construida',
	    'Oficina.numero_habitaciones',
	    'Oficina.numero_banos',
	    'Oficina.numero_aseos',
	    'Oficina.numero_ascensores',
	    'Oficina.plazas_parking',
	    'Oficina.estado_conservacion_id',
	    'Oficina.tipo_oficina_id',
	    'Oficina.piso',
	    'Garaje.tipo_garaje_id',
	    'Garaje.area_total',
	    'Terreno.tipo_terreno_id',
	    'Terreno.area_total',
	    'Otro.area_total',
      'TipoInmueble.id',
      'TipoInmueble.description',
      'TipoMoneda.symbol',
      'Agente.nombre_contacto'),
    'order' => array('Inmueble.numero_agencia' => 'asc', 'Inmueble.codigo' => 'desc')
  );


	/**
	 * @return mixed
	 */
	private function getTiposInmueble() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoInmueble', function() use ($CI) {
          return $CI->TipoInmueble->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

	/**
	 * @param $tipo_inmueble_id
	 * @return array
	 */
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

  private function getTiposPiso() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoPiso', function() use ($CI) {
          return $CI->TipoPiso->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposChalet() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoChalet', function() use ($CI) {
          return $CI->TipoChalet->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposGaraje() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoGaraje', function() use ($CI) {
          return $CI->TipoGaraje->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposOficina() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoOficina', function() use ($CI) {
          return $CI->TipoOficina->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getPaises() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('Pais', function() use ($CI) {
          return $CI->Pais->find('all', array('order' => 'description', 'callbacks' => false));
        });
  }

  private function getTiposTerreno() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoTerreno', function() use ($CI) {
          return $CI->TipoTerreno->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getInteriorExterior() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('InteriorExterior', function() use ($CI) {
          return $CI->InteriorExterior->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposOrientacion() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoOrientacion', function() use ($CI) {
          return $CI->TipoOrientacion->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getEstadosConservacion() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('EstadoConservacion', function() use ($CI) {
          return $CI->EstadoConservacion->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposAA() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoAA', function() use ($CI) {
          return $CI->TipoAA->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposCalefaccion() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoCalefaccion', function() use ($CI) {
          return $CI->TipoCalefaccion->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getSubtiposCalefaccion() {
    $result = array();
    $all = $this->SubtipoCalefaccion->find('all', array('order' => 'description', 'callbacks' => false));

    foreach ($all as $info) {
      $result[] = $info['SubtipoCalefaccion']['description'];
    }
    return $result;
  }

  private function getTiposAguaCaliente() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoAguaCaliente', function() use ($CI) {
          return $CI->TipoAguaCaliente->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposEquipamiento() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoEquipamiento', function() use ($CI) {
          return $CI->TipoEquipamiento->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposSuelo() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoSuelo', function() use ($CI) {
          return $CI->TipoSuelo->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposPuerta() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoPuerta', function() use ($CI) {
          return $CI->TipoPuerta->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposVentana() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoVentana', function() use ($CI) {
          return $CI->TipoVentana->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposTendedero() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoTendedero', function() use ($CI) {
          return $CI->TipoTendedero->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getCalifEnergeticas() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('CalificacionEnergetica', function() use ($CI) {
          return $CI->CalificacionEnergetica->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposCableado() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoCableado', function() use ($CI) {
          return $CI->TipoCableado->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getPlantasPiso() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('PlantaPiso', function() use ($CI) {
          return $CI->PlantaPiso->find('all', array('order' => 'order_by', 'callbacks' => false));
        });
  }

  private function getPuertasPiso() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('PuertaPiso', function() use ($CI) {
          return $CI->PuertaPiso->find('all', array('order' => 'order_by', 'callbacks' => false));
        });
  }

  private function getLocalizacionesLocal() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('LocalizacionLocal', function() use ($CI) {
          return $CI->LocalizacionLocal->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getHorariosContacto() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('HorarioContacto', function() use ($CI) {
          return $CI->HorarioContacto->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getTiposImagen() {
    return $this->TipoImagen->find('all', array('order' => 'description',
          'callbacks' => false, 'conditions' => array('id >=' => '01')));
  }

  private function getTiposContrato() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('TipoContrato', function() use ($CI) {
          return $CI->TipoContrato->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getMediosCaptacion() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('MedioCaptacion', function() use ($CI) {
          return $CI->MedioCaptacion->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getMotivosBaja() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('MotivoBaja', function() use ($CI) {
          return $CI->MotivoBaja->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

  private function getEstadosInmueble() {
    $CI = $this;
    return $this->Alfa->getTypologyInfo('EstadoInmueble', function() use ($CI) {
          return $CI->EstadoInmueble->find('all', array('order' => 'id', 'callbacks' => false));
        });
  }

	private function getPortales() {
		$CI = $this;
		return $this->Alfa->getTypologyInfo('Portal', function() use ($CI) {
			return $CI->Portal->find('all', array('order' => 'id', 'callbacks' => false, 'conditions' => array('incluir' => 't')));
		});
	}

	private function getNoPortales() {
		$CI = $this;
		return $this->Alfa->getTypologyInfo('Portal', function() use ($CI) {
			return $CI->Portal->find('all', array('order' => 'id', 'callbacks' => false, 'conditions' => array('excluir' => 't')));
		}, false);
	}

	private function getPortalesNo00($isCentral) {
		$CI = $this;
		return $this->Alfa->getTypologyInfo('Portal', function() use ($CI, $isCentral) {
			$conditions['id <>'] = '00';
			if (!$isCentral) {
				$conditions['central'] = 'f';
			}
			return $CI->Portal->find('all', array('order' => 'id', 'callbacks' => false, 'conditions' => $conditions));
		}, false);
	}

	private function getCentralPortales() {
		$CI = $this;
		return $this->Alfa->getTypologyInfo('Portal', function() use ($CI) {
			return $CI->Portal->find('all', array('order' => 'id', 'callbacks' => false, 'conditions' => array('central' => 't')));
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
   * @param $info
   * @return null
   */
  private function salvarInmueble($info, $lastInfo=null) {

    if (isset($info['Inmueble']['id'])) {
      $id = $info['Inmueble']['id'];

	    $agencia = $this->viewVars['agencia']['Agencia'];
	    $agente = isset($this->viewVars['agente']['Agente']) ? $this->viewVars['agente']['Agente'] : array();

      $cambios = $this->InmueblesInfo->getActualizacionCambios($info, $lastInfo, $agencia, $agente, ($this->request->data['_checkdup'] == '1'));
	    if (!empty($cambios)) {
		    $ret = $this->Evento->saveMany($cambios);
	    }

    } else {
      $id = null;
    }

    $this->Inmueble->save($info['Inmueble']);
    if ($id == null) {
      $id = $this->Inmueble->getLastInsertID();
    }

    switch ($info['Inmueble']['tipo_inmueble_id']) {
      case '01':
        $info['Piso']['inmueble_id'] = $id;
        $this->Piso->save($info['Piso']);
        break;
      case '02':
        $info['Chalet']['inmueble_id'] = $id;
        $this->Chalet->save($info['Chalet']);
        break;
      case '03':
        $info['Local']['inmueble_id'] = $id;
        $this->Local->save($info['Local']);
        break;
      case '04':
        $info['Oficina']['inmueble_id'] = $id;
        $this->Oficina->save($info['Oficina']);
        break;
      case '05':
        $info['Garaje']['inmueble_id'] = $id;
        $this->Garaje->save($info['Garaje']);
        break;
      case '06':
        $info['Terreno']['inmueble_id'] = $id;
        $this->Terreno->save($info['Terreno']);
        break;
      case '07':
        $info['Nave']['inmueble_id'] = $id;
        $this->Nave->save($info['Nave']);
        break;
      case '08':
        $info['Otro']['inmueble_id'] = $id;
        $this->Otro->save($info['Otro']);
        break;
    }

    $info['Contacto']['inmueble_id'] = $id;
    $info['Propietario']['inmueble_id'] = $id;

    $this->Contacto->save($info['Contacto']);
    $this->Propietario->save($info['Propietario']);

    $this->setSuccessFlash("La información se ha guardado correctamente.");

    return $id;
  }

  /**
   * @param $info
   */
  private function editInmueble_piso($info) {
    $this->set('tiposPiso', $this->getTiposPiso());

    $this->set('interiorExterior', $this->getInteriorExterior());
    $this->set('tiposOrientacion', $this->getTiposOrientacion());
    $this->set('estadosConservacion', $this->getEstadosConservacion());
    $this->set('tiposAA', $this->getTiposAA());
    $this->set('tiposCalefaccion', $this->getTiposCalefaccion());
    $this->set('subtiposCalefaccion', $this->getSubtiposCalefaccion());
    $this->set('tiposAguaCaliente', $this->getTiposAguaCaliente());
    $this->set('tiposEquipamiento', $this->getTiposEquipamiento());
    $this->set('tiposSuelo', $this->getTiposSuelo());
    $this->set('tiposPuerta', $this->getTiposPuerta());
    $this->set('tiposVentana', $this->getTiposVentana());
    $this->set('tiposTendedero', $this->getTiposTendedero());
    $this->set('califEnergeticas', $this->getCalifEnergeticas());

    $this->set('plantasPiso', $this->getPlantasPiso());
    $this->set('puertasPiso', $this->getPuertasPiso());
  }

  /**
   * 
   * @param type $info
   */
  private function editInmueble_chalet($info) {
    $this->set('tiposChalet', $this->getTiposChalet());

    $this->set('interiorExterior', $this->getInteriorExterior());
    $this->set('tiposOrientacion', $this->getTiposOrientacion());
    $this->set('estadosConservacion', $this->getEstadosConservacion());

    $this->set('tiposAA', $this->getTiposAA());
    $this->set('tiposCalefaccion', $this->getTiposCalefaccion());
    $this->set('subtiposCalefaccion', $this->getSubtiposCalefaccion());
    $this->set('tiposAguaCaliente', $this->getTiposAguaCaliente());
    $this->set('tiposEquipamiento', $this->getTiposEquipamiento());
    $this->set('tiposSuelo', $this->getTiposSuelo());
    $this->set('tiposPuerta', $this->getTiposPuerta());
    $this->set('tiposVentana', $this->getTiposVentana());
    $this->set('tiposTendedero', $this->getTiposTendedero());
    $this->set('califEnergeticas', $this->getCalifEnergeticas());
  }

  /**
   * 
   * @param type $info
   */
  private function editInmueble_local($info) {

    $this->set('estadosConservacion', $this->getEstadosConservacion());
    $this->set('tiposAA', $this->getTiposAA());
    $this->set('tiposCalefaccion', $this->getTiposCalefaccion());
    $this->set('subtiposCalefaccion', $this->getSubtiposCalefaccion());
    $this->set('tiposAguaCaliente', $this->getTiposAguaCaliente());
    $this->set('tiposSuelo', $this->getTiposSuelo());
    $this->set('tiposPuerta', $this->getTiposPuerta());
    $this->set('tiposVentana', $this->getTiposVentana());
    $this->set('califEnergeticas', $this->getCalifEnergeticas());

    $this->set('puertasLocal', $this->getPuertasPiso());
    $this->set('localizacionesLocal', $this->getLocalizacionesLocal());
  }

  /**
   * 
   * @param type $info
   */
  private function editInmueble_oficina($info) {
    $this->set('tiposOficina', $this->getTiposOficina());

    $this->set('interiorExterior', $this->getInteriorExterior());
    $this->set('tiposOrientacion', $this->getTiposOrientacion());
    $this->set('estadosConservacion', $this->getEstadosConservacion());
    $this->set('tiposAA', $this->getTiposAA());
    $this->set('tiposCalefaccion', $this->getTiposCalefaccion());
    $this->set('subtiposCalefaccion', $this->getSubtiposCalefaccion());
    $this->set('tiposAguaCaliente', $this->getTiposAguaCaliente());
    $this->set('tiposSuelo', $this->getTiposSuelo());
    $this->set('tiposPuerta', $this->getTiposPuerta());
    $this->set('tiposVentana', $this->getTiposVentana());
    $this->set('tiposCableado', $this->getTiposCableado());
    $this->set('califEnergeticas', $this->getCalifEnergeticas());

    $this->set('plantasOficina', $this->getPlantasPiso());
    $this->set('puertasOficina', $this->getPuertasPiso());
  }

  /**
   * 
   * @param type $info
   */
  private function editInmueble_garaje($info) {
    $this->set('tiposGaraje', $this->getTiposGaraje());
  }

  /**
   * 
   * @param type $info
   */
  private function editInmueble_terreno($info) {
    $this->set('tiposTerreno', $this->getTiposTerreno());
  }

  /**
   * 
   * @param type $info
   */
  private function editInmueble_nave($info) {

    $this->set('estadosConservacion', $this->getEstadosConservacion());
    $this->set('tiposAA', $this->getTiposAA());
    $this->set('tiposCalefaccion', $this->getTiposCalefaccion());
    $this->set('subtiposCalefaccion', $this->getSubtiposCalefaccion());
    $this->set('tiposAguaCaliente', $this->getTiposAguaCaliente());
    $this->set('tiposSuelo', $this->getTiposSuelo());
    $this->set('tiposPuerta', $this->getTiposPuerta());
    $this->set('tiposVentana', $this->getTiposVentana());
    $this->set('califEnergeticas', $this->getCalifEnergeticas());

    $this->set('plantasNave', $this->getPlantasPiso());
    $this->set('puertasNave', $this->getPuertasPiso());
  }

  public function add() {
    $this->set('tiposInmueble', $this->getTiposInmueble());
    $this->set('tiposPiso', $this->getTiposPiso());
    $this->set('tiposChalet', $this->getTiposChalet());
    $this->set('tiposOficina', $this->getTiposOficina());
    $this->set('tiposGaraje', $this->getTiposGaraje());
    $this->set('tiposTerreno', $this->getTiposTerreno());
  }

  /**
   * 
   */
  public function index() {

	  if ($this->request->is('post')) {
		  $this->passedArgs = $this->request->data;
		  $this->Session->write("inmueblesSearch", $this->request->data);
	  } elseif ($this->Session->check("inmueblesSearch")) {
		  $this->request->data = $this->Session->read("inmueblesSearch");
	  }
	  if (!empty($this->passedArgs)) {
		  $this->request->data = $this->request->data + $this->passedArgs;
	  }

	  $agencia = $this->viewVars['agencia']['Agencia'];

	  if (empty($this->request->data['pais_id'])) {
		  $this->request->data['pais_id'] = $agencia['pais_id'];
	  }

	  $subtipos = array('' => '-- subtipo --');
	  if (!empty($this->request->data['tipo'])) {
		  $subtipos += $this->getSubtiposInmueble($this->request->data['tipo']);
	  }

	  $this->set('paises', array('' => '-- país --') + $this->getPaises());

	  $this->set('tiposInmueble', array('' => '-- tipo inmueble --') + self::$tiposInmueble_desc);
	  $this->set('subtiposInmueble', $subtipos);
	  $this->set('operaciones', array('' => '-- operación --') + self::$operaciones);
	  $this->set('maximoAnios', array('' => '-- años --', 'on' => 'obra nueva', '10' => 'hasta 10 años', '20' => 'hasta 20 años', '30' => 'hasta 30 años'));
	  $this->set('minimoDormitorios', array('' => '-- min. dormit. --', '1' => '1+', '2' => '2+', '3' => '3+', '4' => '4+'));
	  $this->set('minimoBannos', array('' => '-- min. baños --', '1' => '1+', '2' => '2+', '3' => '3+', '4' => '4+'));
	  $this->set('estadosConservacion', array('' => '-- conservación --') + self::getEstadosConservacion());

	  $this->set('tiposEquipamiento', array('' => '-- equipamiento --') + $this->getTiposEquipamiento());
	  $this->set('tiposCalefaccion', array('' => '-- calefacción --') + $this->getTiposCalefaccion());
	  $this->set('estadosInmueble', array('' => '-- estado --') + $this->getEstadosInmueble());
	  $this->set('tiposContrato', array('' => '-- encargo --') + $this->getTiposContrato());
	  $this->set('calidadPrecio', array('' => '-- calidad --') + self::$calidadPrecio);
	  $this->set('motivosBaja', array('' => '-- motivo de baja --') + $this->getMotivosBaja());
	  $this->set('plantasPiso', $this->getPlantasPiso());
	  $this->set('metros', self::$metros);

	  $this->set('agentes', array('' => '-- agente --' ) + $this->getAllAgentesAgencia());
    $this->set('portales', array('' => '-- portales --' ) + $this->getPortalesNo00($this->isCentral()));

    $search = $this->InmueblesInfo->crearBusqueda($this->request->data, $agencia, $this->isCentral());

	  if (!empty($search)) {

		  if (!empty($this->passedArgs['sortBy'])) {
			  $sortBy = explode(' ', $this->passedArgs['sortBy']);

			  switch ($sortBy[0]) {
				  case 'precio':
					  if (isset($search['Inmueble.es_alquiler'])) {
						  $this->paginate['order'] = array('Inmueble.precio_alquiler' => 'asc');
					  } else if (isset($search['Inmueble.es_traspaso'])) {
						  $this->paginate['order'] = array('Inmueble.precio_traspaso' => 'asc');
					  } else {
						  $this->paginate['order'] = array('Inmueble.precio_venta' => 'asc');
					  }
					  break;
				  case 'referencia':
					  $this->paginate['order'] = array('Inmueble.numero_agencia' => 'asc', 'Inmueble.codigo' => 'asc');
					  break;
				  case 'resumen':
					  $this->paginate['order'] = array(
						  'Inmueble.tipo_inmueble_id' => 'asc',
						  'Inmueble.provincia' => 'asc',
						  'Inmueble.poblacion' => 'asc');
					  break;
				  default:
					  if (!isset($sortBy[1])) {
						  $sortBy[1] = 'asc';
					  }
					  if (strpos($sortBy[0], '.') === false) {
						  $sortBy[0] = 'Inmueble.' . $sortBy[0];
					  }
					  $this->paginate['order'] = array($sortBy[0] => $sortBy[1]);
			  }
		  }

		  $this->Paginator->settings = $this->paginate;
		  $this->set('info', $this->Paginator->paginate('Inmueble', $search));
	  } else {
		  $this->set('info', array());
	  }

  }

  /**
   * 
   * @param type $id
   * @param type $url_64
   */
  public function view($id = null, $url_64 = null) {
    /*
     * Comprueba si se le pasa un parámetro ($id). En caso de que se le pase dicho parámetro reinicia y obtiene la última página.
     * Si no, entonces busca los parámetros por "post"
     */
    if (isset($id)) {
      $this->request->data['referer'] = $url_64;
    }

    // Llama a la función específica en función del tipo de inmueble actual
    $info = $this->Inmueble->find('first', array('conditions' => array('Inmueble.id' => $id), 'recursive' => 2));
    $this->set('info', $info);

    $tipoInmueble = self::$tiposInmueble[$info['Inmueble']['tipo_inmueble_id']];
    $this->set('tipoInmueble', $tipoInmueble);
	  $this->set('calidadPrecio', self::$calidadPrecio);
  }

  /**
   * 
   * @param type $id
   * @param type $url_64
   */
  public function edit($id = null, $url_64 = null) {
	  /*
		 * Comprueba si se le pasa un parámetro ($id). En caso de que se le pase dicho parámetro reinicia
		 * y obtiene la última página. Si no, entonces busca los parámetros por "post"
		 */
	  $selectedTab = 'tab1';
	  $nuevoInmueble = false;
	  if ( $id == null && $this->request->is( 'post' ) ) {
		  $info = $this->request->data;

		  if ( ! empty( $info ) ) {

			  if ( ! isset( $info['Inmueble']['id'] ) ) {

				  /*
					 * NUEVO INMUEBLE
					 */
				  $nuevoInmueble = true;
				  $lastInfo      = $this->Session->read( 'Inmueble.info' );
				  $id            = $this->salvarInmueble( $info, $lastInfo );

			  } else {

				  /*
					 * EDICIÓN DE INMUEBLE
					 */
				  $id = $info['Inmueble']['id'];

				  if ( $info['Inmueble']['estado_inmueble_id'] == '02' ) {
					  $aceptar_estado = true;
					  $campos         = '';
					  if ( ! $this->InmueblesInfo->comprobarDatosObligatorios( $info, $campos ) ) {
						  $this->setDangerFlash( 'Compruebe que ha rellenado los siguientes campos obligatorios para la captación: <strong>' . $campos . '</strong>' );
						  $aceptar_estado = false;
					  }

					  // Si los datos obligatorios son correctos y el estado anterior es '01' o '05' entonces comprueba la NO existencia de duplicados
					  if ( $aceptar_estado && ( $info['_estado_inmueble_id'] == '01' || $info['_estado_inmueble_id'] == '05' ) ) {
						  $conditions = $this->InmueblesInfo->getDuplicadosSql( $info );
						  if ( ! empty( $conditions ) ) {
							  $found = $this->Inmueble->find( 'first', array(
									  'conditions' => $conditions,
									  'fields'     => array( 'Inmueble.numero_agencia', 'Inmueble.codigo' ),
									  'recursive'  => 0,
									  'callbacks'  => false,
							  ) );

							  if ( ! empty( $found ) ) {
								  $this->setDangerFlash( 'Duplicado con referencia ' . $found['Inmueble']['numero_agencia'] . '/' . $found['Inmueble']['codigo'] );
								  $aceptar_estado = false;
							  }

						  }
					  }

					  if ( ! $aceptar_estado ) {
						  $info['Inmueble']['estado_inmueble_id'] = '01';
					  }

				  } else if ( $info['Inmueble']['estado_inmueble_id'] == '01' ) {

					  // Comprobación de posibles duplicados siempre que estemos en la solapa de dirección.
					  if ( $this->request->data['_checkdup'] == '1' ) {
						  $conditions = $this->InmueblesInfo->getDuplicadosSql( $info );
						  if ( ! empty( $conditions ) ) {
							  $found = $this->Inmueble->find( 'first', array(
									  'conditions' => $conditions,
									  'fields'     => array( 'Inmueble.numero_agencia', 'Inmueble.codigo' ),
									  'recursive'  => 0,
									  'callbacks'  => false,
							  ) );

							  if ( ! empty( $found ) ) {
								  $this->setDangerFlash( 'Posible duplicado con referencia ' . $found['Inmueble']['numero_agencia'] . '/' . $found['Inmueble']['codigo'] );
							  }
						  }
					  }
				  }

				  $lastInfo = $this->Session->read( 'Inmueble.info' );

				  $this->salvarInmueble( $info, $lastInfo );
				  $this->enviarFotos( $info );
				  $this->enviarDocumentos( $info );
			  }
		  } else {

			  $this->setDangerFlash( 'No se han grabado los datos del inmueble, es posible que deba enviar menos imágenes de una sóla vez.' );

			  if ( isset( $_SESSION['Inmueble']['info'] ) ) {
				  $info = $_SESSION['Inmueble']['info'];
				  $id   = $info['Inmueble']['id'];

			  } else {
				  return;
			  }
		  }

		  if ( ! empty( $info['selectedTab'] ) ) {
			  $selectedTab = $info['selectedTab'];
		  }
	  }
	  $this->set( 'selectedTab', $selectedTab );

	  $info = $this->Inmueble->find( 'first', array( 'conditions' => array( 'Inmueble.id' => $id ), 'recursive' => 2 ) );
	  $this->Session->write( 'Inmueble.info', $info );

	  $agencia = $this->viewVars['agencia']['Agencia'];

	  if ( ! isset( $info['Inmueble']['pais_id'] ) ) {
		  $info['Inmueble']['pais_id'] = $agencia['pais_id'];
	  }
	  if ( ! isset( $info['Propietario']['pais_id'] ) ) {
		  $info['Propietario']['pais_id'] = $agencia['pais_id'];
	  }

	  $this->request->data = $this->InmueblesInfo->depurarInfoInmueble( $info, array(
			  'TipoSuelo',
			  'TipoPuerta',
			  'TipoVentana',
			  'Portal'
	  ) );

	  if ( isset( $info['referer'] ) ) {
		  $this->request->data['referer'] = $info['referer'];
	  }

	  if ( ! $nuevoInmueble && ! empty( $this->passedArgs ) ) {
		  $this->InmueblesInfo->validarThumbnails( $info );
	  }

	  $this->set( 'info', $info );
	  $this->set( 'tiposImagen', $this->getTiposImagen() );
	  $this->set( 'paises', $this->getPaises() );
	  $this->set( 'horariosContacto', $this->getHorariosContacto() );
	  $this->set( 'tiposContrato', $this->getTiposContrato() );
	  $this->set( 'mediosCaptacion', $this->getMediosCaptacion() );
	  $this->set( 'motivosBaja', $this->getMotivosBaja() );
	  $this->set( 'estadosInmueble', $this->getEstadosInmueble() );

	  $this->set( 'calidadPrecio', self::$calidadPrecio );
	  $this->set( 'portales', $this->getPortales() );
	  $this->set( 'noPortales', $this->getNoPortales() );

	  //if ( $this->isCentral() ) {
	    $this->set( 'centralPortales', $this->getCentralPortales() );
    //}

	  if ($info['Agencia']['id'] == $agencia['id']) {
		  $this->set('agentes', $this->getAllAgentesAgencia());
	  } else {
		  $agentes = $this->getAllAgentesAgencia();
		  if (!empty($info['Agente'])) {
			  $agentes[$info['Agente']['id']] = $info['Agente']['nombre_contacto'];
		  }
      $this->set('agentes', $agentes);
	  }

	  if (isset($info['Inmueble']['codigo_postal']) && strlen($info['Inmueble']['codigo_postal']) == 5) {
		  $provId = substr($info['Inmueble']['codigo_postal'], 0, 3);
	  }
	  if (isset($provId)) {
		  $this->set('poblaciones_ids', $this->getPoblaciones(substr($provId, 0, 2)));
	  } else {
		  $this->set('poblaciones_ids', array());
	  }

    $tipoInmueble = self::$tiposInmueble[$info['Inmueble']['tipo_inmueble_id']];
    $editInmueble = "editInmueble_$tipoInmueble";
    if (method_exists($this, $editInmueble)) {
      $this->{$editInmueble}($info);
    }

    $this->set('tipoInmueble', $tipoInmueble);
  }

  /**
   * @param string $tam
   * @param null $img
   * @return int
   */
  public function image($tam = 'm', $img = null) {

    $config = Configure::read('alfainmo');
    $folder = $config ['images.path'];

    $this->layout = null;
    $this->autoRender = false;

	  $pref = ($tam != 'o') ? $tam . '_' : '';

    if ($img == null) {
      header('Content-Type: image/png');
      $this->response->type('image/png');
      return readfile($folder . $tam . '_sin_fotos.png');
    } else {
      $img = str_replace('|', '/', $img);
      $ext = pathinfo($img, PATHINFO_EXTENSION);

      $path = pathinfo($img, PATHINFO_DIRNAME);
      if ($path == '.') {
        $path = '';
      }

      $basename = pathinfo($img, PATHINFO_BASENAME);
      $file = $folder . $path . DIRECTORY_SEPARATOR . $pref . $basename;

      header("Content-Type: image/$ext");
      $this->response->type("image/$ext");

      return readfile($file);
    }
  }

  /**
   * @param $info
   */
  private function enviarFotos($info) {
    if (!isset($_FILES['fotos'])) {
      return;
    }
    $inmuebleId = $info['Inmueble']['id'];
    /* Comprueba si hay imágenes */
    foreach ($_FILES['fotos']['tmp_name'] as $file) {
      if (empty($file)) {
        continue;
      }
      $result = $this->InmueblesInfo->addFoto($inmuebleId, $file);
      if ($result !== false) {
        $this->Imagen->create();
        $this->Imagen->save($result);
      }
    }
  }

	/**
	 * @param $info
	 */
	private function enviarDocumentos($info) {
		if (!isset($_FILES['documentos'])) {
			return;
		}
		$inmuebleId = $info['Inmueble']['id'];

		/* Comprueba si hay documentos */
		foreach ($_FILES['documentos']['tmp_name'] as $index => $tmp_name) {

			if (empty($tmp_name)) {
				continue;
			}

			$info = array(
				'name' => $_FILES['documentos']['name'][$index],
				'type' => $_FILES['documentos']['type'][$index],
				'tmp_name' => $tmp_name,
				'error' => $_FILES['documentos']['error'][$index],
				'size' => $_FILES['documentos']['size'][$index]);

			if ($info['error'] == 0) {

				$result = $this->InmueblesInfo->addDocumento($inmuebleId, $info);
				if ($result !== false) {
					$this->Documento->create();
					$this->Documento->save($result);
				} else {
					$error = 'El archivo no se ha cargado al producirse un error.';
				}

			} else {

				$errores = array(
					'1' => 'El archivo excede el tamaño máximo.',
					'2' => 'El archivo excede el tamaño máximo.',
					'3' => 'El archivo no se ha cargado completamente.',
					'4' => 'El archivo no se ha cargado.',
					'5' => 'El archivo no se ha cargado.',
					'6' => 'Error, falta la carpeta temporal.',
					'7' => 'Fallo al escribir la imagen en disco.',
					'8' => 'Extensión de archivo no soportada.');

				$cod_error = $info['error'];
				if (isset($errores[$cod_error])) {
					$error = $errores[$cod_error];
				} else {
					$error = 'El archivo no se ha cargado al producirse un error.';
				}
			}
		}

		if (isset($error)) {
			$this->setDangerFlash($error);
		}
	}

  /**
   * Subir una imagen
   * @param $inmuebleId
   */
  public function addFoto($inmuebleId) {
    $this->layout = null;
    $this->autoRender = false;
    if ($this->request->is('ajax')) {

      $fileElementName = $_POST ['file_element'];
      $fnam = $_FILES [$fileElementName] ['name'];
      $size = @filesize($_FILES [$fileElementName] ['tmp_name']);

      $error = "";
      if (!empty($_FILES [$fileElementName] ['error'])) {

        $errores = array(
          '1' => 'La foto excede el tamaño máximo.',
          '2' => 'La foto excede el tamaño máximo.',
          '3' => 'La foto ha sido tan sólo parcialmente cargada',
          '4' => 'La foto no se ha cargado.',
          '5' => 'La foto no se ha cargado.',
          '6' => 'Error, falta la carpeta temporal',
          '7' => 'Fallo al escribir la imagen en disco',
          '8' => 'La extensión de la imagen no es correcta');

        $cod_error = $_FILES [$fileElementName] ['error'];
        if (isset($errores[$cod_error])) {
          $error = $errores[$cod_error];
        } else {
          $error = 'La foto no se ha cargado.';
        }

      } elseif (empty($_FILES [$fileElementName] ['tmp_name']) || $_FILES [$fileElementName]['tmp_name'] == 'none') {

        $error = 'No se ha enviado la imagen.';

      } else {

        $result = $this->InmueblesInfo->addFoto($inmuebleId, $_FILES[$fileElementName]['tmp_name']);
        if ($result !== false) {
          $this->Imagen->create();
          $result = $this->Imagen->save($result);
        }
      }

      $res = new stdClass ();

      $res->img_id = $result['Imagen']['id'];
      $res->img_descripcion = $result['Imagen']['descripcion'];
      $res->img_inmueble_id = $result['Imagen']['inmueble_id'];
      $res->img_tipo_imagen_id = $result['Imagen']['tipo_imagen_id'];
      $res->img_fichero = $result['Imagen']['fichero'];
      $res->img_path = $result['Imagen']['path'];
      $res->img_orden = $result['Imagen']['orden'];

      $config = Configure::read('alfainmo');
      $path = $config['images.path'];

      $res->error = $error;
      $res->filename = $fnam;
      $res->path = $path;
      $res->size = sprintf("%.2fMB", $size / 1048576);
      $res->dt = date('Y-m-d H:i:s');
      echo json_encode($res);
    }
  }

	/**
	 * @param $id
	 * @param $inmuebleId
	 */
	public function delFoto($id, $inmuebleId) {
    $this->layout = null;
    $this->autoRender = false;
    if ($this->request->is('ajax')) {
      $this->layout = null;
      $image = $this->Imagen->find('first', array('conditions' => array('Imagen.id' => $id, 'Imagen.inmueble_id' => $inmuebleId)));
      if (!empty($image)) {
        if ($this->Imagen->delete($id)) {
          $this->InmueblesInfo->delFoto($image);
        }
      }
    }
  }

  /**
   * @param $idInmueble
   * @param $idsFotos
   */
  public function sortFotos($idInmueble, $idsFotos) {
    $this->layout = null;
    $this->autoRender = false;
    if ($this->request->is('ajax')) {

      $i = 1;
      foreach (explode(',', $idsFotos) as $id) {
        $this->Imagen->updateAll(
            array('Imagen.orden' => $i), array('Imagen.id' => $id, 'Imagen.inmueble_id' => $idInmueble));
        $i++;
      }
    }
  }

  /**
   * @param $idFoto
   */
  public function updFoto($idFoto) {

    $this->autoRender = false;
    $this->layout = null;
    if ($this->request->is('ajax') && $this->request->is('post')) {
      $info = array();
      foreach ($this->request->data as $id => $value) {
        $info['Imagen.' . $id] = "'$value'";
      }
      $this->Imagen->updateAll($info, array('Imagen.id' => $idFoto));
    }
  }

	/**
	 * @param $id
	 * @param $inmuebleId
	 */
	public function delDocumento($id, $inmuebleId) {
		$this->layout = null;
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$this->layout = null;
			$doc = $this->Documento->find('first', array('conditions' => array('Documento.id' => $id, 'Documento.inmueble_id' => $inmuebleId)));
			if (!empty($doc)) {
				if ($this->Documento->delete($id)) {
					$this->InmueblesInfo->delDocumento($doc);
				}
			}
		}
	}

	/**
	 * @param $id
	 * @param $inmuebleId
	 */
	public function updDocumento($id, $inmuebleId) {

		$this->autoRender = false;
		$this->layout = null;
		if ($this->request->is('ajax') && $this->request->is('post')) {
			foreach ($this->request->data as $field => $value) {
				$info['Documento.' . $field] = "'$value'";
			}

			$this->Documento->updateAll($info, array('Documento.id' => $id, 'Documento.inmueble_id' => $inmuebleId));
		}
	}

	/**
	 * @param $id
	 *
	 * @return null|string
	 */
	public function fichaEscaparate($id) {

		$this->autoRender = false;
		$this->layout = null;
		$this->response->type('application/rtf');

		$info = $this->Inmueble->find('first', array('conditions' => array('Inmueble.id' => $id), 'recursive' => 2));

		$view = new View($this, false);
		$view->set('info', $info);

		return $view->render('ficha_escaparate');
	}

	private static function getaddress($lat,$lng) {
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;

		if($status=="OK") {
			return $data->results[0]->formatted_address;
		} else {
			return false;
		}
	}

	public function leer_inmuebles($oficina=null) {

		if ($oficina == null) {
			$this->set('info_array', array());
			return;
		}

		$info_array = $this->Inmueble->find('all',
			array(
				'fields' => array(
		      'Inmueble.id',
		      'Inmueble.numero_agencia',
		      'Inmueble.codigo',
		      'Inmueble.coord_x',
		      'Inmueble.coord_y',
		      'Inmueble.poblacion',
		      'Inmueble.provincia',
					'Inmueble.codigo_postal',
					'Inmueble.nombre_calle',
					'Inmueble.numero_calle'),
				'callbacks' => false,
				'conditions' => array(
					'Inmueble.estado_inmueble_id <>' => '05',
					'Inmueble.numero_agencia' => $oficina,
					'Inmueble.motivo_baja_id IS NULL'),
				'recursive' => 1,
				'order' => 'Inmueble.id'));

		$result = array();
		foreach($info_array as &$info) {
			$codigo_postal = $info['Inmueble']['codigo_postal'];
			if (empty($codigo_postal) || empty($info['Inmueble']['coord_x']) || empty($info['Inmueble']['coord_y'])) {
				continue;
			}
			$direccion = self::getaddress($info['Inmueble']['coord_x'], $info['Inmueble']['coord_y']);

			if ($direccion === false || strpos($direccion, $info['Inmueble']['codigo_postal']) !== false) {
				continue;
			}
			$info['direccion'] = $direccion;

			$result[] = $info;
		}
		$this->set('info_array', $result);
	}

}
