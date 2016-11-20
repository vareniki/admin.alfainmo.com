<?php
echo $this->App->horizontalInput('Local.bloque', 'Bloque / portal:');
echo $this->App->horizontalSelect('Local.puerta', 'Puerta:', $puertasLocal, array('size' => 9));
echo $this->App->horizontalSelect('Local.localizacion_local_id', 'Localizaci&oacute;n:', $localizacionesLocal, array('size' => '3'));
