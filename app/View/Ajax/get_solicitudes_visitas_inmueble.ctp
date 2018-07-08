<?php if (!empty($info)): ?>
	<table class='table table-bordered table-condensed table-striped'>
		<thead>
		<tr>
			<th nowrap class="text-center">Referencia</th>
			<th>Fecha</th>
			<th>Agente</th>
            <th>Comentarios</th>
            <th>Respuesta</th>
			<th>Fecha</th>
			<th class="text-center">Estado</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($info as $sol):
		    switch ($sol['SolicitudVisita']['dst_respuesta_id']) {
              case 0:
                $estado = '<span class="label label-info">PENDIENTE</span>';
                break;
              case 1:
                  $estado = '<span class="label label-success">ACEPTADA</span>';
                  break;
              case 2:
                  $estado = '<span class="label label-danger">DENEGADA</span>';
                  break;
              default:
                  $estado = '<span class="label label-default">OTRA</span>';
                  break;
            }
			?>
			<tr>
				<td class="text-center"><?php echo $sol['Inmueble']['numero_agencia'] . '/' . $sol['Inmueble']['codigo']; ?></td>
				<td><?php echo substr($sol['SolicitudVisita']['fecha'], 0, 16); ?></td>
				<td><?php if (!empty($sol['FntAgente']['nombre_contacto'])) { echo $sol['FntAgente']['nombre_contacto']; } ?></td>
                <td><?php if (!empty($sol['SolicitudVisita']['fnt_comentarios'])) { echo $sol['SolicitudVisita']['fnt_comentarios']; } ?></td>
				<td><?php if (!empty($sol['SolicitudVisita']['dst_comentarios'])) { echo $sol['SolicitudVisita']['dst_comentarios']; } ?></td>
				<td><?php if (!empty($sol['SolicitudVisita']['fecha_respuesta'])) { echo $sol['SolicitudVisita']['fecha_respuesta']; } ?></td>
                <td class="text-center"><?php echo $estado; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<p>No se han encontrado solicitudes de visitas para este inmueble</p>
<?php endif; ?>