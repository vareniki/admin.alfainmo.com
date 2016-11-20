<?php

// app/Model/Contacto.php

class Contacto extends AppModel {

  public $name = 'Contacto';
  public $useTable = 'contactos';
  public $belongsTo = array('Inmueble',
    'HorarioContacto' => array('foreignKey' => 'horario_contacto_id')
  );

}
