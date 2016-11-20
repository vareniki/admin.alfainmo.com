<div class="row">
<div class="col-xs-4">
	<ul class="nav nav-pills">
  <li<?php echo $this->App->getActiveClass($this->request, 'propietarios/index'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-th-list"></i> listado', '/propietarios/index', array('escape' => false)) ?></li>
</ul>
</div>
	<div class="col-xs-8">
<div class="alert alert-info">para dar de alta un propietario se hace desde la ficha del inmueble</div>
</div>
</div>