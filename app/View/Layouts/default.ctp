<?php
$title = __d('alfainmo_es', 'Alfa Inmobiliaria');

$this->Html->script([
        '//code.jquery.com/jquery-3.2.1.min.js',
	'//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
	'bootstrap-datetimepicker.min.js?ver=3.3.7',
	'bootstrap-datetimepicker.es.js?ver=3.3.7',
  '//cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js',
  '//cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/localization/messages_es.js',
	'jquery.form.min',
	'jquery.html5-placeholder-shim'], ['inline' => false]);

$this->Html->css(['bootstrap.min.css', 'bootstrap-datetimepicker.min', 'alfainmo'], null, ['inline' => false]);
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
    ?>
      <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=mapCallBack&key=AlbfYmi5eFUj9sj8Rh5tjTbeM00HeglGuPJZnfYFtDz7KiRfwedBBucu-mMpTRLa' async defer></script>
      <?php
    echo $this->fetch('script');
    echo $this->fetch('header');
    ?>
      <style type="text/css">
          div.MicrosoftMap div[style*="50%"] { display:none; }
      </style>

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
      <!-- Smartsupp Live Chat script -->
      <script type="text/javascript">
          var _smartsupp = _smartsupp || {};
          _smartsupp.key = '4e629f749ea68e9fafe884cc1c51938651e4028f';
          window.smartsupp||(function(d) {
              var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
              s=d.getElementsByTagName('script')[0];c=d.createElement('script');
              c.type='text/javascript';c.charset='utf-8';c.async=true;
              c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
          })(document);
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