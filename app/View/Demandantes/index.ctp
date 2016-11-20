<?php
$this->set('title_for_layout', __d('alfainmo_es', 'Clientes'));
// app/View/Demandantes/view.ctp
$this->extend('/Common/view2top');

$title = "Búsqueda de demandantes";
$this->set('title_for_layout', $title);
$url_64 = base64_encode($this->Html->url($this->request->data));

$this->start('sidebar');
echo $this->element('demandantes_top');
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
<div class="row">
	<div class="col-xs-4 col-sm-3">
		<?php echo $this->Form->select('clasificacion', $clasificaciones, array('name' => 'clasificacion', 'class' => 'form-control')); ?>
	</div>
	<div class="col-xs-8 col-sm-9">
		<div class="input-group">
		  <?php
		  echo $this->Form->input('q', array('label' => false, 'div' => false, 'class' => 'form-control no-prevent',
		                                     'name' => 'q', 'id' => 'search_q','placeholder' => 'población, provincia, nombre, teléfono, agente...'));
		  ?>
		  <span class="input-group-btn">
		  <?php echo $this->Form->submit('<i class="glyphicon glyphicon-search"></i> buscar', array('class' => 'btn btn-default', 'div' => false, 'escape' => false)); ?>
		  </span>
		</div>
	</div>
</div>
<div class="row">

	<div class="col-xs-4 col-sm-2">

		<div class="form-group">
			<div class="checkbox">
				<label><input type="checkbox" name="inc_bajas"<?php echo (isset($this->request->data['inc_bajas'])) ? ' checked="checked"' : ''; ?>> Encontrar altas y bajas</label>
			</div>
		</div>

	</div>


</div>
<?php echo $this->Form->end(); ?>
<table class="table table-striped vertical-align-middle" id="listado">
  <thead>
    <?php echo $this->Html->tableHeaders(array(
      '<a href="#referencia">Ref.</a>',
      '<a href="#nombre_contacto">Nombre</a>',
      '<a href="#email_contacto">EMail</a>',
      '<a href="#telefono1_contacto">Teléfonos</a>',
      '<a href="#provincia">Provincia</a>',
	    '<a href="#poblacion">Poblaci&oacute;n</a>',
      '<a href="#clasificacion_demandante_id">Clasificación</a>',
	    'Inmueble',
	    'V/A',
      '<a href="#created desc">Creado</a>', '')); ?>
    </thead>
  <tbody>
    <?php
    foreach ($info as $item) {

      $icons = '';
      if (!$profile['is_consultor'] && ($profile['is_central'] || $profile['is_agencia'] || $profile['is_coordinador'] || ($profile['is_agente'] && $agente['Agente']['id'] == $item['Demandante']['agente_id']))) {
        $icons .= $this->Html->link('<i class="glyphicon glyphicon-edit"></i> editar', 'edit/' . $item['Demandante']['id'] . '/' . $url_64, array('escape' => false));
      }
      $link = 'view/' . $item['Demandante']['id'] . '/' . $url_64;
	    $baja = (!empty($item['Demandante']['fecha_baja'])) ? ' baja' : '';

      echo $this->Html->tableCells(array(
        $this->Html->link($item['Demandante']['referencia'], $link, array('escape' => false)),
        $this->Html->link($item['Demandante']['nombre_contacto'], $link, array('escape' => false)),
        $this->Text->autoLinkEMails($item['Demandante']['email_contacto']),
        $this->Html->link($item['Demandante']['telefono1_contacto'], $link, array('escape' => false)),
        $this->Html->link($item['Demandante']['provincia'], $link, array('escape' => false)),
	      $this->Html->link($item['Demandante']['poblacion'], $link, array('escape' => false)),

        ((isset($item['ClasificacionDemandante']['description'])) ?
          $this->Html->link($item['ClasificacionDemandante']['description'], $link, array('escape' => false)) : ''),

	      ((isset($item['Demanda']['TipoInmueble']['description'])) ?
		      $this->Html->link($item['Demanda']['TipoInmueble']['description'], $link, array('escape' => false)) : ''),

	      ((isset($item['Demanda']['operacion'])) ?
		      $this->Html->link($item['Demanda']['operacion'] . '.', $link, array('escape' => false)) : ''),

        array($this->Html->link(substr($item['Demandante']['created'], 0, 10), $link, array('escape' => false)), array('class' => 'nowrap')),
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
