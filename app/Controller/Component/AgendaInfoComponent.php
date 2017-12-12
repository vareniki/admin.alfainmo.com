<?php

App::uses('SessionComponent', 'Controller');

class AgendaInfoComponent extends SessionComponent {

	/**
	 * @param $request
	 *
	 * @return array
	 */
	public function crearBusqueda($request) {
    /**
     *  operacion, texto
     */
    $conditions = array();

    if (!empty($request['q'])) {
	    $q = str_replace("'", "''", trim($request['q']));
      $conditions['Evento.texto ILIKE'] = "%$q%";
    }

		if (!empty($request['tipo_evento_id'])) {
			$conditions['Evento.tipo_evento_id'] = $request['tipo_evento_id'];
		}

		if (!empty($request['agente_id'])) {
			$conditions['Evento.agente_id'] = $request['agente_id'];
		}

		if (!empty($request['desde'])) {
			$conditions['Evento.fecha >='] = $request['desde'];
		}

		if (!empty($request['hasta'])) {
			$conditions['Evento.fecha <='] = $request['hasta'] . ' 23:59:59';
		}

		if (isset($request['estado'])) {
			$conditions['Evento.estado'] = $request['estado'];
		} else {
			$conditions['Evento.estado'] = 0;
		}

		$conditions[] = 'TipoEvento.type IN (1,2)';

    return $conditions;
  }

	/**
	 * @param $profile
	 * @param $inmueble
	 * @param $agencia
	 * @param $agente
	 * @return bool
	 */
	public function canEdit($profile, $inmueble, $agencia, $agente) {

		if ($profile['is_consultor']) {
			return false;
		}

		if ($profile['is_central']) {
			return true;
		}

		if (($profile['is_agencia'] || $profile['is_coordinador']) && $agencia['Agencia']['id'] == $inmueble['Inmueble']['agencia_id']) {
			return true;
		}

		if ($profile['is_agente'] && $agente['Agente']['id'] == $inmueble['Inmueble']['agente_id']) {
			return true;
		}
		return false;
	}

}
