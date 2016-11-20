<?php

App::uses('Helper', 'View');

/**
 * Results helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class InmueblesHelper extends Helper {

  public $helpers = array('Html', 'Number', 'Time', 'Model');
  private static $tiposPiso = array(
    '01' => 'Piso',
    '02' => 'Apartamento',
    '03' => 'Estudio',
    '04' => 'Loft',
    '05' => 'Dúplex',
    '06' => 'Atico');
  private static $tiposChalet = array(
    '02' => 'adosado',
    '03' => 'independiente',
    '04' => 'pareado');
  private static $tiposTerreno = array(
    '01' => 'urbano',
    '02' => 'rústico',
    '03' => 'urbanizable');
  private static $tiposGaraje = array(
    '01' => 'moto',
    '02' => 'coche');

	/**
	 * @param $info
	 * @return string
	 */
	public function getSubtipo($info) {
		$result = 'Piso';
		switch ($info['TipoInmueble']['id']) {
			case '02':
				$result = 'Chalet';
				break;
			case '03':
				$result = 'Local';
				break;
			case '04':
				$result = 'Oficina';
				break;
			case '05':
				$result = 'Garaje';
				break;
			case '06':
				$result = 'Terreno';
				break;
			case '07':
				$result = 'Nave';
				break;
			case '08':
				$result = 'Otro';
				break;
		}
		return $result;
	}

  /**
   * 
   * @param type $info
   * @return type
   */
  public function getSubtipoInfo($info) {

    $datos = array();
    switch ($info['TipoInmueble']['id']) {
      case '01':
        $datos = $info['Piso'];
        break;
      case '02':
        $datos = $info['Chalet'];
        break;
      case '03':
        $datos = $info['Local'];
        break;
      case '04':
        $datos = $info['Oficina'];
        break;
      case '05':
        $datos = $info['Garaje'];
        break;
      case '06':
        $datos = $info['Terreno'];
        break;
      case '07':
        $datos = $info['Nave'];
        break;
      case '08':
        $datos = $info['Otro'];
        break;
    }
    return $datos;
  }

	/**
	 * Comprueba si es posible modificar un registro
	 * @param $profile
	 * @param $inmueble
	 * @param $agencia
	 * @param $agente
	 * @return bool
	 */
	public function canEdit($profile, $inmueble, $agencia, $agente=null) {

		if ($profile['is_consultor']) {
			return false;
		}

		if ($profile['is_central']) {
			return true;
		}

		if (($profile['is_agencia'] || $profile['is_coordinador'] || $agente == null) && $agencia['Agencia']['id'] == $inmueble['Inmueble']['agencia_id']) {
			return true;
		}

		if ($profile['is_agente'] && $agente['Agente']['id'] == $inmueble['Inmueble']['agente_id']) {
			return true;
		}
		return false;
	}

  /**
   * @param $info
   * @param null $adicional
   * @return string
   */
  public function printDescripcion($info, $adicional = null) {
    $tipo = $info['TipoInmueble']['description'];
    $tipo = strtoupper(substr($tipo, 0, 1)) . substr($tipo, 1);

    switch ($info['TipoInmueble']['id']) {
      case '01': // Piso
        if (!empty($info['Piso']['tipo_piso_id'])) {
          $subtipo = $info['Piso']['tipo_piso_id'];
	        if (isset(self::$tiposPiso[$subtipo])) {
		        $tipo = self::$tiposPiso[$subtipo];
	        }
        }
        break;

      case '02': // Chalet
        if (!empty($info['Chalet']['tipo_chalet_id'])) {
          $subtipo = $info['Chalet']['tipo_chalet_id'];
	        if (isset(self::$tiposChalet[$subtipo])) {
            $tipo .= ' ' . self::$tiposChalet[$subtipo];
	        }
        }
        break;

      case '05': // Garaje
        if (!empty($info['Garaje']['tipo_garaje_id'])) {
          $subtipo = $info['Garaje']['tipo_garaje_id'];
	        if (isset(self::$tiposGaraje[$subtipo])) {
		        $tipo .= ' para ' . self::$tiposGaraje[$subtipo];
	        }
        }
        break;

      case '06': // Terreno
        if (!empty($info['Terreno']['tipo_terreno_id'])) {
          $subtipo = $info['Terreno']['tipo_terreno_id'];
          if (isset(self::$tiposTerreno[$subtipo])) {
            $tipo .= ' ' . self::$tiposTerreno[$subtipo];
          }
        }
        break;
      case '08':
        $tipo = 'Propiedad';
    }
    $operaciones = $this->printOperaciones($info);
    $result = $tipo . ' en ' . $operaciones;

	  if (!empty($info['Inmueble']['zona'])) {
		  $result .= ' en ' . $info['Inmueble']['zona'];
		  $separator = ' / ';
	  } else {
		  $separator = ' en ';
	  }

	  if (!empty($info['Inmueble']['poblacion']) && !empty($info['Inmueble']['provincia'])) {
      $result .= $separator . $info['Inmueble']['poblacion'] . ' (' . $info['Inmueble']['provincia'] . ').';
    }

    if ($adicional != null) {
      $result .= ' ' . $adicional;
    }
    return $result;
  }

  /**
   * 
   * @param type $info
   * @return string
   */
  public function printCiudad($info) {
    $result = '';
    if (!empty($info['Inmueble']['codigo_postal']) && !empty($info['Inmueble']['poblacion'])) {
      $result = $info['Inmueble']['codigo_postal'] . ' - ' . $info['Inmueble']['poblacion'] . ' (' . $info['Inmueble']['provincia'] . ')';
    }

    return $result;
  }

  /**
   * 
   * @param type $info
   * @return type
   */
  public function printDireccion($info, $completa = true) {
    $result = array();

    $calle_numero = $info['Inmueble']['nombre_calle'];
    if (!empty($info['Inmueble']['numero_calle'])) {
      $calle_numero .= ', ' . $info['Inmueble']['numero_calle'];
    }
    $result[] = $calle_numero;

	  if ($completa) {
		  $datos = $this->getSubtipoInfo($info);

		  if (!empty($datos['bloque'])) {
			  $result[] = 'Bloque ' . $datos['bloque'];
		  }
		  if (!empty($datos['escalera'])) {
			  $result[] = 'Escalera ' . $datos['escalera'];
		  }
		  if (!empty($datos['piso'])) {
			  $result[] = 'Piso ' . $datos['piso'];
		  }
		  if (!empty($datos['puerta'])) {
			  $result[] = 'Puerta ' . $datos['puerta'];
		  }
	  }

    return implode('. ', $result);
  }

	/**
	 * @param $info
	 * @return string
	 */
	public function printOperaciones($info) {
    $result = array();
    $datos = $info['Inmueble'];
    if ($datos['es_venta'] == 't') {
      $result[] = 'venta';
    }
    if ($datos['es_alquiler'] == 't') {
      $result[] = 'alquiler';
    }
    if ($datos['es_opcion_compra'] == 't') {
      $result[] = 'opción a compra';
    }
    if ($datos['es_traspaso'] == 't') {
      $result[] = 'traspaso';
    }
    return implode(', ', $result);
  }

  /**
   * 
   * @param type $info
   * @return type
   */
  public function printPrecios($info) {
    $result = array();

	  $moneda = (isset($info['TipoMoneda']['symbol'])) ? $info['TipoMoneda']['symbol'] : '&euro;';

    $precioV = (($info['Inmueble']['es_venta'] == 't') ? $info['Inmueble']['precio_venta'] : null);
    $precioA = (($info['Inmueble']['es_alquiler'] == 't') ? $info['Inmueble']['precio_alquiler'] : null);
    $precioT = (($info['Inmueble']['es_traspaso'] == 't') ? $info['Inmueble']['precio_traspaso'] : null);
    if ($precioV > 0) {
      $result[] = $this->Number->format((int) $precioV, array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . " $moneda";
    }
    if ($precioA > 0) {
      $result[] = $this->Number->format((int) $precioA, array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . " $moneda";
    }
    if ($precioT > 0) {
      $result[] = 'Traspaso: ' . $this->Number->format((int) $precioT, array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . " $moneda";
    }

    return implode('<br>', $result);
  }

	/**
	 * @param $info
	 * @param null $campos
	 * @return string
	 */
	public function printDetalles($info, $campos = null) {

		$result = '';

		$tipo = $this->getSubtipo($info);

		$plantas =  ($campos != null && isset($campos['plantas'])) ? $campos['plantas'] : array();

		if (!empty($info[$tipo]['piso'])) {
			$planta = $info[$tipo]['piso'];
			if (isset($plantas[$planta])) {
				$result .= $plantas[$planta] . '. ';
			}
		}

		$result .= $this->Model->getIfExists($info, 'numero_habitaciones', array('label' => 'hab:', 'model' => $tipo, 'tag' => ','));
		$result .= $this->Model->getIfExists($info, 'numero_banos', array('label' => 'ba&ntilde;os:', 'model' => $tipo, 'tag' => ','));
		$result .= $this->Model->getIfExists($info, 'numero_aseos', array('label' => 'aseos:', 'model' => $tipo, 'tag' => ','));
		$result .= $this->Model->getIfExists($info, 'plazas_parking', array('label' => 'pl. gar:', 'model' => $tipo, 'tag' => ','));
		$result .= $this->Model->getIfExists($info, 'numero_ascensores', array('label' => 'ascen:', 'model' => $tipo, 'tag' => ','));

		$result .= $this->Model->getBooleans($info, array('con_ascensor' => 'con asc.', 'con_parking' => 'con park.'), array('model' => $tipo, 'tag' => ','));

		return $result;
	}

  /**
   * 
   * @param type $info
   * @return string
   */
  public function getPrecioPropietario($info) {
    $precio = $info['Inmueble']['precio_venta'];
    if ($precio == 0) {
      $precio = $info['Inmueble']['precio_alquiler'];
      if ($precio == 0) {
        $precio = $info['Inmueble']['precio_traspaso'];
      }
    }
    if ($precio == 0) {
      return '';
    }
    $honor = (int) $info['Inmueble']['honor_agencia'];
    $honor_unid = strtolower($info['Inmueble']['honor_agencia_unid']);
    if ($honor == 0) {
      return '';
    }
    $result = '';
    switch ($honor_unid) {
      case 'e':
        $result = (int) $precio - $honor;
        break;
      case '%':
	      $result = (float) $precio / (1 + $honor/100);
        break;
    }

    if (is_numeric($result)) {
      $result = $this->Number->format($result, array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . ' &euro;';
    }

    return $result;
  }

  /**
   * @param $info
   * @return null|string
   */
  public function getPrecioMedioMetro($info) {

    $tipos = array('Piso', 'Chalet', 'Local', 'Nave', 'Oficina');
    foreach ($tipos as $tipo) {
      if (isset($info[$tipo]['area_total_construida']) && !empty($info[$tipo]['area_total_construida'])) {
        $metros = $info[$tipo]['area_total_construida'];
        break;
      }
    }
    if (!isset($metros)) {
      return null;
    }

    $precio = $info['Inmueble']['precio_venta'];
    if ($precio == 0) {
      $precio = $info['Inmueble']['precio_alquiler'];
      if ($precio == 0) {
        $precio = $info['Inmueble']['precio_traspaso'];
      }
    }

    $precio_metro = round($precio / $metros, 2);

    $result = $this->Number->format($precio_metro, array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . ' ' . $info['TipoMoneda']['symbol'] . ' /m<sup>2</sup>.';

    return $result;
  }

	/**
	 * @param $info
	 * @param string $tam
	 * @param $idx
	 * @param array $options
	 *
	 * @return string
	 */
	public function getImageIndex($info, $tam = 'p', $idx, $options = array()) {
		if (empty($info['Imagen']) || (!isset($info['Imagen'][$idx]))) {

			if (isset($options['nohtml']) && $options['nohtml'] == true) {
				return "$tam/sin_fotos.png";
			} else {
				$result = $this->Html->image( "/noauth/image/$tam/sin_fotos.png", $options );
			}

		} else {

			$image = str_replace('/', '|', $info['Imagen'][$idx]['path']) . '|' . $info['Imagen'][$idx]['fichero'];
			if (!isset($options['alt'])) {
				$options['alt'] = $info['Imagen'][$idx]['descripcion'];
				$options['fullBase'] = true;
			}

			if (!isset($options['no_forzar']) && isset($info['Imagen'][$idx]['tipo_imagen_id']) && $info['Imagen'][$idx]['tipo_imagen_id'] == '07') {
				$tam = 'o';
			}

			if (isset($options['nohtml']) && $options['nohtml'] == true) {
                $pref = ($tam != 'o') ? $tam . '_' : '';
                $result = $info['Imagen'][$idx]['path'] . '/' . $pref . $info['Imagen'][$idx]['fichero'];
			} else {
				$result = $this->Html->image($img = "/noauth/image/$tam/$image", $options);
			}

		}
		return $result;
	}

  /**
   * @param $info
   * @param string $tam
   * @param array $options
   * @return string
   */
  public function getFirstImage($info, $tam = 'p', $options = array()) {
	  return $this->getImageIndex($info, $tam, 0, $options);
  }

	/**
	 * @param $info
	 * @param string $tam
	 * @param array $options
	 * @return string
	 */
	public function getPlano($info, $tam = 'p', $options = array()) {
		if (empty($info['Imagen'])) {
			$result = '';
		} else {
			$idx=0;
			$result = '';
			foreach ($info['Imagen'] as $imagen) {
				if ($imagen['tipo_imagen_id'] == '07') {
					if (isset($options['original']) && $options['original'] == false) {
						$options['no_forzar'] = true;
					}
					$result = $this->getImageIndex($info, $tam, $idx, $options);

					break;
				}
				$idx++;
			}
		}
		return $result;
	}

  /**
   * @param $info
   * @param array $options
   * @return array
   */
  public function getAllImages($info, $options = array()) {

	  if (empty($info['Imagen'])) {
		  return array();
	  }

    $result = array();
    foreach ($info['Imagen'] as $imagen) {
      $image_file = str_replace('/', '|', $imagen['path']) . '|' . $imagen['fichero'];

      $alt = $imagen['descripcion'];
      if (empty($alt)) {
        $alt = $imagen['TipoImagen']['description'];
      }

      $options['alt'] = $alt;
      $options['itemprop'] = $this->Html->assetUrl("/noauth/image/size/$image_file");
	    $options['itemtype'] = $imagen['tipo_imagen_id'];

			if ($imagen['tipo_imagen_id'] == '07') {
				$tipo_p = 'o';
				$tipo_m = 'o';
				$tipo_g = 'o';
			} else {
				$tipo_p = 'p';
				$tipo_m = 'm';
				$tipo_g = 'g';
			}

      $result[] = array(
        'id' => $imagen['id'],
        'title' => $options['alt'],
        'type-id' => $imagen['TipoImagen']['id'],
        'type-desc' => $imagen['TipoImagen']['description'],
        'src-p' => "/noauth/image/$tipo_p/$image_file",
        'src-m' => "/noauth/image/$tipo_m/$image_file",
        'src-g' => "/noauth/image/$tipo_g/$image_file",
        'url-p' => $this->Html->image("/noauth/image/$tipo_p/$image_file", $options),
        'url-m' => $this->Html->image("/noauth/image/$tipo_m/$image_file", $options),
        'url-g' => $this->Html->image("/noauth/image/$tipo_g/$image_file", $options));
    }
    return $result;
  }

	/**
	 * @param $info
	 * @param array $options
	 * @return array
	 */
	public function getAllDocuments($info, $options = array()) {

		if (empty($info['Documento'])) {
			return array();
		}

		$result = array();
		foreach ($info['Documento'] as $doc) {
			//$doc_file = str_replace('/', '|', $doc['path']) . '|' . $doc['fichero'];

			$result[] = array(
				'id' => $doc['id'],
				'desc' => $doc['descripcion'],
				'inmueble_id' => $doc['inmueble_id'],
				'type' => $doc['tipo'],
				'name' => $doc['nombre'],
				'url' => $this->Html->assetUrl('/noauth/document/' . $doc['id'] . '/' . $doc['inmueble_id']));
		}
		return $result;
	}

	/**
	 * @param $info
	 * @param $agencia
	 * @return string
	 */
	public function getMarkersMap($info, $agencia) {
		$result = '';

		$coma = '';
		foreach ($info as $item) {
			if (empty($item['Inmueble']['coord_x']) || empty($item['Inmueble']['coord_y'])) {
				continue;
			}

			$propio = ($agencia['Agencia']['id'] == $item['Inmueble']['agencia_id']) ? 1 : 0;

			$provincia = str_replace("'", "\'", $item['Inmueble']['provincia']);
			$poblacion = str_replace("'", "\'", $item['Inmueble']['poblacion']);

			$coord_x = (float) $item['Inmueble']['coord_x'];
			$coord_y = (float) $item['Inmueble']['coord_y'];

			if (!$propio) {
				$coord_x += 0.001;
				$coord_y -= 0.001;
			}

			$result .= $coma . "['$poblacion,$provincia',$coord_x,$coord_y,$propio]\r\n";
			$coma = ',';
		}
		return $result;
	}

	/**
	 * @param $info
	 * @param $url_64
	 * @return string
	 */
	public function getInfoMarkersMap($info, $url_64) {
		$result = '';

		$coma = '';
		foreach ($info as $item) {
			if (empty($item['Inmueble']['coord_x']) || empty($item['Inmueble']['coord_y'])) {
				continue;
			}

			$link = 'view/' . $item['Inmueble']['id'] . '/' . $url_64;

			$descripcion = str_replace("'", "\'", $this->printDescripcion($item));
			$referencia = $item['Inmueble']['referencia'];
			$foto = $this->Html->link($this->getFirstImage($item, 'p'), $link, array('escape' => false));

			$result .= $coma . "['<div class=\"info_content\"><p>$referencia. $descripcion</p><p>$foto</p>']\r\n";
			$coma=',';
		}

		return $result;
	}

	/**
	 * @param string $tam
	 * @param null $img
	 * @return string
	 */
	public function getImageFile($tam = 'm', $img = null) {
		$config = Configure::read('alfainmo');
		$folder = $config ['images.path'];

		$pref = ($tam != 'o') ? $tam . '_' : '';

		if ($img == null) {
			$result = $folder . $pref . 'sin_fotos.png';
		} else {
			$img = str_replace('|', '/', $img);
			$ext = pathinfo($img, PATHINFO_EXTENSION);

			$path = pathinfo($img, PATHINFO_DIRNAME);
			if ($path == '.') {
				$path = '';
			}

			$basename = pathinfo($img, PATHINFO_BASENAME);
			$result = $folder . $path . DIRECTORY_SEPARATOR . $pref . $basename;
		}

		return $result;
	}

	/**
	 * Escribe la información asociada a un evento
	 * @param $evento
	 */
	public function printEventoInfo($evento, &$infoaux) {

		if ($evento['TipoEvento']['type'] <= 2) {

			switch ($evento['TipoEvento']['info_type']) {
				case 'v':
					$inmueble = $evento['Evento']['numero'];
					$zona = $evento['Evento']['numero2'];
					$edificio = $evento['Evento']['numero3'];
					echo "Inmueble: <strong>$edificio</strong>. Zona: <strong>$zona</strong>. Edificio: <strong>$inmueble</strong>.";
					break;
				case 't':
				case 'm':
					echo $evento['Evento']['texto'];
					break;
			}

		} else if ($evento['TipoEvento']['type'] == 3) {

			$tipo_evento_id = $evento['Evento']['tipo_evento_id'];
			switch ($tipo_evento_id) {
				case 30: // Cambio precio de compra
				case 31: // Cambio precio de alquiler
				case 32: // Cambio precio de traspaso
					$precio1 = $this->Number->format((int) $evento['Evento']['numero2'], array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ','));
					$precio2 = $this->Number->format((int) $evento['Evento']['numero'], array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ','));
					echo "$precio1 <i class='glyphicon glyphicon-chevron-right' style='color:#AAA'></i> $precio2";
					break;

				case 40: // Cambio en compartición de honorarios
					$estado1 = $evento['Evento']['numero2'];
					$estado2 = $evento['Evento']['numero'];
					echo "$estado1 <i class='glyphicon glyphicon-chevron-right' style='color:#AAA'></i> $estado2";
					break;

				case 34: // Comprobación de duplicados
					echo $evento['Evento']['texto'];
					break;

				case 35: // Cambio de dirección
				case 36: // Cambio de referencia catastral
					$txt1 = $evento['Evento']['texto2'];
					$txt2 = $evento['Evento']['texto'];
					echo "$txt1 <i class='glyphicon glyphicon-chevron-right' style='color:#AAA'></i> $txt2";
					break;

				case 33: // Cambio de estado
				case 38: // Cambio de tipo de encargo

					if ($evento['Evento']['numero2'] > 0) {
						$txt1 = str_pad($evento['Evento']['numero2'], 2, "0", STR_PAD_LEFT);
						$txt2 = str_pad($evento['Evento']['numero'], 2, "0", STR_PAD_LEFT);
					} else {
						$txt1 = $evento['Evento']['texto2'];
						$txt2 = $evento['Evento']['texto'];
					}

					if (isset($infoaux[$tipo_evento_id][$txt1])) {
						$txt1 = $infoaux[$tipo_evento_id][$txt1];
					}
					if (isset($infoaux[$tipo_evento_id][$txt2])) {
						$txt2 = $infoaux[$tipo_evento_id][$txt2];
					}
					echo "$txt1 <i class='glyphicon glyphicon-chevron-right' style='color:#AAA'></i> $txt2";
					break;

				case 37: // Cambio de honorarios
				case 39: // Cambio en honorarios de alquiler
					$precio1 = $this->Number->format((int) $evento['Evento']['numero2'], array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ','));
					$precio2 = $this->Number->format((int) $evento['Evento']['numero'], array('places' => 0, 'before' => false, 'thousands' => '.', 'decimals' => ','));
					$tipo = $evento['Evento']['texto'];
					echo "$precio1 $tipo<i class='glyphicon glyphicon-chevron-right' style='color:#AAA'></i> $precio2 $tipo";
					break;
			}
		}
	}

	/**
	 * @param null $videoString
	 *
	 * @return array
	 */
	function parseVideos($videoString = null)	{
		// return data
		$videos = array();

		if (!empty($videoString)) {

			// split on line breaks
			$videoString = stripslashes(trim($videoString));
			$videoString = explode("\n", $videoString);
			$videoString = array_filter($videoString, 'trim');

			// check each video for proper formatting
			foreach ($videoString as $video) {

				// check for iframe to get the video url
				if (strpos($video, 'iframe') !== FALSE) {
					// retrieve the video url
					$anchorRegex = '/src="(.*)?"/isU';
					$results = array();
					if (preg_match($anchorRegex, $video, $results)) {
						$link = trim($results[1]);
					}
				} else {
					// we already have a url
					$link = $video;
				}

				// if we have a URL, parse it down
				if (!empty($link)) {

					// initial values
					$video_id = NULL;
					$videoIdRegex = NULL;
					$results = array();

					// check for type of youtube link
					if (strpos($link, 'youtu') !== FALSE) {
						if (strpos($link, 'youtube.com') !== FALSE) {
							// works on:
							// http://www.youtube.com/embed/VIDEOID
							// http://www.youtube.com/embed/VIDEOID?modestbranding=1&amp;rel=0
							// http://www.youtube.com/v/VIDEO-ID?fs=1&amp;hl=en_US
							$videoIdRegex = '/youtube.com\/(?:embed|v){1}\/([a-zA-Z0-9_\-]+)\?\-?/i';
							
						} else if (strpos($link, 'youtu.be') !== FALSE) {
							// works on:
							// http://youtu.be/daro6K6mym8
							$videoIdRegex = '/youtu.be\/([a-zA-Z0-9_]+)\?\-?/i';
						}

						if ($videoIdRegex !== NULL) {
							if (preg_match($videoIdRegex, $link, $results)) {
								$video_str = 'http://www.youtube.com/v/%s?fs=1&amp;autoplay=1';
								$thumbnail_str = 'http://img.youtube.com/vi/%s/2.jpg';
								$fullsize_str = 'http://img.youtube.com/vi/%s/0.jpg';
								$video_id = $results[1];
							}
						}
					}

					// handle vimeo videos
					else if (strpos($video, 'vimeo') !== FALSE) {
						if (strpos($video, 'player.vimeo.com') !== FALSE) {
							// works on:
							// http://player.vimeo.com/video/37985580?title=0&amp;byline=0&amp;portrait=0
							$videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
						} else {
							// works on:
							// http://vimeo.com/37985580
							$videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';
						}

						if ($videoIdRegex !== NULL) {
							if (preg_match($videoIdRegex, $link, $results)) {
								$video_id = $results[1];

								// get the thumbnail
								try {
									$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
									if (!empty($hash) && is_array($hash)) {
										$video_str = 'http://vimeo.com/moogaloop.swf?clip_id=%s';
										$thumbnail_str = $hash[0]['thumbnail_small'];
										$fullsize_str = $hash[0]['thumbnail_large'];
									} else {
										// don't use, couldn't find what we need
										unset($video_id);
									}
								} catch (Exception $e) {
									unset($video_id);
								}
							}
						}
					}

					// check if we have a video id, if so, add the video metadata
					if (!empty($video_id)) {
						// add to return
						$videos[] = array(
								'url' => sprintf($video_str, $video_id),
								'thumbnail' => sprintf($thumbnail_str, $video_id),
								'fullsize' => sprintf($fullsize_str, $video_id)
						);
					}
				}

			}

		}

		// return array of parsed videos
		return $videos;
	}

}
