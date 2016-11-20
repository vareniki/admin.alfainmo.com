<?php

// app/Model/Propietario.php

class Propietario extends AppModel {

  public $name = 'Propietario';
  public $useTable = 'propietarios';
  public $belongsTo = array('Inmueble', 'Pais');
}
