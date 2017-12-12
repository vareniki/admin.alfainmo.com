<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view1');

$title = 'Modificar propietario ' . $info['Inmueble']['referencia'] . ' - ' . $info['Propietario']['nombre_contacto'];
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('propietarios_left');
$this->end();

$this->start('header');
?>
<script type="text/javascript">
  $(document).ready(function() {

    $("#addForm").validate({
      errorClass: 'text-danger',
      errorPlacement: function(error, element) {
        error.appendTo(element.closest('div'));
      }
    });
  });
</script>
<?php
$this->end();

$url_64 = $this->data['referer'];

echo $this->Form->create(false, array('id' => 'editForm', 'url' => 'edit', 'class' => 'form-horizontal aviso'));
echo $this->Form->hidden('referer');
?>
	<div id="save-buttons" class="text-right">
		<a href="<?php echo base64_decode($url_64) ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-list"></i> volver al listado</a>
		<?php echo $this->Form->submit('grabar', array('class' => 'btn btn-sm btn-primary', 'div' => false)); ?>
	</div>
<hr>
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Informaci&oacute;n</a></li>
  </ul>
  <div class="tab-content">
    <div id="tab1" class="tab-pane active">
      <?php
      echo $this->Form->hidden('Propietario.id');
      echo $this->Form->hidden('Contacto.id');
      echo $this->Form->hidden('Propietario.agencia_id', array('value' => $agencia['Agencia']['id']));

      echo $this->App->horizontalInput('Inmueble.referencia', 'Referencia inmueble:', array('readonly' => 'readonly'));
      echo $this->App->horizontalInput('Propietario.nombre_contacto', 'Propietario/s:', array('maxlength' => 50));
      echo $this->App->horizontalInput('Propietario.email_contacto', 'EMail:', array('type' => 'email', 'maxlength' => 50));
      echo $this->App->horizontalInput('Propietario.telefono1_contacto', '<span>[*]</span> Teléfono principal:', array('maxlength' => 15, 'required' => 'required'));
      echo $this->App->horizontalInput('Propietario.telefono2_contacto', 'Teléfono 2:', array('maxlength' => 15));
      echo $this->App->horizontalInput('Propietario.dni', 'DNI:', array('maxlength' => 15));

      echo $this->App->horizontalSelect('Propietario.pais_id', '<span>[*]</span>Pa&iacute;s:', $paises);
      echo $this->App->horizontalInput('Propietario.codigo_postal', 'Código postal:', array('maxlength' => 10));
      echo $this->App->horizontalInput('Propietario.poblacion', 'Población:', array('maxlength' => 50));
      echo $this->App->horizontalInput('Propietario.provincia', 'Provincia:', array('maxlength' => 30));
      echo $this->App->horizontalInput('Propietario.direccion', 'Calle:', array('maxlength' => 100));

      echo $this->App->horizontalTextarea('Propietario.observaciones', 'Observaciones:', array('rows' => 6));

      echo '<h3 class="section">Datos de contacto</h3>';
      echo $this->App->horizontalInput('Contacto.nombre_contacto', 'Contacto:', array('maxlength' => 50));
      echo $this->App->horizontalInput('Contacto.telefono1_contacto', 'Teléfono principal:', array('maxlength' => 15));
      echo $this->App->horizontalInput('Contacto.telefono2_contacto', 'Teléfono 2:', array('maxlength' => 30));
      echo $this->App->horizontalInput('Contacto.email_contacto', 'EMail:', array('maxlength' => 50));

      echo $this->App->horizontalTextarea('Propietario.direccion_completa', 'Direcci&oacute;n completa:', array('rows' => 6));

      echo $this->App->horizontalSelect('Contacto.horario_contacto_id', 'Horario de contacto:', $horariosContacto, array('size' => 7));
      echo $this->App->horizontalTextarea('Contacto.observaciones', 'Observaciones:', array('rows' => 3));
      ?>
    </div>
  </div>
</div>
<?php
echo $this->Form->end();
