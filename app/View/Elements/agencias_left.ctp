<ul class="nav nav-pills nav-stacked">
  <li<?php echo $this->App->getActiveClass($this->request, 'agencias/index'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-th-list"></i> listado', '/agencias/index', array('escape' => false)) ?></li>
  <li<?php echo $this->App->getActiveClass($this->request, 'agencias/add'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> nuevo', '/agencias/add', array('escape' => false)) ?></li>
</ul>
