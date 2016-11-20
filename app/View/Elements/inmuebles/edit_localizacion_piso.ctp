<?php
echo $this->App->horizontalInput('Piso.bloque', 'Bloque / portal:');
echo $this->App->horizontalSelect('Piso.piso', 'Planta:',  array('' => '') + $plantasPiso, array('size' => 7));
echo $this->App->horizontalSelect('Piso.puerta', 'Puerta:', array('' => '') + $puertasPiso, array('size' => 9));
echo $this->App->horizontalInput('Piso.urbanizacion', 'Urbanización:');
