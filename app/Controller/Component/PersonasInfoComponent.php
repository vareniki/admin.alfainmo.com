<?php

App::uses('SessionComponent', 'Controller');

class PersonasInfoComponent extends SessionComponent {

	/**
	 * @param $request
	 * @param $modelo
	 * @return array
	 */
	public function crearBusqueda($request, $modelo) {
    /**
     *  operacion, texto
     */
    $conditions = array();

    if (!empty($request['q'])) {
      $qs = explode(' ', strtolower($request['q']));
      foreach ($qs as $q) {
        $q = trim($q);
        if (strlen($q) < 3) {
          continue;
        }
	      $q = str_replace("'", "''", $q);


        if (strpos($q, '/') !== false) {
          $ref = explode('/', $q);
          if (count($ref) >= 2) {

            switch ($modelo) {
              case 'Propietario':
                $conditions[] = array('Inmueble.numero_agencia' => (int) $ref[0], 'Inmueble.codigo' => (int) $ref[1]);
                break;
              case 'Demandante':
                $conditions[] = array('Demandante.numero_agencia' => (int) $ref[0], 'Demandante.codigo' => (int) $ref[1]);
                break;
            }
          }
          continue;
        }

        $subcond = array();
        $subcond[]["$modelo.nombre_contacto ILIKE"] = "%$q%";
        $subcond[]["$modelo.poblacion ILIKE"] = "%$q%";
        $subcond[]["$modelo.provincia ILIKE"] = "%$q%";
        $subcond[]["$modelo.telefono1_contacto ILIKE"] = "%$q%";
        $subcond[]["$modelo.telefono2_contacto ILIKE"] = "%$q%";
        $subcond[]["$modelo.observaciones ILIKE"] = "%$q%";

	      if ($modelo == 'Demandante') {
		      $subcond[]["Agente.nombre_contacto ILIKE"] = "%$q%";
	      }

        $conditions[]['OR'] = $subcond;
      }
    }

		if (!empty($request['clasificacion'])) {
			$conditions['clasificacion_demandante_id'] = $request['clasificacion'];
		}

    if (!isset($request['inc_bajas'])) {
      switch ($modelo) {
        case 'Agente':
          $conditions[]['AND'] = array('User.active' => 't');
          break;
        case 'Propietario':
          $conditions[]['AND'] = array('Inmueble.fecha_baja IS NULL');
          break;
        case 'Demandante':
          $conditions[]['AND'] = array('Demandante.fecha_baja IS NULL');
          break;
      }
    }

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
