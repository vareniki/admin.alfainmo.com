<div>
<?php echo $this->fetch('sidebar'); ?>
</div>
<br>
<article id="contenido">
  <?php
  echo $this->fetch('content');
  echo '<br>';
  echo $this->Session->flash();
  ?>
</article>
