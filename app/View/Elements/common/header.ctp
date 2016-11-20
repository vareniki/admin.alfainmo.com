<div class="navbar navbar-default" style="margin-top: 10px">

  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Fijar</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
	  <?php if (isset($agencia['Agencia'])) { ?>
      <a class="navbar-brand" href="#"><?php echo $agencia['Agencia']['nombre_agencia'] . ' - ' . $agencia['Agencia']['numero_agencia']; ?>&nbsp;&nbsp;</a>
	  <?php } else { ?>
		  <a class="navbar-brand" href="#">Alfa Inmobiliaria&nbsp;&nbsp;</a>
	  <?php } ?>
  </div>

  <div class="collapse navbar-collapse navbar-ex1-collapse">

    <ul class="nav navbar-nav navbar-left">
			<li<?php echo $this->App->getActiveClass($this->request, ''); ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-home"></i>', '/', array('escape' => false)); ?></li>
			<li<?php echo $this->App->getActiveClass($this->request, 'agenda'); ?>><?php echo $this->Html->link('Agenda', '/agenda/index'); ?></li>
      <li<?php echo $this->App->getActiveClass($this->request, 'inmuebles'); ?>><?php echo $this->Html->link('Inmuebles', '/inmuebles/index'); ?></li>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Personas <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu">
					<li<?php echo $this->App->getActiveClass($this->request, 'propietarios'); ?>><?php echo $this->Html->link('Propietarios', '/propietarios/index'); ?></li>
					<li<?php echo $this->App->getActiveClass($this->request, 'demandantes'); ?>><?php echo $this->Html->link('Demandantes', '/demandantes/index'); ?></li>
					<?php if (empty($agente)): ?>
					<li class="divider"></li>
					<li<?php echo $this->App->getActiveClass($this->request, 'agentes'); ?>><?php echo $this->Html->link('Agentes', '/agentes/index'); ?></li>
					<?php endif; ?>
				</ul>
			</li>

			<li<?php echo $this->App->getActiveClass($this->request, 'agencias'); ?>><?php echo $this->Html->link('Agencias Alfa', '/agencias/index'); ?></li>
	    <li<?php echo $this->App->getActiveClass($this->request, 'herramientas'); ?>><?php echo $this->Html->link('Herramientas', '/herramientas/index', array('escape' => false)); ?></li>
    </ul>

    <div class="navbar-right">
      <button id="btn-close" type="button" class="btn btn-default navbar-btn">Cerrar</button>
    </div>
  </div>
</div>