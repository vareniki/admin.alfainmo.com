<?php

/**
 * Description of ApuntesController
 *
 * @author dmonje
 */
class HerramientasController extends AppController {

	public $helpers = array(
			'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
			'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
			'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
			'Number', 'App', 'Inmuebles');
	public $components = array('Herramientas');
	public $uses = array('Inmueble', 'Demandante', 'TipoPiso', 'TipoChalet', 'TipoOficina', 'TipoGaraje', 'TipoTerreno');

	/**
	 * @param $info
	 * @return string
	 */
	private static function getSubtipoClass($info) {
		switch ($info['Inmueble']['tipo_inmueble_id']) {
			case '01': // Piso
				$class = 'Piso';
				break;
			case '02': // Chalet/casa
				$class = 'Chalet';
				break;
			case '03': // Local
				$class = 'Local';
				break;
			case '04': // Oficina
				$class = 'Oficina';
				break;
			case '05': // Garaje
				$class = 'Garaje';
				break;
			case '06': // Terreno
				$class = 'Terreno';
				break;
			case '07': // Nave
				$class = 'Nave';
				break;
			case '08': // Otro
				$class = 'Otro';
				break;
			default:
				$class = '';

		}
		return $class;
	}

	/**
	 * @param $tipo_inmueble_id
	 * @param $subtipo_inmueble_id
	 * @return string
	 */
	private function getDemSubtipoInmueble($tipo_inmueble_id, $subtipo_inmueble_id) {

		switch ($tipo_inmueble_id) {
			case '01': // Piso
				$class = 'TipoPiso';
				$info = $this->TipoPiso->findById($subtipo_inmueble_id);
				break;
			case '02': // Chalet/casa
				$class = 'TipoChalet';
				$info = $this->TipoChalet->findById($subtipo_inmueble_id);
				break;
			case '04': // Oficina
				$class = 'TipoOficina';
				$info = $this->TipoOficina->findById($subtipo_inmueble_id);
				break;
			case '05': // Garaje
				$class = 'TipoGaraje';
				$info = $this->TipoGaraje->findById($subtipo_inmueble_id);
				break;
			case '06': // Terreno
				$class = 'TipoTerreno';
				$info = $this->TipoTerreno->findById($subtipo_inmueble_id);
				break;
		}

		$result = '';
		if (isset($class)) {
			$result = $info[$class]['description'];
		}

		return $result;
	}

	/**
	 * @param $info
	 * @return string
	 */
	private function getInmSubtipoInmueble($info) {

		switch ($info['Inmueble']['tipo_inmueble_id']) {
			case '01': // Piso
				$class = 'TipoPiso';
				$info = $this->TipoPiso->findById($info['Piso']['tipo_piso_id']);
				break;
			case '02': // Chalet/casa
				$class = 'TipoChalet';
				$info = $this->TipoChalet->findById($info['Chalet']['tipo_chalet_id']);
				break;
			case '04': // Oficina
				$class = 'TipoOficina';
				$info = $this->TipoOficina->findById($info['Oficina']['tipo_oficina_id']);
				break;
			case '05': // Garaje
				$class = 'TipoGaraje';
				$info = $this->TipoGaraje->findById($info['Garaje']['tipo_garaje_id']);
				break;
			case '06': // Terreno
				$class = 'TipoTerreno';
				$info = $this->TipoTerreno->findById($info['Terreno']['tipo_terreno_id']);
				break;
		}

		$result = '';
		if (isset($class) && isset($info[$class]['description'])) {
			$result = $info[$class]['description'];
		}

		return $result;
	}

	private function getInmueble_piso($info) {
		return array(
			'metros' => $info['Piso']['area_total_construida'],
			'habitaciones' => $info['Piso']['numero_habitaciones'],
			'bannos' => (int) $info['Piso']['numero_banos'] + (int) $info['Piso']['numero_aseos'],
			'parking' => ($info['Piso']['con_parking'] == 't') ? 'S' : '',
			'anio' => isset($info['Piso']['anio_construccion']) ? $info['Piso']['anio_construccion'] : null,
			'conservacion' => (isset($info['EstadoConservacion'])) ? $info['EstadoConservacion']['description'] : '',
			'interior' => (isset($info['InteriorExterior'])) ? $info['InteriorExterior']['description'] : '',
			'ascensor' => ((int) $info['Piso']['numero_ascensores'] > 0) ? 'S' : '',
			'certificado' => (isset($info['CalificacionEnergetica'])) ? $info['CalificacionEnergetica']['description'] : ''
		);
	}

	private function getInmueble_chalet($info) {
		return array(
			'metros' => $info['Chalet']['area_total_construida'],
			'habitaciones' => $info['Chalet']['numero_habitaciones'],
			'bannos' => (int) $info['Chalet']['numero_banos'] + (int) $info['Chalet']['numero_aseos'],
			'parking' => ($info['Chalet']['plazas_parking'] > 0) ? 'S' : '',
			'anio' => isset($info['Chalet']['anio_construccion']) ? $info['Chalet']['anio_construccion'] : null,
			'conservacion' => (isset($info['EstadoConservacion'])) ? $info['EstadoConservacion']['description'] : '',
			'interior' => (isset($info['InteriorExterior'])) ? $info['InteriorExterior']['description'] : '',
			'ascensor' => ($info['Chalet']['con_ascensor'] == 't') ? 'S' : '',
			'certificado' => (isset($info['CalificacionEnergetica'])) ? $info['CalificacionEnergetica']['description'] : ''
		);
	}

	private function getInmueble_local($info) {
		return array(
			'metros' => $info['Local']['area_total_construida'],
			'habitaciones' => '',
			'bannos' => $info['Local']['numero_aseos'],
			'parking' => ($info['Local']['plazas_parking'] > 0) ? 'S' : '',
			'anio' => isset($info['Local']['anio_construccion']) ? $info['Local']['anio_construccion'] : null,
			'conservacion' => (isset($info['EstadoConservacion'])) ? $info['EstadoConservacion']['description'] : '',
			'interior' => '',
			'ascensor' => '',
			'certificado' => (isset($info['CalificacionEnergetica'])) ? $info['CalificacionEnergetica']['description'] : ''
		);
	}

	private function getInmueble_oficina($info) {
		return array(
			'metros' => $info['Oficina']['area_total_construida'],
			'habitaciones' => $info['Oficina']['numero_habitaciones'],
			'bannos' => (int) $info['Oficina']['numero_banos'] + (int) $info['Oficina']['numero_aseos'],
			'parking' => ($info['Oficina']['plazas_parking'] > 0) ? 'S' : '',
			'anio' => isset($info['Oficina']['anio_construccion']) ? $info['Oficina']['anio_construccion'] : null,
			'conservacion' => (isset($info['EstadoConservacion'])) ? $info['EstadoConservacion']['description'] : '',
			'interior' => (isset($info['InteriorExterior'])) ? $info['InteriorExterior']['description'] : '',
			'ascensor' => ($info['Oficina']['numero_ascensores'] > 0) ? 'S' : '',
			'certificado' => (isset($info['CalificacionEnergetica'])) ? $info['CalificacionEnergetica']['description'] : ''

		);
	}

	private function getInmueble_nave($info) {
		return array(
			'metros' => $info['Nave']['area_total_construida'],
			'habitaciones' => '',
			'bannos' => $info['Nave']['numero_aseos'],
			'parking' => ($info['Nave']['plazas_parking'] > 0) ? 'S' : '',
			'anio' => isset($info['Nave']['anio_construccion']) ? $info['Nave']['anio_construccion'] : null,
			'conservacion' => (isset($info['EstadoConservacion'])) ? $info['EstadoConservacion']['description'] : '',
			'interior' => '',
			'ascensor' => '',
			'certificado' => (isset($info['CalificacionEnergetica'])) ? $info['CalificacionEnergetica']['description'] : ''

		);
	}

	private function getInmueble_garaje($info) {
		return array(
			'metros' => $info['Garaje']['area_total'],
			'habitaciones' => '',
			'bannos' => '',
			'parking' => '',
			'anio' => '',
			'conservacion' => '',
			'interior' => '',
			'ascensor' => '',
			'certificado' => ''
		);
	}

	private function getInmueble_terreno($info) {
		return array(
			'metros' => $info['Terreno']['area_total'],
			'habitaciones' => '',
			'bannos' => '',
			'parking' => '',
			'anio' => '',
			'conservacion' => '',
			'interior' => '',
			'ascensor' => '',
			'certificado' => ''
		);
	}

	private function getInmueble_otro($info) {
		return array(
			'metros' => $info['Otro']['area_total'],
			'habitaciones' => '',
			'bannos' => '',
			'parking' => '',
			'anio' => '',
			'conservacion' => '',
			'interior' => '',
			'ascensor' => '',
			'certificado' => ''
		);
	}

  public function getUrlDomibus() {
    $this->layout = null;
    $this->autoRender = false;
    if ($this->request->is('ajax')) {

      $client="alfa"; //identificador de cliente
      $shared_secret = 'sdjduvn9731$SDfsa087124ljkgas7gs87fg8g737g878js9kwk01&(%7(lsooÇ'; // Clave privada compartida. No ha de ser mandado por la URL del API
      $userid = str_pad($this->viewVars['agencia']['Agencia']['numero_agencia'], 4, '0', STR_PAD_LEFT);
      $timestamp = time(); //Toma la hora de vuestro servidor para dar una validez temporal al token
      $token = md5($userid.$shared_secret.$timestamp); //Genera el token encriptado

      $url="https://www.domibus.com/?s2_remote_auto_login=yes&c=".$client."&u=".$userid."&id=".$token."&t=".$timestamp;

      return $url;
    }
  }

	/**
	 *
	 */
	public function cre_captacion() {
		$this->set('title', 'CRE de Captaci�n');

		$agencia = $this->viewVars['agencia']['Agencia'];
		$sql = $this->Herramientas->getCreCaptacionSQL($agencia);
		$this->set('captacion', $this->Inmueble->query($sql));

		$this->view = 'cre';
	}

	/**
	 *
	 */
	public function cre_venta() {
		$this->set('title', 'CRE de Venta');

		$agencia = $this->viewVars['agencia']['Agencia'];
		$sql = $this->Herramientas->getCreVentaSQL($agencia);
		$this->set('venta', array());

		$this->view = 'cre';
	}

	/**
	 *
	 */
	public function index() {
	}

	/**
	 *
	 */
	public function publicidad() {
		$this->set('portales', Configure::read('portales'));
	}

	/**
	 *
	 */
	public function lst_inmuebles() {

		$agencia = $this->viewVars['agencia']['Agencia'];

		$fields = array(
			'Inmueble.id',
			'Inmueble.tipo_inmueble_id',
			'Inmueble.numero_agencia',
			'Inmueble.codigo',
			'Inmueble.es_venta',
			'Inmueble.es_alquiler',
			'Inmueble.es_traspaso',
			'Inmueble.es_opcion_compra',
			'Inmueble.precio_venta',
			'Inmueble.precio_alquiler',
			'Inmueble.precio_traspaso',
			'Inmueble.nombre_calle',
			'Inmueble.numero_calle',
			'Inmueble.codigo_postal',
			'Inmueble.poblacion',
			'Inmueble.provincia',
			'Inmueble.fecha_baja',
			'Inmueble.fecha_captacion',
			'Inmueble.agencia_id',
			'Inmueble.agente_id',
			'Inmueble.honor_agencia',
			'Inmueble.numero_agencia',
			'Inmueble.llaves',
			'Inmueble.estado_inmueble_id',
			'Inmueble.tipo_contrato_id',

			'Piso.area_total_construida',
			'Piso.numero_habitaciones',
			'Piso.numero_banos',
			'Piso.numero_aseos',
			'Piso.con_parking',
			'Piso.anio_construccion',
			'Piso.plazas_parking',
			'Piso.numero_ascensores',
			'Piso.tipo_piso_id',

			'Piso.estado_conservacion_id',
			'Piso.calificacion_energetica_id',
			'Piso.interior_exterior_id',

			'Chalet.area_total_construida',
			'Chalet.numero_habitaciones',
			'Chalet.numero_banos',
			'Chalet.numero_aseos',
			'Chalet.plazas_parking',
			'Chalet.anio_construccion',
			'Chalet.con_ascensor',
			'Chalet.tipo_chalet_id',

			'Chalet.estado_conservacion_id',
			'Chalet.calificacion_energetica_id',

			'Local.area_total_construida',
			'Local.numero_aseos',
			'Local.plazas_parking',
			'Local.anio_construccion',

			'Local.estado_conservacion_id',
			'Local.calificacion_energetica_id',

			'Nave.area_total_construida',
			'Nave.numero_aseos',
			'Nave.plazas_parking',
			'Nave.anio_construccion',

			'Nave.estado_conservacion_id',
			'Nave.calificacion_energetica_id',

			'Oficina.area_total_construida',
			'Oficina.numero_habitaciones',
			'Oficina.numero_banos',
			'Oficina.numero_aseos',
			'Oficina.numero_ascensores',
			'Oficina.plazas_parking',
			'Oficina.anio_construccion',
			'Oficina.tipo_oficina_id',

			'Oficina.estado_conservacion_id',
			'Oficina.calificacion_energetica_id',
			'Oficina.interior_exterior_id',

			'Garaje.tipo_garaje_id',
			'Garaje.area_total',

			'Terreno.tipo_terreno_id',
			'Terreno.area_total',

			'Otro.area_total',

			'TipoInmueble.id',
			'TipoInmueble.description',
			'EstadoInmueble.id',
			'EstadoInmueble.description',
			'Inmueble.zona',

			'Propietario.nombre_contacto',
			'Propietario.telefono1_contacto'
		);

		$inmuebles = $this->Inmueble->find('all', array(
			'fields' => $fields,
			'conditions' => array(
				'Inmueble.agencia_id' => $agencia['id'],
				'Inmueble.fecha_baja' => null),
			'recursive' => 1,
			'callbacks' => false
		));

		foreach ($inmuebles as $inm) {

			$subtipoClass = self::getSubtipoClass($inm);

			if (empty($subtipoClass)) {
				continue;
			}

			// Precio
			$precio_venta = ($inm['Inmueble']['es_venta'] == 't') ? $inm['Inmueble']['precio_venta'] : '';
			$precio_alq = ($inm['Inmueble']['es_alquiler'] == 't') ? $inm['Inmueble']['precio_alquiler'] : '';

			// Direcci�n
			if (!empty($inm['Inmueble']['nombre_calle']) && !empty($inm['Inmueble']['codigo_postal'])) {
				$direccion = $inm['Inmueble']['nombre_calle'] . ' ' . $inm['Inmueble']['numero_calle'] .
					' C.P.' . $inm['Inmueble']['codigo_postal'] . ' - ' .	$inm['Inmueble']['poblacion'] . ' (' . $inm['Inmueble']['provincia'] . ')';
			} else {
				$direccion = '';
			}

			// Portales
			$portales = '';
			if (!empty($inm['Portal'])) {
				foreach ($inm['Portal'] as $portal) {
					$portales[] = $portal['description'];
				}
				$portales = implode(', ', $portales);
			}

			$getInmuebleInfo = 'getInmueble_' . strtolower($subtipoClass);
			$info = $this->{$getInmuebleInfo}($inm);

			$info = array(
				$inm['Inmueble']['numero_agencia'] . '/' . $inm['Inmueble']['codigo'],
				$inm['TipoInmueble']['description'],
				$this->getInmSubtipoInmueble($inm),
				$precio_venta,
				$precio_alq,
				$direccion,
				$inm['Inmueble']['zona'],
				$info['metros'],
				$info['habitaciones'],
				$info['bannos'],
				$info['parking'],
				$info['anio'],
				$info['conservacion'],
				$info['interior'],
				$info['ascensor'],
				$info['certificado'],
				$inm['Propietario']['nombre_contacto'],
				$inm['Propietario']['telefono1_contacto'],
				(isset($inm['Agente']['nombre_contacto'])) ? $inm['Agente']['nombre_contacto'] : '',
				$inm['EstadoInmueble']['description'],
				$inm['Inmueble']['fecha_captacion'],
				$inm['Inmueble']['fecha_baja'],
				(isset($inm['TipoContrato']['description'])) ? $inm['TipoContrato']['description'] : '',
				$inm['Inmueble']['honor_agencia'],
				$inm['Inmueble']['numero_agencia'],
				$inm['Inmueble']['llaves'],
				$portales
			);

			foreach ($info as $key => $value) {
				$info[$key] = utf8_decode($value);
			}

			$data[] = $info;
		}

		$_serialize = 'data';
		$_header = array('Referencia', 'Tipo', 'Subtipo', 'Precio venta', 'Precio alquiler', 'Direcci�n', 'Zona', 'M Construidos',
			'Habitaciones',	'Ba�os',	'Parking', 'A�o de construcci�n',	'Estado de conservaci�n',	'Interior/exterior',
			'Ascensor',	'Certificado energetico',	'Propietario', 'm�vil',	'Agente',	'Estado',	'Fecha de captacion',
			'Fecha de baja', 'Tipo de encargo',	'Honorarios', 'Oficina', 'Llaves', 'Portales');

		$this->viewClass = 'CsvView.Csv';
		$this->response->download('listado de inmuebles.csv');
		$this->set(compact('data', '_serialize', '_header'));
	}

	/**
	 *
	 */
	public function lst_demandantes() {
		$agencia = $this->viewVars['agencia']['Agencia'];

		$demandantes = $this->Demandante->find('all', array(
			'conditions' => array('Demandante.agencia_id' => $agencia['id']),
			'recursive' => 2
		));

		$data = array();

		foreach ($demandantes as $dem) {
			$info = array(
				$dem['Demandante']['referencia'],
				$dem['Demandante']['nombre_contacto'],
				$dem['Demandante']['telefono1_contacto'] . ((!empty($dem['Demandante']['telefono2_contacto'])) ? ' / ' . $dem['Demandante']['telefono2_contacto'] : ''),
				($dem['Agente']['nombre_contacto'] != null) ? $dem['Agente']['nombre_contacto'] : '',
				(!empty($dem['Demanda']['TipoInmueble'])) ? $dem['Demanda']['TipoInmueble']['description'] : '',
				(!empty($dem['Demanda']['subtipo'])) ? $this->getDemSubtipoInmueble($dem['Demanda']['tipo'], $dem['Demanda']['subtipo']) : '',
				(!empty($dem['Demanda']['operacion'])) ? $dem['Demanda']['operacion'] : '',
				(!empty($dem['Demanda']['precio'])) ? $dem['Demanda']['precio'] : '',
				(!empty($dem['Demanda']['habitaciones'])) ? $dem['Demanda']['habitaciones'] : '',
				(!empty($dem['Demanda']['banos'])) ? $dem['Demanda']['banos'] : '',
				($dem['Demanda']['con_garaje'] == 't') ? 'S':'',
				($dem['Demanda']['con_ascensor'] == 't') ? 'S':'',
				$dem['Demanda']['zona']
			);

			foreach ($info as $key => $value) {
				$info[$key] = utf8_decode($value);
			}

			$data[] = $info;
		}

		$_serialize = 'data';
		$_header = array('Referencia', 'Demandante', 'M�vil', 'Agente', 'Tipo', 'Subtipo',
			'Operaci�n', 'Precio minimo', 'Habitaciones min', 'Ba�os Min', 'Parking', 'Ascensor', 'Zona');

		$this->viewClass = 'CsvView.Csv';
		$this->response->download('listado de demandantes.csv');
		$this->set(compact('data', '_serialize', '_header'));
	}

}
