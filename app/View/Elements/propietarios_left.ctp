<ul class="nav nav-pills nav-stacked">
  <li<?php echo $this->App->getActiveClass($this->request, 'propietarios/index'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-th-list"></i> listado', '/propietarios/index', array('escape' => false)) ?></li>
</ul>
