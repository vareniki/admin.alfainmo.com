<?php
echo $this->App->horizontalSelect('Inmueble.calidad_precio', 'Calidad / precio:', array('' => '') + $calidadPrecio, array('size' => '3'));
echo $this->App->horizontalInput('Inmueble.descripcion', 'Descripci&oacute;n completa:', array('rows' => 6,
	'placeholder' => 'recuerda utilizar palabras clave como: zona, colegios, guarderías, metro, centros de salud, servicios comunes, autobuses,...'));
echo $this->App->horizontalInput('Inmueble.descripcion_abreviada', 'Descripci&oacute;n abreviada:<br><span>(max. 500 caracteres)</span>', array('rows' => 4, 'maxlength' => 500));
echo $this->App->horizontalTextarea('Inmueble.video', 'Vídeo:', array('rows' => 3, 'placeholder' => 'pegue el código html'));
