<?php
echo $this->App->horizontalInput('Oficina.bloque', 'Bloque / portal:');
echo $this->App->horizontalSelect('Oficina.piso', 'Planta:',  array('' => '') + $plantasOficina, array('size' => 7));
echo $this->App->horizontalSelect('Oficina.puerta', 'Puerta:', array('' => '') + $puertasOficina, array('size' => 9));
echo $this->App->horizontalInput('Oficina.urbanizacion', 'Urbanización:');
