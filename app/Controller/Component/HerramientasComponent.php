<?php

App::uses('SessionComponent', 'Controller');

class HerramientasComponent extends SessionComponent {

	public function getCreCaptacionSQL($agencia) {

		$agencia_id = $agencia['id'];
		
		$sql = "SELECT a.numero_agencia, i.codigo, a.numero_agencia || '/' || i.codigo AS referencia, a.nombre_agencia," .
				"ag.nombre_contacto AS nombre_agente," .
				"i.created as fecha_alta,	ei.description AS estado_inmueble, i.fecha_captacion,	ec.description AS estado_conservacion," .
				"mb.description AS motivo_baja,	COALESCE(e07.inmueble_id, 0) AS carta_agradecimiento, COALESCE(e08.inmueble_id, 0) AS dossier," . 
				"COALESCE(e06.inmueble_id, 0) AS visita_propietario_oficina,	COALESCE(e25.inmueble_id, 0) AS visita_comprador_oficina," .
				"COALESCE(e10_1.numero, 0) AS total_visitas_propias,	COALESCE(e10_2.numero, 0) AS total_visitas_ajenas," .

				"COALESCE(e14_1.ultima_fecha, null) AS ultimo_informe_gestion,	COALESCE(e14_2.numero, 0) AS total_informes_gestion," .

				"COALESCE(e23.numero, 0) AS llamadas_emitidas,	COALESCE(e24.numero, 0) AS llamadas_recibidas" .

				" FROM inmuebles i join agencias a on i.agencia_id = a.id" .
				"	JOIN taux_estados_inmueble ei on i.estado_inmueble_id = ei.id" .
				" LEFT JOIN pisos p ON p.inmueble_id = i.id" .
				" LEFT JOIN chalets c ON c.inmueble_id = i.id" .
				" LEFT JOIN taux_estados_conservacion AS ec ON p.estado_conservacion_id = ec.id OR c.estado_conservacion_id = ec.id" .
				" LEFT JOIN taux_motivos_baja mb on i.motivo_baja_id = mb.id" .
				" LEFT JOIN agentes ag ON i.agente_id = ag.id" .
				"	LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='07' AND agencia_id=$agencia_id GROUP BY inmueble_id) e07 ON e07.inmueble_id = i.id" .
				" LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='08' AND agencia_id=$agencia_id GROUP BY inmueble_id) e08 ON e08.inmueble_id = i.id" .
				" LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='06' AND agencia_id=$agencia_id GROUP BY inmueble_id) e06 ON e06.inmueble_id = i.id" .
				" LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='25' AND agencia_id=$agencia_id GROUP BY inmueble_id) e25 ON e25.inmueble_id = i.id" .

				" LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='10' AND agencia_id=$agencia_id GROUP BY inmueble_id) e10_1 ON e10_1.inmueble_id = i.id" .
				" LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='10' AND agencia_id<>$agencia_id GROUP BY inmueble_id) e10_2 ON e10_2.inmueble_id = i.id" .

				" LEFT JOIN (select inmueble_id, MAX(fecha) AS ultima_fecha from eventos WHERE tipo_evento_id='14' AND agencia_id=$agencia_id GROUP BY inmueble_id) e14_1 ON e14_1.inmueble_id = i.id" .
				" LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='14' AND agencia_id=$agencia_id GROUP BY inmueble_id) e14_2 ON e14_2.inmueble_id = i.id" .

				" LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='23' AND agencia_id=$agencia_id GROUP BY inmueble_id) e23 ON e23.inmueble_id = i.id" .
				" LEFT JOIN (select inmueble_id, COUNT(*) AS numero from eventos WHERE tipo_evento_id='24' AND agencia_id=$agencia_id GROUP BY inmueble_id) e24 ON e24.inmueble_id = i.id" .
			  " WHERE i.agencia_id=$agencia_id AND i.created IS NOT NULL" .
				" ORDER BY a.numero_agencia, i.codigo";

		return $sql;
	}

	public function getCreVentaSQL($agencia) {

	}

}
