<?php
$this->start('header');
?>
  <script type="text/javascript">

    $(document).ready(function () {
      $("#registrales input").attr("disabled", $("#InmuebleSinDatosRegistrales").is(':checked'));
      $("#InmuebleSinDatosRegistrales").on("click", function () {
        $("#registrales input").attr("disabled", this.checked);
      });
    });
  </script>
<?php
$this->end();
if ($profile['is_agencia'] || $profile['is_coordinador']) {
  echo $this->App->horizontalSelect('Inmueble.agente_id', 'Agente:', array('' => '(seleccionar agente)') + $agentes, array('labelClass' => 'obligat'));
}
?>
<h3 class="section">Datos registrales</h3>
<p class="text-info text-center">Los datos registrales son obligatorios para que los inmuebles se publiquen en Web, excepto alquileres.</p>
<div id="registrales">
  <?php
  echo $this->App->horizontalInput('Inmueble.registro_de', 'Registro de:', array('maxlength' => 32, 'labelClass' => 'obligat-web'));
  echo $this->App->horizontalInput('Inmueble.registro_numero', 'Registro número:', array('type' => 'number', 'type' => 'number', 'min' => 1, 'maxlength' => 4, 'labelClass' => 'obligat-web'));
  echo $this->App->horizontalInput('Inmueble.registro_tomo', 'Tomo:', array('type' => 'number', 'min' => 1, 'maxlength' => 4, 'labelClass' => 'obligat-web'));
  echo $this->App->horizontalInput('Inmueble.registro_finca', 'Finca:', array('type' => 'number', 'min' => 1, 'maxlength' => 6, 'labelClass' => 'obligat-web'));
  echo $this->App->horizontalInput('Inmueble.registro_libro', 'Libro:', array('type' => 'number', 'min' => 1, 'maxlength' => 5, 'labelClass' => 'obligat-web'));
  echo $this->App->horizontalInput('Inmueble.registro_folio', 'Folio:', array('type' => 'number', 'min' => 0, 'maxlength' => 4, 'labelClass' => 'obligat-web'));
  echo '<hr>';
  echo $this->App->horizontalInput('Inmueble.registro_m2', 'M2 Registro:', array('type' => 'number', 'min' => 1, 'maxlength' => 5));
  ?>
</div>
