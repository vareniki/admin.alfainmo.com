<table width="100%">
	<tr>
		<th>Ref.</th>
		<th>Población</th>
		<th>Provincia</th>
		<th>C.Postal</th>
		<th>Calle</th>
		<th>Num.</th>
		<th>Coords</th>
		<th>Localización</th>
	</tr>
<?php
foreach ($info_array as $info) {
	echo '<tr>';
	echo '<td>' . $info['Inmueble']['numero_agencia'] . '/' . $info['Inmueble']['codigo'] . '</td>';
	echo '<td>' . $info['Inmueble']['poblacion'] . '</td>';
	echo '<td>' . $info['Inmueble']['provincia'] . '</td>';
	echo '<td>' . $info['Inmueble']['codigo_postal'] . '</td>';
	echo '<td>' . $info['Inmueble']['nombre_calle'] . '</td>';
	echo '<td>' . $info['Inmueble']['numero_calle'] . '</td>';
	echo '<td>' . $info['Inmueble']['coord_x'] . ' / ' . $info['Inmueble']['coord_y'] . '</td>';
	echo '<td>' . $info['direccion'] . '</td>';
	echo '</tr>';
}
?>
</table>