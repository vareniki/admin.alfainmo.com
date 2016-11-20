<?php

// app/Model/Imagen.php

class Imagen extends AppModel {

  public $name = 'Imagen';
  public $useTable = 'imagenes';
  public $belongsTo = array('TipoImagen' => array('foreignKey' => 'tipo_imagen_id'));

}
