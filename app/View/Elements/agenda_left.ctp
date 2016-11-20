<ul class="nav nav-pills nav-stacked">
  <li<?php echo $this->App->getActiveClass($this->request, 'agenda/index'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-calendar"></i> calendario', '/agenda/index', array('escape' => false)) ?></li>
	<li<?php echo $this->App->getActiveClass($this->request, 'agenda/listado'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-th-list"></i> listado', '/agenda/listado', array('escape' => false)) ?></li>
	<li<?php echo $this->App->getActiveClass($this->request, 'agenda/add'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> nuevo', '/agenda/add', array('escape' => false)) ?></li>
</ul>
