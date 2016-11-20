<ul class="nav nav-pills">
  <li<?php echo $this->App->getActiveClass($this->request, 'demandantes/index'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-th-list"></i> listado', '/demandantes/index', array('escape' => false)) ?></li>
  <li<?php echo $this->App->getActiveClass($this->request, 'demandantes/add'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> nuevo', '/demandantes/add', array('escape' => false)) ?></li>
</ul>
