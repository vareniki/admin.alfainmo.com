<?php
$this->extend( '/Common/view2top' );
$this->start( 'sidebar' );

$title = 'Agenda';
$this->set( 'title_for_layout', $title );

$this->end();
$this->start( 'header' ); ?>
<script type="text/javascript">
	$(document).ready(function () {
		$("#listado").find("thead").on("click", "a", function () {
			var href = this.href.split("#");
			if (href.length <= 1) {
				return;
			}
			var field = href[1];

			$("#sortBy").val(field);
			$("#searchForm").submit();
		});

		$("#desde, #hasta").datetimepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayBtn: true,
			pickerPosition: "bottom-right",
			language: 'es',
			weekStart: 1,
			minView: 3
		});

	});
</script>
<?php
$this->end();
$this->start( 'sidebar' );
echo $this->element( 'agenda_top' );
$this->end();

echo $this->Form->create( false, array( 'id' => 'searchForm', 'url' => '/agenda/listado', 'class' => 'busqueda inline-form') );
echo $this->Form->hidden( 'sortBy', array( 'name' => 'sortBy' ) );
?>
<div class="row">

	<div class="col-xs-4 col-sm-3">
		<label>Acci&oacute;n / tarea</label>
		<?php echo $this->Form->select( 'tipo_evento_id', $tiposEvento, array( 'name' => 'tipo_evento_id', 'class' => 'form-control' ) ); ?>
	</div>
	<div class="col-xs-4 col-sm-3">
		<label>Agente</label>
		<?php echo $this->Form->select( 'agente_id', $agentes, array( 'name' => 'agente_id', 'class' => 'form-control' ) ); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<label>Estado</label>
		<?php echo $this->Form->select( 'estado', $estados, array( 'name' => 'estado', 'class' => 'form-control' ) ); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->input( 'desde', array( 'name' => 'desde', 'class' => 'form-control' ) ); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->input( 'hasta', array( 'name' => 'hasta', 'class' => 'form-control' ) ); ?>
	</div>
</div>
<br>
<div class="input-group">
	<input name="q" class="form-control no-prevent" id="search_q" placeholder="+ Info" type="text">
	<span class="input-group-btn">
    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> buscar</button>
	</span>
</div>
<?php echo $this->Form->end(); ?>

<table class='table'>
	<thead>
	<tr>
		<th></th>
		<th nowrap>Fecha</th>
		<th>Tipo</th>
		<th>Inmueble</th>
		<th>Propietario</th>
		<th>Demandante</th>
		<th>Agente</th>
		<th>+ Info</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($info as $evento): ?>
		<tr>
			<td><?php
				if ($evento['TipoEvento']['type'] <= 2) {
					switch ($evento['Evento']['estado']) {
						case 0: // Por realizar
							echo '<span style="color: #9C0002"><i class="glyphicon glyphicon-time"></i></span>';
							break;
						case 1: // Realizada
							echo '<span style="color: #358B02"><i class="glyphicon glyphicon-ok"></i></span>';
							break;
						case 2: // Anulada
							echo '<span style="color: #AAA"><i class="glyphicon glyphicon-remove"></i></span>';
							break;
					}
				} else if ($evento['TipoEvento']['type'] == 3) {
					echo '<i class="glyphicon glyphicon-tag"></i>';
				}
				?></td>
			<td nowrap><?php echo substr($evento['Evento']['fecha'], 0, 16); ?></td>
			<td><?php echo $evento['TipoEvento']['description']; ?></td>
			<td><?php
				if (isset($evento['Inmueble']['numero_agencia'])) {
					$ref = 'REF. ' . $evento['Inmueble']['numero_agencia'] . '/' . $evento['Inmueble']['codigo'];
					$link = '/inmuebles/view/' . $evento['Inmueble']['id'];

					echo $this->Html->link($ref, $link, ['target' => '_blank']);
				}
				?></td>
			<td><?php
				if (isset($evento['Propietario']['nombre_contacto'])) {
					$link = '/propietarios/view/' . $evento['Propietario']['id'];
					echo $this->Html->link($evento['Propietario']['nombre_contacto'], $link, array('escape' => false, 'target' => '_blank'));
				}
				?></td>
			<td><?php
				if (isset($evento['Demandante']['nombre_contacto'])) {
					$link = '/demandantes/view/' . $evento['Demandante']['id'];
					echo $this->Html->link($evento['Demandante']['nombre_contacto'], $link, array('escape' => false, 'target' => '_blank'));
				}
				?></td>
			<td><?php
				if (isset($evento['Agente']['nombre_contacto'])) {
					$link = '/agentes/view/' . $evento['Agente']['id'];
					echo $this->App->contactoShowInfo($evento['Agente'], $link, ['target' => '_blank']);
				}
				?></td>
			<td><?php echo $this->Inmuebles->printEventoInfo($evento, $infoaux); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php if (!empty($info)) { ?>
<div class="text-center">
	<ul class="pagination">
		<?php
		$this->Paginator->options( array( 'url' => $this->passedArgs ) );
		echo $this->Paginator->numbers();
		?>
	</ul>
</div>
<?php } ?>