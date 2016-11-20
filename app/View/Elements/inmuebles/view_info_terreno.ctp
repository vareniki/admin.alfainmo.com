<ul>
  <?php $this->Model->printIfExists($info, 'area_total', array('label' => 'Área total', 'model' => 'Terreno', 'format' => 'area')); ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'numero_parcela', array('label' => 'Número de parcela', 'model' => 'Terreno', 'format' => 'number'));
  $this->Model->printIfExists($info, 'sector', array('label' => 'Sector', 'model' => 'Terreno', 'format' => 'number'));
  ?>
</ul>