<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view2');

$edit = (isset($info['Agencia']));

if ($edit) {
  $title = 'Modificar agencia ' . $info['Agencia']['numero_agencia'] . ' - ' . $info['Agencia']['nombre_agencia'];
  $action = 'edit';
} else {
  $title = "Alta de agencia";
  $action = 'add';
}

$hay_usr = !(empty($info['User']['id']));

$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('agencias_left');
$this->end();

$this->start('header');
?>
<script type="text/javascript">

  /**
   *
   */
	function actualizarPoblaciones(provId) {

	  var $poblacionId = $("#AgenciaPoblacionId");

	  $poblacionId.html('<option value="">(seleccionar población)</option>');
		$.ajax("<?php echo $this->base; ?>/ajax/getPoblacionesProvincia/" + provId, {
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, obj) {
					$poblacionId.append('<option value="' + obj.id + '">' + obj.description + '</option>');
				});
			}
		});
	}

	$(document).ready(function() {

		$("#editForm").validate({
			errorClass: 'text-danger', errorPlacement: function(error, element) { error.appendTo(element.closest('div')); }
		});

		$("#AgenciaCodigoPostal").on("change", function() {
			actualizarPoblaciones(this.value.substr(0, 2));
		});
	});
</script>
<?php
$this->end();

echo $this->Form->create(false, array('id' => 'editForm', 'url' => $action, 'class' => 'form-horizontal aviso'));
?>
	<div id="save-buttons" class="text-right">
      <?php if ($edit):
        echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> volver al listado', '/agencias/index', array('class' => 'btn btn-default btn-sm', 'escape' => false)) . "&nbsp;";
      endif;
      echo $this->Form->submit('grabar', array('class' => 'btn btn-sm btn-primary', 'div' => false)); ?>
	</div>
	<hr>
<?php
echo $this->Form->hidden('Agencia.id');
echo $this->Form->hidden('User.id');
echo $this->Form->hidden('User.active');

echo $this->App->horizontalInput('Agencia.nombre_agencia', '<span>[*]</span> Nombre de la agencia:', array('maxlength' => 50, 'required' => true));
echo $this->App->horizontalInput('Agencia.nombre_fiscal', '<span>[*]</span> Nombre fiscal:', array('maxlength' => 80, 'required' => true));
echo $this->App->horizontalInput('Agencia.cif', '<span>[*]</span> CIF:', array('maxlength' => 12, 'required' => true));
echo $this->App->horizontalInput('Agencia.numero_agencia', '<span>[*]</span> Número de la agencia:', array('type' => 'number', 'required' => $edit, 'readonly' => $edit));
echo $this->App->horizontalInput('User.username', '<span>[*]</span> Usuario:', array('minlength' => 4, 'maxlength' => 30, 'required' => true, 'readonly' => $hay_usr));

echo $this->App->horizontalInput('User.password', '<span>[*]</span> Password:', array('maxlength' => 20, 'minlength' => 6, 'autocomplete' => 'off',
        'placeholder' => (($hay_usr) ? 'si lo desea escriba una nueva contraseña' : 'escriba una contraseña'), 'value' => '', 'required' => ($hay_usr) ? false : true));

echo $this->App->horizontalSelect('Agencia.pais_id', '<span>[*]</span> Pa&iacute;s:', $paises);
echo $this->App->horizontalInput('Agencia.web', '<span>[*]</span> Web', array('maxlength' => 64, 'required' => true));

echo $this->App->horizontalInput('Agencia.telefono1_contacto', '<span>[*]</span> Teléfono principal:', array('maxlength' => 15, 'required' => true));
echo $this->App->horizontalInput('Agencia.telefono2_contacto', 'Teléfono 2:', array('maxlength' => 15));

echo $this->App->horizontalInput('Agencia.codigo_postal', '<span>[*]</span> Código postal:', array('maxlength' => 10, 'required' => true));
echo $this->App->horizontalInput('Agencia.poblacion', '<span>[*]</span> Población:', array('maxlength' => 50, 'required' => true));
echo $this->App->horizontalInput('Agencia.provincia', '<span>[*]</span> Provincia:', array('maxlength' => 30, 'required' => true));
echo $this->App->horizontalInput('Agencia.nombre_calle', 'Nombre de calle / vía:', array('maxlength' => 100));
echo $this->App->horizontalInput('Agencia.numero_calle', 'Número:', array('maxlength' => 32));
echo '<hr>';
echo $this->App->horizontalInput('Agencia.coord_x', 'Latitud:');
echo $this->App->horizontalInput('Agencia.coord_y', 'Longitud:');
echo '<hr>';
echo $this->App->horizontalInput('Agencia.nombre_contacto', '<span>[*]</span> Nombre del contacto:', array('maxlength' => 50, 'required' => true));
echo $this->App->horizontalInput('Agencia.email_contacto', '<span>[*]</span> EMail:', array('type' => 'email', 'maxlength' => 50, 'required' => true));
echo $this->App->horizontalInput('Agencia.email_gdpr', 'EMail GDPR:', array('type' => 'email', 'maxlength' => 50));

echo '<hr>';
echo '<p><small>S&oacute;lo a efectos de la compatibilidad con la antigua Web</small></p>';
echo $this->App->horizontalSelect('Agencia.poblacion_id', 'Población:', $poblaciones_ids);
echo '<hr>';

echo $this->App->horizontalTextarea('Agencia.observaciones', 'Observaciones:', array('rows' => 6));
?>
<div class="form-group">
	<label class="control-label col-md-5 col-lg-4 col-sm-4">Estado:</label>
	<div class="col-md-7 col-lg-8 col-sm-8">
		<?php
      if ($edit) {
        echo $this->Form->checkbox('Agencia.active', array('value' => 't', 'label' => 'activo'));
      } else {
        echo $this->Form->checkbox('Agencia.active', array('value' => 't', 'label' => 'activo', 'checked' => true));
      }
    ?>
	</div>
</div>

<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">S&oacute;lo central:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    if ($edit) {
	    echo $this->Form->checkbox('Agencia.solo_central', array('value' => 't', 'label' => 'sí'));
    } else {
	    echo $this->Form->checkbox('Agencia.solo_central', array('value' => 't', 'label' => 'sí', 'checked' => false));
    }
    ?>
  </div>
</div>
    <div class="form-group">
        <label class="control-label col-md-5 col-lg-4 col-sm-4">Central en Web:</label>
        <div class="col-md-7 col-lg-8 col-sm-8">
          <?php
          if ($edit) {
            echo $this->Form->checkbox('Agencia.central_web', array('value' => 't', 'label' => 'sí'));
          } else {
            echo $this->Form->checkbox('Agencia.central_web', array('value' => 't', 'label' => 'sí', 'checked' => false));
          }
          ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-5 col-lg-4 col-sm-4">Parvenca:</label>
        <div class="col-md-7 col-lg-8 col-sm-8">
          <?php
          if ($edit) {
            echo $this->Form->checkbox('Agencia.parvenca', array('value' => 't', 'label' => 'activo'));
          } else {
            echo $this->Form->checkbox('Agencia.parvenca', array('value' => 't', 'label' => 'activo', 'checked' => true));
          }
          ?>
        </div>
    </div>

<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varios portales.</em></p></div>
</div>
<?php echo $this->App->horizontalSelect('Agencia.Portal', 'Excluir:', $portales, array('multiple' => 'multiple', 'size' => 9));
echo $this->Form->end();
