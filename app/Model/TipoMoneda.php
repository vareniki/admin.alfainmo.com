<?php

// app/Model/TipoMoneda.php

class TipoMoneda extends AppModel {

  public $name = 'TipoMoneda';
  public $useTable = 'taux_tipos_moneda';
  public $displayField = 'description';
}
