<?php $this->start('header'); ?>
<script type="text/javascript">

  $(document).ready(function() {
    $("#selec_punto").on("change", function() {
      $("div[class*='selec_punto_']").hide();
      $("select[name*=selec_punto_]").val('');
      $("div.selec_punto_" + this.value).show();
    });

  });
</script>
<?php $this->end(); ?>

<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4">N&uacute;mero o Kil&oacute;metro:</label>
  <div class="col-xs-7 col-lg-8 col-sm-8">
    <select id="selec_punto" required="required" size="2" class='form-control'>
      <option value="1">n&uacute;mero</option>
      <option value="2">kil&oacute;metro</option>
    </select>
  </div>
</div>
<div class="oculto selec_punto_1">
  <?php echo $this->App->horizontalInput('Terreno.numero', 'Número:', array('type' => 'number', 'maxlength' => '10', 'required' => 'required')); ?>
</div>
<div class="oculto selec_punto_2">
  <?php echo $this->App->horizontalInput('Terreno.kilometro', 'Kilómetro:', array('type' => 'number', 'maxlength' => '10', 'required' => 'required')); ?>
</div>
<?php
echo $this->App->horizontalInput('Terreno.numero_parcela', 'N. Parcela:', array('type' => 'number', 'maxlength' => '10'));
echo $this->App->horizontalInput('Terreno.sector', 'N. Sector:', array('type' => 'number', 'maxlength' => '10'));
?>