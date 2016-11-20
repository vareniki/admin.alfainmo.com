<?php
$this->set('title_for_layout', __d('alfainmo_es', 'Agentes'));
// app/View/Agentes/view.ctp
$this->extend('/Common/view2top');

$title = "Búsqueda de Agentes";
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('agentes_top');
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
<?php
$this->end();
$url_64 = base64_encode($this->Html->url($this->request->data));

echo $this->Form->create(false, array('id' => 'searchForm', 'action' => '/index', 'class' => 'busqueda inline-form'));
echo $this->Form->hidden('sortBy', array('name' => 'sortBy'));
?>
<div class="input-group">
  <input name="q" type="text" class="form-control" placeholder="población, provincia, nombre, teléfono..." 
         value="<?php echo (isset($this->request->data['q']) ? $this->request->data['q'] : ''); ?>">
  <span class="input-group-btn">
    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
  </span>
</div>
<div class="form-group">
  <div class="checkbox">
    <label>
      <input type="checkbox" name="inc_bajas"<?php echo (isset($this->request->data['inc_bajas'])) ?' checked="checked"' : ''; ?>> Encontrar altas y bajas
    </label>
  </div>
</div>
<?php echo $this->Form->end(); ?>
<table class="table table-striped vertical-align-middle" id="listado">
  <thead>
    <?php echo $this->Html->tableHeaders(array(
      '<a href="#nombre_contacto">Nombre</a>',
      '<a href="#email_contacto">EMail</a>',
      '<a href="#telefono1_contacto">Tel&eacute;fonos</a>',
      '<a href="#provincia">Provincia</a>',
      '<a href="#created desc">Creado</a>', '')); ?>
    </thead>
  <tbody>
    <?php
    foreach ($info as $item) {

      $icons = '';
      if ($profile['is_agencia'] || $profile['is_coordinador']) {
        $icons = $this->Html->link('<i class="glyphicon glyphicon-edit"></i> editar', 'edit/' . $item['Agente']['id'] . '/' . $url_64, array('escape' => false));
      }
	    $link = 'view/' . $item['Agente']['id'] . '/' . $url_64;

      $baja = ($item['User']['active'] != 't') ? ' baja' : '';

      echo $this->Html->tableCells(array(
	      $this->Html->link($item['Agente']['nombre_contacto'], $link, array('escape' => false)),
        $this->Text->autoLinkEMails($item['Agente']['email_contacto']),
	      $this->Html->link($item['Agente']['telefono1_contacto'], $link, array('escape' => false)),
	      $this->Html->link($item['Agente']['provincia'], $link, array('escape' => false)),
        array(substr($item['Agente']['created'], 0, 10), array('class' => 'nowrap')),
        array($icons, array('class' => 'nowrap'))), array('class' => "odd$baja"), array('class' => "even$baja"));
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
