<ul class="nav nav-pills">
  <li<?php echo $this->App->getActiveClass($this->request, 'herramientas/cre_captacion'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> CRE de Captaci&oacute;n', '/herramientas/cre_captacion', array('escape' => false)) ?></li>
  <li<?php echo $this->App->getActiveClass($this->request, 'herramientas/cre_venta'); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> CRE de Venta', '/herramientas/cre_venta', array('escape' => false)) ?></li>
</ul>
