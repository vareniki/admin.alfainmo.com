<ul class="nav nav-pills nav-stacked">
  <li<?php echo $this->App->getActiveClass($this->request, 'inmuebles/index'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-search"></i> listado', '/inmuebles/index', array('escape' => false)) ?></li>
  <li<?php echo $this->App->getActiveClass($this->request, 'inmuebles/add'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> nuevo', '/inmuebles/add', array('escape' => false)) ?></li>
</ul>
<hr>
