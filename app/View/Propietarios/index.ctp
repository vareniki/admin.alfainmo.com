<?php
$this->set('title_for_layout', __d('alfainmo_es', 'Clientes'));
// app/View/Propietarios/view.ctp
$this->extend('/Common/view2top');

$title = "Búsqueda de propietarios";
$this->set('title_for_layout', $title);
$url_64 = base64_encode($this->Html->url($this->request->data));

$this->start('sidebar');
echo $this->element('propietarios_top');
$this->end();

$this->start('header'); ?>
<script type="text/javascript">
  $(document).ready(function() {
    $("#listado").find("thead").on("click", "a", function() {
      var href = this.href.split("#");
      if (href.length <= 1) {
        return;
      }
      var field=href[1];

      $("#sortBy").val(field);
      $("#searchForm").submit();
    });
  });
</script>
<?php $this->end();

echo $this->Form->create(false, array('id' => 'searchForm', 'action' => '/index', 'class' => 'busqueda inline-form'));
echo $this->Form->hidden('sortBy', array('name' => 'sortBy'));
?>
  <div class="input-group">
    <?php
    echo $this->Form->input('q', array('label' => false, 'div' => false,
      'class' => 'form-control no-prevent', 'name' => 'q', 'id' => 'search_q',
      'placeholder' => 'población, provincia, nombre, teléfono...'));
    ?>
    <span class="input-group-btn">
    <?php echo $this->Form->submit('<i class="glyphicon glyphicon-search"></i> buscar', array('class' => 'btn btn-default', 'div' => false, 'escape' => false)); ?>
  </span>
  </div>
	<div class="form-group">
	  <div class="checkbox">
	    <label><input type="checkbox" name="inc_bajas"<?php echo (isset($this->request->data['inc_bajas'])) ? ' checked="checked"' : ''; ?>> Encontrar altas y bajas</label>
	  </div>
	</div>
<?php
echo $this->Form->end();
if (isset($info)): ?>
  <hr>
  <table class="table table-striped vertical-align-middle" id="listado">
    <thead>
      <?php echo $this->Html->tableHeaders(array(
        '<a href="#referencia">Ref.</a>',
        '<a href="#nombre_contacto">Nombre</a>',
        '<a href="#email_contacto">EMail</a>',
        '<a href="#telefono1_contacto">Tel&eacute;fonos</a>',
        '<a href="#provincia">Provincia</a>',
        '<a href="#created desc">Creado</a>', '', '')); ?>
      </thead>
    <tbody>
      <?php
      foreach ($info as $item) {

        $icons = '';
        if ($profile['is_central'] || $profile['is_agencia'] || ($profile['is_agente'] && $agente['Agente']['id'] == $item['Inmueble']['agente_id'])) {
          $icons = $this->Html->link('<i class="glyphicon glyphicon-edit"></i> editar', 'edit/' . $item['Propietario']['id'] . '/' . $url_64, array('escape' => false));
        }

        $link = 'view/' . $item['Propietario']['id'] . '/' . $url_64;
	      $link_inmueble = '/inmuebles/view/' . $item['Inmueble']['id'] . '/' . $url_64;
	      $baja = (!empty($item['Propietario']['fecha_baja'])) ? ' baja' : '';

        echo $this->Html->tableCells(array(
          $this->Html->link($item['Inmueble']['numero_agencia'] . '/' . $item['Inmueble']['codigo'], $link, array('escape' => false)),
          $this->Html->link($item['Propietario']['nombre_contacto'], $link, array('escape' => false)),
          $this->Text->autoLinkEMails($item['Propietario']['email_contacto']),
          $this->Html->link($item['Propietario']['telefono1_contacto'], $link, array('escape' => false)),
          $this->Html->link($item['Propietario']['provincia'], $link, array('escape' => false)),
          $this->Html->link(substr($item['Propietario']['created'], 0, 10), $link, array('escape' => false)),
          array($icons, array('class' => 'nowrap')),
          $this->Html->link('<i class="glyphicon glyphicon-share-alt"></i>', $link_inmueble, array('escape' => false)),
        ), array('class' => "odd$baja"), array('class' => "even$baja"));
      }
      ?>
    </tbody>
  </table>
  <div class="text-center">
    <ul class="pagination">
      <?php
      $this->Paginator->options(array('url' => $this->passedArgs));
      echo $this->Paginator->numbers();
      ?>
    </ul>
  </div>
  <?php
 endif;