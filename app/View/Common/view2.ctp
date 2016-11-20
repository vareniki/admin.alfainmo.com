<div class="row">
  <aside id="aside-left" class="col-xs-2">    
		<?php echo $this->fetch('sidebar'); ?>
  </aside>
  <article id="contenido" class="col-xs-10">
		<?php
    echo $this->Session->flash();
		echo $this->fetch('content');
		?>
  </article>
</div>
