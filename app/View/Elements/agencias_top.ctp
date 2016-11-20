<ul class="nav nav-pills">
  <li<?php echo $this->App->getActiveClass($this->request, 'agencias/index'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-th-list"></i> listado', '/agencias/index', array('escape' => false)) ?></li>
  <?php if ($profile['is_central']): ?>
  <li<?php echo $this->App->getActiveClass($this->request, 'agencias/add'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> nuevo', '/agencias/add', array('escape' => false)) ?></li>
  <?php endif; ?>
</ul>