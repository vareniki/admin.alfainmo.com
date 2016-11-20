<?php
$title = __d('alfainmo_es', 'Alfa Inmobiliaria');

$this->Html->css(array('bootstrap.min.css'), null, array('inline' => false));
?> 
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout . ' : ' . $title ?></title>
    <?php

    echo $this->fetch('css');
    echo $this->fetch('header');
    ?>
  </head>
  <body>
    <div id="pdf-header"></div>
    <div id="pdf-body">
	    <?php echo $this->fetch('content'); ?>
    </div>
    <div id="pdf-footer">
    </div>
    <?php echo $this->Js->writeBuffer(); ?>
  </body>
</html>