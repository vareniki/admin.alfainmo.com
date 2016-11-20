<div class="row">
  <aside id="aside-left" class="col-lg-3 col-sm-3">    
		<?php echo $this->fetch('sidebar'); ?>
  </aside>
  <article id="contenido" class="col-lg-6 col-sm-6">
		<?php
		echo $this->fetch('content');
		echo '<br>';
		echo $this->Session->flash();
		?>
  </article>
  <aside id="aside-right" class="col-lg-3 col-sm-3">
		<?php echo $this->fetch('sidebar2'); ?>
  </aside>
</div>
