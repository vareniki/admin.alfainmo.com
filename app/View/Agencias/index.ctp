<?php
$this->set('title_for_layout', __d('alfainmo_es', 'Agencias'));
// app/View/Agentes/view.ctp
$this->extend('/Common/view2top');

$title = "Agencias de la red Alfa Inmobiliaria";
$this->set('title_for_layout', $title);
if ($profile['is_central']) {
  $this->start('sidebar');
  echo $this->element('agencias_top');
  $this->end();
}
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

echo $this->Form->create(false, array('id' => 'searchForm', 'url' => '/agencias/index', 'class' => 'busqueda inline-form'));
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
<?php if ($profile['is_central']): ?>
<div class="form-group">
  <div class="checkbox">
    <label><input type="checkbox" name="inc_bajas"<?php echo (isset($this->request->data['inc_bajas'])) ? ' checked="checked"' : ''; ?>> Encontrar altas y bajas</label>
  </div>
</div>
<?php
endif;

echo $this->Form->end();
if (isset($info)): ?>
  <table class="table table-striped vertical-align-middle" id="listado">
    <thead>
      <?php echo $this->Html->tableHeaders(array(
        '<a href="#numero_agencia">N&uacute;mero</a>',
        '<a href="#nombre_agencia">Nombre</a>',
        '<a href="#email_contacto">EMail</a>',
        '<a href="#web">Web</a>',
        '<a href="#telefono1_contacto">Tel&eacute;fonos</a>',
        '<a href="#provincia">Provincia</a>',
        '<a href="#poblacion">Población</a>', '')); ?>
    </thead>
    <tbody>
      <?php foreach ($info as $item) {

        $icons = '';
        if ($profile['is_central']) {
          $icons = $this->Html->link('<i class="glyphicon glyphicon-edit"></i> editar', 'edit/' . $item['Agencia']['id'], array('escape' => false));
        }
        $link = 'view/' . $item['Agencia']['id'];
        $baja = ($item['Agencia']['active'] != 't') ? ' baja' : '';

        echo $this->Html->tableCells(array(
          $this->Html->link($item['Agencia']['numero_agencia'], $link, array('escape' => false)),
          $this->Html->link($item['Agencia']['nombre_agencia'], $link, array('escape' => false)),
          $this->Text->autoLinkEMails($item['Agencia']['email_contacto']),
          $this->Text->autoLink($item['Agencia']['web'], array('target' => '_blank')),
	        $this->Html->link($item['Agencia']['telefono1_contacto'], $link, array('escape' => false)),
          $this->Html->link($item['Agencia']['provincia'], $link, array('escape' => false)),
          $this->Html->link($item['Agencia']['poblacion'], $link, array('escape' => false)),
          array($icons, array('class' => 'nowrap'))), array('class' => "odd$baja", 'escape' => false), array('class' => "even$baja"));
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