<?php $this->start('header'); ?>
<script type='text/javascript'>
  $(document).ready(function() {
    $("#buscarPropietario_btn, #buscarPropietario2_btn").on("click", function() {
      buscador_ajax({
        action: '<?php echo $this->base; ?>/ajax/getPropietariosOficina/',
        help: 'Nombre, apellidos o tel&eacute;fono del propietario',
        title: 'Buscar propietarios'}, function(info) {
          $("#PropietarioNombreContacto").val(info.Propietario.nombre_contacto);
          $("#PropietarioEmailContacto").val(info.Propietario.email_contacto);
          $("#PropietarioTelefono1Contacto").val(info.Propietario.telefono1_contacto);
          $("#PropietarioTelefono2Contacto").val(info.Propietario.telefono2_contacto);
          $("#PropietarioPaisId").val(info.Propietario.pais_id);
		      $("#PropietarioPoblacion").val(info.Propietario.poblacion);
		      $("#PropietarioProvincia").val(info.Propietario.provincia);
		      $("#PropietarioDireccion").val(info.Propietario.direccion);
          $("#PropietarioCodigoPostal").val(info.Propietario.codigo_postal);
	        $("#PropietarioObservaciones").val(info.Propietario.observaciones);

          $("#ContactoNombreContacto").val(info.Contacto.nombre_contacto);
          $("#ContactoEmailContacto").val(info.Contacto.email_contacto);
          $("#ContactoTelefono1Contacto").val(info.Contacto.telefono1_contacto);
          $("#ContactoTelefono2Contacto").val(info.Contacto.telefono2_contacto);
	        $("#ContactoObservaciones").val(info.Contacto.observaciones);
	        $("#ContactoHorarioContactoId").val(info.Contacto.horario_contacto_id);
      });

    });

    $("#PropietarioNombreContacto, #PropietarioEmailContacto, #PropietarioTelefono1Contacto, #PropietarioTelefono2Contacto").on("change", function() {
      var id = $(this).attr("id");
      id = id.replace("Propietario", "Contacto");
      id = $("#" + id);
      
      if (id.val() == "") {
        id.val(this.value);
      }

    });
  });
</script>
<?php
$this->end();
echo $this->Form->hidden('Propietario.id');
echo $this->Form->hidden('Contacto.id');

echo '<h3 class="section">Datos de propietario</h3>';
echo $this->App->horizontalInput('Propietario.nombre_contacto', 'Propietario/s:', array('maxlength' => 50, 'click' => array('icon' => 'search', 'id' => 'buscarPropietario_btn'), 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Propietario.telefono1_contacto', 'Teléfono principal:', array('maxlength' => 30, 'click' => array('icon' => 'search', 'id' => 'buscarPropietario2_btn'), 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Propietario.telefono2_contacto', 'Teléfono 2:', array('maxlength' => 30));
echo $this->App->horizontalInput('Propietario.email_contacto', 'EMail:', array('type' => 'email', 'maxlength' => 50));

echo $this->App->horizontalInput('Propietario.dni', 'DNI:', array('maxlength' => 12));

echo $this->App->horizontalSelect('Propietario.pais_id', '<span>[*]</span>Pa&iacute;s:', $paises);

echo $this->App->horizontalInput('Propietario.codigo_postal', 'Código postal:', array('maxlength' => 10));
echo $this->App->horizontalInput('Propietario.poblacion', 'Población:', array('maxlength' => 50));
echo $this->App->horizontalInput('Propietario.provincia', 'Provincia:', array('maxlength' => 30));
echo $this->App->horizontalInput('Propietario.direccion', 'Direcci&oacute;n:', array('maxlength' => 100));

echo $this->App->horizontalTextarea('Propietario.observaciones', 'Observaciones:', array('rows' => 3));

echo '<h3 class="section">Datos de contacto</h3>';
echo $this->App->horizontalInput('Contacto.nombre_contacto', 'Contacto:', array('maxlength' => 50));
echo $this->App->horizontalInput('Contacto.telefono1_contacto', 'Teléfono principal:', array('maxlength' => 30));
echo $this->App->horizontalInput('Contacto.telefono2_contacto', 'Teléfono 2:', array('maxlength' => 30));
echo $this->App->horizontalInput('Contacto.email_contacto', 'EMail:', array('maxlength' => 50));

echo $this->App->horizontalSelect('Contacto.horario_contacto_id', 'Horario de contacto:', $horariosContacto, array('size' => 7));
echo $this->App->horizontalTextarea('Contacto.observaciones', 'Observaciones:', array('rows' => 3));
