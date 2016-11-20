<?php
// app/View/Inmuebles/view2top.ctp
$this->extend('/Common/view2top');

$this->set('title_for_layout', 'Herramientas - Publicidad');

$this->start('header');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("a", "#logos-portales").on("click", function() {
			var link = this.href.split("#");
			link = link[1];
			$("#title-portal").html($("#title-" + link).html());
			$("#info-portal").html($("#info-" + link).html());

		});
	});
</script>
<?php $this->end(); ?>

<p>Se pueden dar 3 situaciones con los portales inmobiliarios:</p>
<ul>
	<li>Contrato fondo de publicidad de volcado masivo. (Tú no haces nada, lo hacemos nosotros por ti). Ejemplo: Su Vivienda, Globaliza...</li>
	<li>Contrato fondo de publicidad de un número determinado de inmuebles. (Lo seleccionas en cada ficha de inmueble). Ejemplo: Idealista...</li>
	<li>Pasarela pero no tenemos contrato. (Tú puedes contratar con el portal y nosotros nos ocupamos de enviarles tus inmuebles).</li>
</ul>
<hr>
<div class="row" id="logos-portales">
<?php
foreach ($portales as $portal) {
	$img = $portal['img'];
	$link = $portal['link'];
	echo '<div class="col-xs-6 col-md-3 col-lg-2 text-center">' . $this->Html->link($this->Html->image('portales/' . $img), '#' . $link, array('escape' => false)) . '</div>';
}
?>
</div>
<hr>
<p>&nbsp;</p>
<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 id="title-portal" class="panel-title"><?php echo $portales[0]['title'] ?></h3>
	</div>
	<div class="panel-body" id="info-portal"><?php echo $portales[0]['info'] ?></div>
</div>
<div class="hidden">
	<?php
	foreach ($portales as $portal) {
		$link = $portal['link'];
		$title = $portal['title'];
		$info = $portal['info'];
		echo "<p id='title-$link'>$title</p>";
		echo "<p id='info-$link'>$info</p>";
	}
	?>
</div>
