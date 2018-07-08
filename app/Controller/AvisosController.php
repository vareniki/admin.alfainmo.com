<?php

/**
 * Description of IndexController
 *
 * @author dmonje
 */
class AvisosController extends AppController {

  public $helpers = array(
      'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
      'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
      'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
      'Number',
      'Text',
      'App');

  public $uses = ['SolicitudVisita'];

	function index() {

    $conditionsDst['SolicitudVisita.dst_agencia_id'] = $this->viewVars['agencia']['Agencia']['id'];
    // Pendiente
    $pendiente = $this->SolicitudVisita->find('all', [
        'fields' => ['SolicitudVisita.*', 'Inmueble.numero_agencia', 'Inmueble.codigo',  'FntAgente.nombre_contacto', 'FntAgencia.numero_agencia', 'FntAgencia.nombre_agencia'],
        'order' => 'SolicitudVisita.fecha DESC',
        'conditions' => $conditionsDst + ['SolicitudVisita.dst_respuesta_id' => 0],
        'recursive' => 1
    ]);

    $this->set('pendienteDst', $pendiente);

    // Aceptado y rechazado
    $procesado = $this->SolicitudVisita->find('all', [
        'fields' => ['SolicitudVisita.*', 'Inmueble.numero_agencia', 'Inmueble.codigo',  'FntAgente.nombre_contacto', 'FntAgencia.numero_agencia', 'FntAgencia.nombre_agencia'],
        'order' => 'SolicitudVisita.fecha DESC',
        'conditions' => $conditionsDst + ['SolicitudVisita.dst_respuesta_id > 0'],
        'recursive' => 1
    ]);

    $this->set('procesadoDst', $procesado);

    $conditionsFnt['SolicitudVisita.fnt_agencia_id'] = $this->viewVars['agencia']['Agencia']['id'];
    // Solicitudes de la propia oficina
    $propias = $this->SolicitudVisita->find('all', [
        'fields' => ['SolicitudVisita.*', 'Inmueble.numero_agencia', 'Inmueble.codigo',  'FntAgente.nombre_contacto', 'DstAgencia.nombre_agencia'],
        'order' => 'SolicitudVisita.fecha DESC',
        'conditions' => $conditionsFnt,
        'recursive' => 1
    ]);

    $this->set('propias', $propias);
	}

}
