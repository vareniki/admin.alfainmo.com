<?php

App::uses('SessionComponent', 'Controller');

class AgenciasInfoComponent extends SessionComponent {

  public function crearBusqueda($request) {
    /**
     *  operacion, texto
     */
    $conditions = array();

    if (!empty($request['q'])) {
      $qs = explode(' ', strtolower($request['q']));
      foreach ($qs as $q) {
        $q = str_replace("'", "''", trim($q));

        $subcond = array();
	      if ((int) $q > 0 && (int) $q < 99999) {
		      $conditions['Agencia.numero_agencia'] = (int) $q;
	      } else {
		      $subcond[]['Agencia.nombre_agencia ILIKE'] = "%$q%";
		      $subcond[]['Agencia.poblacion ILIKE'] = "%$q%";
		      $subcond[]['Agencia.provincia ILIKE'] = "%$q%";
		      $subcond[]['Agencia.telefono1_contacto ILIKE'] = "%$q%";
		      $subcond[]["Agencia.observaciones ILIKE"] = "%$q%";
		      $conditions[]['OR'] = $subcond;
	      }

      }
    }

	  if (!isset($request['solo_central'])) {
		  $subcond = array();
		  $subcond[] = 'Agencia.solo_central is null';
		  $subcond[] = "Agencia.solo_central <> 't'";

		  $conditions[]['AND'] = array('OR' => $subcond);
	  }

    if (!isset($request['inc_bajas'])) {
      $conditions[]['AND'] = array('Agencia.active' => 't');
    }

    return $conditions;
  }

}
