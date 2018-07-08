<?php
$this->set('title_for_layout', __d('alfainmo_es', 'Avisos'));
// app/View/Inmuebles/pdf.ctp
$this->extend('/Common/view1');

$title = "Avisos";
$this->set('title_for_layout', $title);

//$this->start('sidebar');
//echo $this->element('common/main_left');
//$this->end();

$this->start('header');

function getLabelRespuestaId($respuestaId) {
  switch ($respuestaId) {
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
  return $estado;
}
?>
    <style type="text/css">
        input[type=text] { border: 1px solid #CCC; border-radius: 3px; padding: 2px 8px; width: 100% }
        select { border: 1px solid #CCC; border-radius: 3px; width: 100%; height: 23px; }
        ::placeholder { color: #CCC; }
    </style>
    <script type='text/javascript'>

	$(document).ready(function() {
	    $(".pendienteDst").ajaxForm({

            beforeSerialize: function($form, options) {
                var $pendienteDst = $form.closest(".pendienteDst");
                var respuestaId = $("select[name='respuesta_id']", $pendienteDst).val();
                var comentarios = $("input[name='comentarios']", $pendienteDst).val();

                if (respuestaId < 1 || comentarios == '') {
                    alert("Debe escribir una respuesta y/o aceptar o rechazar la consulta.");
                    return false;
                }

                $("input[name='dst_respuesta_id']", $form).val(respuestaId);
                $("input[name='dst_comentarios']", $form).val(comentarios);
            },

            success: function() {
                alert("Respuesta enviada.");
                location.reload();
            }
        });

	});

</script>
<?php $this->end(); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Solicitudes de otras agencias sobre mis inmuebles</h3>
    </div>
    <div class="panel-body">

      <?php if (!empty($pendienteDst)): ?>
          <h5 class="text-center" style="text-transform: uppercase">Solicitudes pendientes de responder</h5>
          <table class='table table-bordered table-condensed table-striped'>
              <thead>
              <tr>
                  <th nowrap class="text-center">Referencia</th>
                  <th>Fecha de solicitud</th>
                  <th>Agencia</th>
                  <th>Agente</th>
                  <th>Comentarios</th>
                  <th>Respuesta</th>
                  <th class="text-center">Estado</th>
                  <th></th>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($pendienteDst as $sol): ?>
                  <tr class="pendienteDst">
                      <td class="text-center"><?php echo $sol['Inmueble']['numero_agencia'] . '/' . $sol['Inmueble']['codigo']; ?></td>
                      <td><?php echo substr($sol['SolicitudVisita']['fecha'], 0, 16); ?></td>
                      <td><?php echo $sol['FntAgencia']['nombre_agencia']; ?></td>
                      <td><?php if (!empty($sol['FntAgente']['nombre_contacto'])) { echo $sol['FntAgente']['nombre_contacto']; } ?></td>
                      <td><?php if (!empty($sol['SolicitudVisita']['fnt_comentarios'])) { echo $sol['SolicitudVisita']['fnt_comentarios']; } ?></td>
                      <td><input type="text" name="comentarios" value="" placeholder="respuesta" maxlength="50"></td>
                      <td class="text-center"><select name="respuesta_id"><option value="0">(pendiente)</option><option value="1">aceptada</option><option value="2">rechazada</option></select></td>
                      <td class="text-center">
                          <form id="pendienteForm_<?php echo $sol['SolicitudVisita']['id'] ?>" class="pendienteForm" action="<?php echo $this->base; ?>/ajax/responderSolicitud">
                              <input type="hidden" name="id" value="<?php echo $sol['SolicitudVisita']['id'] ?>">
                              <input type="hidden" name="dst_comentarios" value="">
                              <input type="hidden" name="dst_respuesta_id" value="">
                            <input type="submit" class="btn btn-default btn-xs" value="Responder">
                          </form>
                      </td>
                  </tr>
              <?php endforeach; ?>
              </tbody>
          </table>
      <?php else: ?>
          <p class="text-center">No se han encontrado solicitudes pendientes de aceptar visitas.</p>
      <?php endif; ?>

      <?php if (!empty($procesadoDst)): ?>
          <h5 class="text-center" style="text-transform: uppercase">Solicitudes respondidas</h5>
          <table class='table table-bordered table-condensed table-striped'>
              <thead>
              <tr>
                  <th nowrap class="text-center">Referencia</th>
                  <th>Fecha</th>
                  <th>Agencia</th>
                  <th>Agente</th>
                  <th>Comentarios</th>
                  <th>Respuesta</th>
                  <th>Fecha</th>
                  <th class="text-center">Estado</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($procesadoDst as $sol): ?>
                  <tr>
                      <td class="text-center"><?php echo $sol['Inmueble']['numero_agencia'] . '/' . $sol['Inmueble']['codigo']; ?></td>
                      <td><?php echo substr($sol['SolicitudVisita']['fecha'], 0, 16); ?></td>
                      <td><?php echo $sol['FntAgencia']['nombre_agencia']; ?></td>
                      <td><?php if (!empty($sol['FntAgente']['nombre_contacto'])) { echo $sol['FntAgente']['nombre_contacto']; } ?></td>
                      <td><?php if (!empty($sol['SolicitudVisita']['fnt_comentarios'])) { echo $sol['SolicitudVisita']['fnt_comentarios']; } ?></td>
                      <td><?php if (!empty($sol['SolicitudVisita']['dst_comentarios'])) { echo $sol['SolicitudVisita']['dst_comentarios']; } ?></td>
                      <td><?php if (!empty($sol['SolicitudVisita']['fecha_respuesta'])) { echo $sol['SolicitudVisita']['fecha_respuesta']; } ?></td>
                      <td class="text-center"><?php echo getLabelRespuestaId($sol['SolicitudVisita']['dst_respuesta_id']); ?></td>
                  </tr>
              <?php endforeach; ?>
              </tbody>
          </table>
      <?php endif; ?>

    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Solicitudes realizadas a otras agencias</h3>
    </div>
    <div class="panel-body">

        <table class='table table-bordered table-condensed table-striped'>
            <thead>
            <tr>
                <th nowrap class="text-center">Referencia</th>
                <th>Fecha de solicitud</th>
                <th>Agencia</th>
                <th>Agente</th>
                <th>Comentarios</th>
                <th>Respuesta</th>
                <th>Fecha de respuesta</th>
                <th class="text-center">Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($propias as $sol): ?>
                <tr>
                    <td class="text-center"><?php echo $sol['Inmueble']['numero_agencia'] . '/' . $sol['Inmueble']['codigo']; ?></td>
                    <td><?php echo substr($sol['SolicitudVisita']['fecha'], 0, 16); ?></td>
                    <td><?php echo $sol['DstAgencia']['nombre_agencia']; ?></td>
                    <td><?php if (!empty($sol['FntAgente']['nombre_contacto'])) { echo $sol['FntAgente']['nombre_contacto']; } ?></td>
                    <td><?php if (!empty($sol['SolicitudVisita']['fnt_comentarios'])) { echo $sol['SolicitudVisita']['fnt_comentarios']; } ?></td>
                    <td><?php if (!empty($sol['SolicitudVisita']['dst_comentarios'])) { echo $sol['SolicitudVisita']['dst_comentarios']; } ?></td>
                    <td><?php if (!empty($sol['SolicitudVisita']['fecha_respuesta'])) { echo $sol['SolicitudVisita']['fecha_respuesta']; } ?></td>
                    <td class="text-center"><?php echo getLabelRespuestaId($sol['SolicitudVisita']['dst_respuesta_id']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>



    </div>
</div>
