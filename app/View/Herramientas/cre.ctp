<?php
// app/View/Inmuebles/view2top.ctp
$this->extend('/Common/view2top');
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('herramientas_top');
$this->end();

$this->start('header');
?>
<script type="text/javascript"></script>
<?php $this->end(); ?>

<?php if (isset($captacion)): ?>
<table class="table">
	<tr>
		<th>Agente</th>
		<th class="text-center">Ref.</th>
		<th>Fecha<br>de alta</th>
		<th>Comprob.<br>duplicado</th>
		<th>Sobre</th>
		<th>Fecha<br>captación</th>
		<th>Calidad</th>
		<th>Carta<br>agradec.</th>
		<th>Dossier</th>
		<th>Oficina<br>propiet.</th>
		<th>Visita<br>comprador</th>
		<th class="text-center">Visitas<br>propias</th>
		<th class="text-center">Visitas<br>otras of.</th>
		<th>&Uacute;ltmo<br>informe gest.</th>
		<th>Total<br>informes</th>
		<th class="text-center">Llamadas<br>emitidas</th>
		<th class="text-center">Llamadas<br>recibidas</th>
		<th>Seguimiento</th>
		<th>Motivo baja</th>
	</tr>
	<?php foreach ($captacion as $info) { ?>
	<tr>
		<td><?php echo $info[0]['nombre_agente']; ?></td>
		<td class="text-center"><?php echo $info[0]['referencia']; ?></td>
		<td style="white-space: nowrap"><?php echo substr($info[0]['fecha_alta'], 0, 10); ?></td>
		<td></td>
		<td></td>
		<td><?php echo $info[0]['fecha_captacion']; ?></td>
		<td><?php echo $info[0]['estado_conservacion']; ?></td>
		<td><?php echo $info[0]['carta_agradecimiento']; ?></td>
		<td><?php echo $info[0]['dossier']; ?></td>
		<td><?php echo $info[0]['visita_propietario_oficina']; ?></td>
		<td><?php echo $info[0]['visita_comprador_oficina']; ?></td>
		<td class="text-center"><?php echo $info[0]['total_visitas_propias']; ?></td>
		<td class="text-center"><?php echo $info[0]['total_visitas_ajenas']; ?></td>
		<td><?php echo $info[0]['ultimo_informe_gestion']; ?></td>
		<td><?php echo $info[0]['total_informes_gestion']; ?></td>
		<td class="text-center"><?php echo $info[0]['llamadas_emitidas']; ?></td>
		<td class="text-center"><?php echo $info[0]['llamadas_recibidas']; ?></td>
		<td></td>
		<td><?php echo $info[0]['motivo_baja']; ?></td>
	</tr>
	<?php } ?>
</table>

<?php elseif (isset($venta)): ?>

	<table class="table">
		<tr>
			<th>Cliente</th>
			<th class="text-center">Llamad.<br>Recibidas</th>
			<th>Visita<br>Oficina</th>
			<th>Buscar</th>
			<th>Visita<br>Inmueble</th>
			<th>Fecha<br>captación</th>
			<th>Valor V/Z/E</th>
			<th>Estudio<br>Econ&oacute;mico</th>
			<th>Compra<br>Directa</th>
			<th>Nivel<br>1,2,3.</th>
			<th>Visita<br>comprador</th>
			<th>Visita 2<br>inmueble</th>
			<th>Visita 3<br>inmueble</th>
			<th>Valor<br>V/Z/E</th>
			<th>Casa Ideal</th>
			<th>Negociación</th>
			<th>Seguimiento</th>
			<th>Baja</th>
		</tr>

	</table>

<?php endif; ?>
