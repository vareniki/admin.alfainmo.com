<?php
$title = __d('alfainmo_es', 'Alfa Inmobiliaria');

$this->Html->script(array($this->App->getJQueryVersion(),
	'bootstrap.min.js',
	'bootstrap-datetimepicker.min',
	'bootstrap-datetimepicker.es',
  'http://cdn.jsdelivr.net/jquery.validation/1.13.1/jquery.validate.min.js',
  'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/localization/messages_es.js',
	'jquery.form.min',
	'jquery.html5-placeholder-shim'), array('inline' => false));


$this->Html->css(array(
  'bootstrap.min.css', 'bootstrap-datetimepicker.min', 'alfainmo'), null, array('inline' => false));

?> 
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout . ' : ' . $title ?></title>
    <?php
    echo $this->Html->meta('icon');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    echo $this->fetch('header');
    ?>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $this->Html->url('/'); ?>js/html5shiv.js"></script>
      <script src="<?php echo $this->Html->url('/'); ?>js/respond.min.js"></script>
    <![endif]-->
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <script type="text/javascript">

      var fields_changed = false;

      $(document).ready(function() {
        $("#btn-close").click(function() {
          window.location.href = "<?php echo $this->Html->url("/users/logout") ?>";
        });
        
        $('form input').not('.no-prevent').keydown(function(event) {
          if (event.keyCode == 13) {
            event.preventDefault();
            return false;
          }
        });

        $("form.aviso").on("change", "input, select, textarea", function() {
          fields_changed = true;
        });

        $("div.navbar, aside, #save-buttons").on("click", "a", function() {
          var href = $(this).attr("href");
          if (href == '#') {
            return true;
          }
          if (fields_changed) {
            return confirm("Las modificaciones no se han salvado. Pinche 'Cancelar' para evitar que estas modificaciones se pierdan.");
          }
        });

        $("form.aviso").on("submit", function() {
          if ($(this).valid()) {
            $("#salvando-info").show();
          }
        });
      });
    </script>

  </head>
  <body id="<?php echo strtolower('main-' . $this->name . '-' . $this->view); ?>" class="main-<?php echo strtolower($this->name) ?>">
    <header>
      <div class="container">
        <?php echo $this->element('common/header'); ?>
      </div>
    </header>
    <article>
      <div id="main-content" class="container">
        <h2><?php echo $title_for_layout ?></h2>
        <div id="salvando-info" class="alert alert-warning text-center" style="margin: 0 0 10px; 0">enviando informaci&oacute;n...</div>
        <?php echo $this->fetch('content'); ?>
      </div>
    </article>
    <footer>
      <div class="container">
        <?php echo $this->element('common/footer'); ?>
      </div>
    </footer>
    <?php echo $this->fetch('dialogs'); ?>
    <?php echo $this->Js->writeBuffer(); ?>
  </body>
</html>