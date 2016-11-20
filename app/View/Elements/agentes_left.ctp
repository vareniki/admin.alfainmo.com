<ul class="nav nav-pills nav-stacked">
  <li<?php echo $this->App->getActiveClass($this->request, 'agentes/index'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-th-list"></i> listado', '/agentes/index', array('escape' => false)) ?></li>
  <li<?php echo $this->App->getActiveClass($this->request, 'agentes/add'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> nuevo', '/agentes/add', array('escape' => false)) ?></li>
</ul>
