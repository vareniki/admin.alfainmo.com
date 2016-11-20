<?php
$title = __d('alfainmo_es', 'Alfa Inmobiliaria');

$this->Html->script(array($this->App->getJQueryVersion(), 'http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'), array('inline' => false));
$this->Html->css('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css', null, array('inline' => false));
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title ?>: Login</title>
    <?php
    echo $this->Html->meta('icon');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      .form-signin img {
        width: 100%;
      }

    </style>    
  </head>
  <body>

    <div class="container">
      <?php
      echo $this->Form->create('User', array('class' => 'form-signin'));
      echo $this->Html->image('logo-alfa-2016-387.png');
      echo '<br><br><br>';
      echo $this->Form->input('username', array('label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => 'Usuario'));
      echo $this->Form->input('password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => 'Password'));
      echo $this->Html->div('', $this->Session->flash());
      echo $this->Form->submit('Entrar', array('div' => array('class' => 'text-right'), 'class' => 'btn btn-medium btn-primary'));
      echo $this->Form->end();
      ?>
    </div>
  </body>
</html>



