
<?php

echo $this->Form->create(false, array('id' => 'searchForm2', 'action' => 'index'));
echo $this->Form->hidden('q', array('name' => 'q'));

echo '<label>Busco...</label>';
echo $this->Form->select('tipo', $tiposInmueble, array('name' => 'tipo', 'class' => 'form-control', 'placeholder' => 'Operación'));
echo '<br>';
echo $this->Form->select('operacion', $operaciones, array('name' => 'operacion', 'class' => 'form-control', 'type' => 'number'));

echo '<br><label>Precio máximo.</label>';
echo $this->Form->input('precio', array('name' => 'precio', 'class' => 'form-control', 'label' => false, 'min' => 0, 'max' => '3000000'));

echo '<br>';
echo $this->Form->select('anios', $maximoAnios, array('name' => 'anios', 'class' => 'form-control', 'label' => false));

echo '<br>';
echo $this->Form->select('habitaciones', $minimoDormitorios, array('name' => 'habitaciones', 'class' => 'form-control', 'label' => false));

echo '<br>';
echo $this->Form->select('banos', $minimoBannos, array('name' => 'banos', 'class' => 'form-control', 'label' => false));

echo $this->Form->checkbox('garaje', array('name' => 'garaje', 'value' => 't', 'label' => 'con garaje'));
echo $this->Form->checkbox('ascensor', array('name' => 'ascensor', 'value' => 't', 'label' => 'con ascensor'));

echo $this->Form->checkbox('mi_agencia', array('name' => 'mi_agencia', 'value' => 't', 'label' => 'de mi agencia'));
echo $this->Form->select('estado', $estadosInmueble, array('name' => 'estado', 'class' => 'form-control', 'label' => false));
echo '<hr><div class="text-right">';
echo $this->Form->submit('<i class="glyphicon glyphicon-search"></i> buscar', array('class' => 'btn btn-sm btn-default', 'div' => false, 'escape' => false));
echo '</div>';
echo $this->Form->end();
?>