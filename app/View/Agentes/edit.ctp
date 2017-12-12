<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view2');

$edit = (isset($info['Agente']));
if ($edit) {
  $title = 'Modificar agente ' . $info['Agente']['nombre_contacto'];
  $action = 'edit';
} else {
  $title = "Alta de agente";
  $action = 'add';
}

$hay_usr = !(empty($info['User']['id']));

$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('agentes_left');
$this->end();

$this->start('header');
?>
<script type="text/javascript">
	$(document).ready(function() {

		$("#editForm").validate({
			errorClass: 'text-danger',
			errorPlacement: function(error, element) {
				error.appendTo(element.closest('div'));
			}
		});
	});
</script>
<?php
$this->end();

echo $this->Form->create(false, array('id' => 'editForm', 'url' => $action, 'class' => 'form-horizontal aviso'));
echo $this->Form->hidden('referer');
?>
	<div id="save-buttons" class="text-right">
		<?php if ($edit):
          echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> volver al listado', '/agentes/index', array('class' => 'btn btn-default btn-sm', 'escape' => false)) . "&nbsp;";
        endif;
        echo $this->Form->submit('grabar', array('class' => 'btn btn-sm btn-primary', 'div' => false)); ?>
	</div>
<hr>
<div class="tabbable ficha">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Informaci&oacute;n</a></li>
  </ul>
  <div class="tab-content">
    <div id="tab1" class="tab-pane active">
			<?php
			echo $this->Form->hidden('Agente.id');
			echo $this->Form->hidden('User.id');
      echo $this->Form->hidden('Agente.agencia_id', array('value' => $agencia['Agencia']['id']));

			echo $this->App->horizontalInput('Agente.nombre_contacto', '<span>[*]</span> Agente:', array('maxlength' => 50, 'required' => true));
			echo $this->App->horizontalInput('Agente.email_contacto', '<span>[*]</span> EMail/usuario:', array('type' => 'email', 'maxlength' => 50, 'required' => true));

      echo $this->App->horizontalInput('User.password', '<span>[*]</span> Password:', array('maxlength' => 20, 'minlength' => 6, 'autocomplete' => 'off',
        'placeholder' => (($hay_usr) ? 'si lo desea escriba una nueva contraseña' : 'escriba una contraseña'), 'value' => '', 'required' => ($hay_usr) ? false : true));

			echo $this->App->horizontalInput('Agente.telefono1_contacto', 'Teléfono principal:', array('maxlength' => 15));
			echo $this->App->horizontalInput('Agente.telefono2_contacto', 'Teléfono 2:', array('maxlength' => 15));

			echo $this->App->horizontalSelect('Agente.pais_id', '<span>[*]</span>Pa&iacute;s:', $paises);

			echo $this->App->horizontalInput('Agente.codigo_postal', 'Código postal:', array('maxlength' => 10));
			echo $this->App->horizontalInput('Agente.poblacion', 'Población:', array('maxlength' => 50));
			echo $this->App->horizontalInput('Agente.provincia', 'Provincia:', array('maxlength' => 30));

			echo '<br>';
			echo $this->App->horizontalSelect('Agente.tipo', '<span>[*]</span> Tipo de agente:', $tipos_agente);
			echo '<br>';

			echo $this->App->horizontalTextarea('Agente.observaciones', 'Observaciones:', array('rows' => 6));
			?>
			<div class="form-group">
				<label class="control-label col-md-5 col-lg-4 col-sm-4">Estado:</label>
				<div class="col-md-7 col-lg-8 col-sm-8">
					<?php
					if ($edit) {
						echo $this->Form->checkbox('User.active', array('value' => 't', 'label' => 'activo'));
					} else {
						echo $this->Form->checkbox('User.active', array('value' => 't', 'label' => 'activo', 'checked' => true));
					}
					?>
				</div>
			</div>
    </div>
  </div>
</div>
<?php
echo $this->Form->end();
