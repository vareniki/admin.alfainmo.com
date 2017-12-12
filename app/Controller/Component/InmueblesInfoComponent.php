<?php

App::uses( 'SessionComponent', 'Controller' );

define( 'IMAGEN_G', 800 );
define( 'IMAGEN_M', 296 );
define( 'IMAGEN_P', 148 );

class InmueblesInfoComponent extends SessionComponent {

	private static $aliases = array(
			'Chalet',
			'Garaje',
			'Inmueble',
			'Oficina',
			'Piso',
			'Terreno',
			'Local',
			'Nave',
			'Otro',
			'Contacto',
			'Propietario'
	);

	/**
	 * @param $origFile
	 * @param $thumbFile
	 * @param $thumbWidth
	 */
	private function createThumb( $origFile, $thumbFile, $thumbWidth ) {

		$img    = imagecreatefromjpeg( $origFile );
		$width  = imagesx( $img );
		$height = imagesy( $img );

		$new_width  = $thumbWidth;
		$new_height = floor( $height * ( $thumbWidth / $width ) );

		$tmp_img = imagecreatetruecolor( $new_width, $new_height );
		imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		imagejpeg( $tmp_img, $thumbFile );
	}

	/**
	 * @param $inmuebleId
	 * @param $img
	 *
	 * @return array|bool
	 */
	public function addFoto( $inmuebleId, $img ) {

		// Comprueba que se haya pasado una imagen
		if ( empty( $img ) || ( $img_info = getimagesize( $img ) ) === false ) {
			return false;
		}

		switch ( $img_info[2] ) {
			case IMAGETYPE_GIF :
				$src_img = imagecreatefromgif( $img );
				break;
			case IMAGETYPE_JPEG :
				$src_img = imagecreatefromjpeg( $img );
				break;
			case IMAGETYPE_PNG :
				$src_img = imagecreatefrompng( $img );
				break;
			case IMAGETYPE_WBMP:
				$src_img = imagecreatefromwbmp( $img );
				break;
			default:
				return false;
		}

		// Generamos la nueva imagen
		$dst_img = imagecreatetruecolor( $img_info[0], $img_info[1] );
		$white   = imagecolorallocate( $dst_img, 255, 255, 255 );
		imagefill( $dst_img, 0, 0, $white );

		imagecopy( $dst_img, $src_img, 0, 0, 0, 0, $img_info[0], $img_info[1] );

		// Obtiene un nuevo nombre para el fichero
		$config = Configure::read( 'alfainmo' );
		$path   = $config ['images.path'] . str_replace( '/', DIRECTORY_SEPARATOR, date( 'Y/m' ) . '/' );

		if ( ! file_exists( $path ) ) {
			mkdir( $path, 0777, true );
		}

		$fichero     = null;
		$nombre_base = str_pad( (int) $inmuebleId, 7, '0', STR_PAD_LEFT );
		$orden       = 0;
		do {
			$orden ++;
			$fichero = $nombre_base . '-' . str_pad( $orden, 2, '0', STR_PAD_LEFT ) . '.jpg';
		} while ( file_exists( $path . $fichero ) );

		// Guardamos la nueva imagen
		imagejpeg( $dst_img, $path . $fichero );

		unset( $src_img );
		unset( $dst_img );

		// Crea las miniaturas
		$this->createThumb( $path . $fichero, $path . 'g_' . $fichero, IMAGEN_G );
		$this->createThumb( $path . $fichero, $path . 'm_' . $fichero, IMAGEN_M );
		$this->createThumb( $path . $fichero, $path . 'p_' . $fichero, IMAGEN_P );

		$result                             = array();
		$result['Imagen']['path']           = date( 'Y/m' );
		$result['Imagen']['fichero']        = $fichero;
		$result['Imagen']['inmueble_id']    = $inmuebleId;
		$result['Imagen']['orden']          = $orden;
		$result['Imagen']['tipo_imagen_id'] = '00';
		$result['Imagen']['descripcion']    = '(nueva foto)';

		@unlink( $img );

		return $result;
	}

	/**
	 * @param $inmuebleId
	 * @param $info
	 *
	 * @return array
	 */
	public function addDocumento( $inmuebleId, $info ) {

		// Comprueba que se haya pasado una imagen
		if ( empty( $info ) ) {
			return false;
		}
		$config = Configure::read( 'alfainmo' );

		$path = $config['documents.path'] . str_replace( '/', DIRECTORY_SEPARATOR, date( 'Y/m' ) . '/' );
		if ( ! file_exists( $path ) ) {
			mkdir( $path, 0777, true );
		}
		$file_ext = pathinfo( $info['name'], PATHINFO_EXTENSION );

		$file        = null;
		$nombre_base = 'd_' . str_pad( (int) $inmuebleId, 7, '0', STR_PAD_LEFT );
		$orden       = 0;
		do {
			$orden ++;
			$file = $nombre_base . '-' . str_pad( $orden, 2, '0', STR_PAD_LEFT ) . '.' . $file_ext;
		} while ( file_exists( $path . $file ) );

		// Copia el archivo y devuelve el array
		if ( ! copy( $info['tmp_name'], $path . $file ) ) {
			return false;
		}

		$result                             = array();
		$result['Documento']['inmueble_id'] = $inmuebleId;
		$result['Documento']['path']        = date( 'Y/m' );
		$result['Documento']['fichero']     = $file;
		$result['Documento']['tipo']        = $info['type'];
		$result['Documento']['nombre']      = $info['name'];
		$result['Documento']['descripcion'] = $info['name'];

		return $result;
	}

	/**
	 * @param $image
	 */
	public function delFoto( $image ) {
		$config = Configure::read( 'alfainmo' );
		$folder = $config ['images.path'];

		$img_path = $folder . $image['Imagen']['path'] . DIRECTORY_SEPARATOR;
		$img_name = $image['Imagen']['fichero'];

		// Comprueba que la oficina que manda eliminar la imagen sea la misma que la que posee la imagen
		$img_files[] = $img_path . $img_name;
		$img_files[] = $img_path . 'g_' . $img_name;
		$img_files[] = $img_path . 'm_' . $img_name;
		$img_files[] = $img_path . 'p_' . $img_name;
		foreach ( $img_files as $img_file ) {
			unlink( $img_file );
		}
	}

	/**
	 * @param $doc
	 */
	public function delDocumento( $doc ) {
		$config = Configure::read( 'alfainmo' );
		$folder = $config['documents.path'];

		$doc_path = $folder . $doc['Documento']['path'] . DIRECTORY_SEPARATOR;
		$doc_name = $doc['Documento']['fichero'];

		unlink( $doc_path . $doc_name );
	}

	/**
	 * Valida que se hayan creado los thumbnails de las imágenes. Los tamaños son:
	 * g_ = 590px de ancho.
	 * m_ = 296px de ancho.
	 * p_ = 148px de ancho
	 *
	 * @param $info
	 */
	public function validarThumbnails( $info ) {
		if ( empty( $info['Imagen'] ) ) {
			return;
		}
		$config = Configure::read( 'alfainmo' );
		$folder = $config ['images.path'];

		foreach ( $info['Imagen'] as $imagen ) {

			$path = $folder . str_replace( '/', DIRECTORY_SEPARATOR, $imagen['path'] . '/' );

			$fichero   = $path . $imagen['fichero'];
			$fichero_g = $path . 'g_' . $imagen['fichero'];
			$fichero_m = $path . 'm_' . $imagen['fichero'];
			$fichero_p = $path . 'p_' . $imagen['fichero'];

			if ( ! file_exists( $fichero_g ) ) {
				$this->createThumb( $fichero, $fichero_g, IMAGEN_G );
			}
			if ( ! file_exists( $fichero_m ) ) {
				$this->createThumb( $fichero, $fichero_m, IMAGEN_M );
			}
			if ( ! file_exists( $fichero_p ) ) {
				$this->createThumb( $fichero, $fichero_p, IMAGEN_P );
			}
		}
	}

	/**
	 * @param $info
	 * @param $lastInfo
	 *
	 * @return array
	 */
	public function getActualizacionCambios( $info, $lastInfo, $agencia, $agente, $checkdup ) {

		$result = array();

		if ( empty( $info ) || empty( $lastInfo ) ) {
			return;
		}
		$agencia_id = isset( $agencia['id'] ) ? $agencia['id'] : null;
		$agente_id  = isset( $agente['id'] ) ? $agente['id'] : null;

		// Cambios de precio
		if ( ! empty( $info['Inmueble']['precio_venta'] ) && ! empty( $lastInfo['Inmueble']['precio_venta'] )
		     && $info['Inmueble']['precio_venta'] <> $lastInfo['Inmueble']['precio_venta']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 30,
					'inmueble_id'    => $info['Inmueble']['id'],
					'numero'         => (int) $info['Inmueble']['precio_venta'],
					'numero2'        => (int) $lastInfo['Inmueble']['precio_venta'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		if ( ! empty( $info['Inmueble']['precio_alquiler'] ) && ! empty( $lastInfo['Inmueble']['precio_alquiler'] )
		     && $info['Inmueble']['precio_alquiler'] <> $lastInfo['Inmueble']['precio_alquiler']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 31,
					'inmueble_id'    => $info['Inmueble']['id'],
					'numero'         => (int) $info['Inmueble']['precio_alquiler'],
					'numero2'        => (int) $lastInfo['Inmueble']['precio_alquiler'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		if ( ! empty( $info['Inmueble']['precio_traspaso'] ) && ! empty( $lastInfo['Inmueble']['precio_traspaso'] )
		     && $info['Inmueble']['precio_traspaso'] <> $lastInfo['Inmueble']['precio_traspaso']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 32,
					'inmueble_id'    => $info['Inmueble']['id'],
					'numero'         => (int) $info['Inmueble']['precio_traspaso'],
					'numero2'        => (int) $lastInfo['Inmueble']['precio_traspaso'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		// Cambio de estado (33)
		if ( ! empty( $info['Inmueble']['estado_inmueble_id'] ) && ! empty( $lastInfo['Inmueble']['estado_inmueble_id'] )
		     && $info['Inmueble']['estado_inmueble_id'] <> $lastInfo['Inmueble']['estado_inmueble_id']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 33,
					'inmueble_id'    => $info['Inmueble']['id'],
					'numero'         => (int) $info['Inmueble']['estado_inmueble_id'],
					'numero2'        => (int) $lastInfo['Inmueble']['estado_inmueble_id'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		// Cambio en la dirección (35)
		if ( ( $info['Inmueble']['nombre_calle'] <> $lastInfo['Inmueble']['nombre_calle'] )
		     || ( $info['Inmueble']['numero_calle'] <> $lastInfo['Inmueble']['numero_calle'] )
         || ( $info['Inmueble']['codigo_postal'] <> $lastInfo['Inmueble']['codigo_postal'] )
         || ( $info['Inmueble']['poblacion'] <> $lastInfo['Inmueble']['poblacion'] )
         || ( $info['Inmueble']['provincia'] <> $lastInfo['Inmueble']['provincia'] )
		) {

			$calle1 = $info['Inmueble']['nombre_calle'];
			if ( ! empty( $info['Inmueble']['numero_calle'] ) ) {
				$calle1 .= ', ' . $info['Inmueble']['numero_calle'];
			}

			$calle2 = $lastInfo['Inmueble']['nombre_calle'];
			if ( ! empty( $lastInfo['Inmueble']['numero_calle'] ) ) {
				$calle2 .= ', ' . $lastInfo['Inmueble']['numero_calle'];
			}

			if (( $info['Inmueble']['codigo_postal'] <> $lastInfo['Inmueble']['codigo_postal'] )
          || ( $info['Inmueble']['poblacion'] <> $lastInfo['Inmueble']['poblacion'] )
          || ( $info['Inmueble']['provincia'] <> $lastInfo['Inmueble']['provincia'] ))
			{

        $calle1 .= ' (' . $info['Inmueble']['codigo_postal'] . ' - ' . $info['Inmueble']['poblacion'] . ' - ' . $info['Inmueble']['provincia'] . ')';
        $calle2 .= ' (' . $lastInfo['Inmueble']['codigo_postal'] . ' - ' . $lastInfo['Inmueble']['poblacion'] . ' - ' . $lastInfo['Inmueble']['provincia'] . ')';
      }

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 35,
					'inmueble_id'    => $info['Inmueble']['id'],
					'texto'          => $calle1,
					'texto2'         => $calle2,
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		// Cambio en referencia catastral (36)
		if ( ! empty( $info['Inmueble']['ref_catastral'] ) && ! empty( $lastInfo['Inmueble']['ref_catastral'] )
		     && $info['Inmueble']['ref_catastral'] <> $lastInfo['Inmueble']['ref_catastral']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 36,
					'inmueble_id'    => $info['Inmueble']['id'],
					'texto'          => $info['Inmueble']['ref_catastral'],
					'texto2'         => $lastInfo['Inmueble']['ref_catastral'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		// Cambio en honorarios (37)
		if ( ! empty( $info['Inmueble']['honor_agencia'] ) && ! empty( $lastInfo['Inmueble']['honor_agencia'] )
		     && $info['Inmueble']['honor_agencia'] <> $lastInfo['Inmueble']['honor_agencia']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 37,
					'inmueble_id'    => $info['Inmueble']['id'],
					'numero'         => (int) $info['Inmueble']['honor_agencia'],
					'numero2'        => (int) $lastInfo['Inmueble']['honor_agencia'],
					'texto'          => $info['Inmueble']['honor_agencia_unid'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		// Cambio en tipo de encargo (38)
		if ( ! empty( $info['Inmueble']['tipo_contrato_id'] ) && ! empty( $lastInfo['Inmueble']['tipo_contrato_id'] )
		     && $info['Inmueble']['tipo_contrato_id'] <> $lastInfo['Inmueble']['tipo_contrato_id']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 38,
					'inmueble_id'    => $info['Inmueble']['id'],
					'texto'          => $info['Inmueble']['tipo_contrato_id'],
					'texto2'         => $lastInfo['Inmueble']['tipo_contrato_id'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		// Cambio en honorarios (39)
		if ( ! empty( $info['Inmueble']['honor_agencia_alq'] ) && ! empty( $lastInfo['Inmueble']['honor_agencia_alq'] )
		     && $info['Inmueble']['honor_agencia_alq'] <> $lastInfo['Inmueble']['honor_agencia_alq']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 39,
					'inmueble_id'    => $info['Inmueble']['id'],
					'numero'         => (int) $info['Inmueble']['honor_agencia_alq'],
					'numero2'        => (int) $lastInfo['Inmueble']['honor_agencia_alq'],
					'texto'          => $info['Inmueble']['honor_agencia_alq_unid'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		// Cambio en honorarios compartidos (40)
		if ( ! empty( $info['Inmueble']['honor_compartidos'] ) && ! empty( $lastInfo['Inmueble']['honor_compartidos'] )
		     && $info['Inmueble']['honor_compartidos'] <> $lastInfo['Inmueble']['honor_compartidos']
		) {

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 40,
					'inmueble_id'    => $info['Inmueble']['id'],
					'numero'         => (int) $info['Inmueble']['honor_compartidos'],
					'numero2'        => (int) $lastInfo['Inmueble']['honor_compartidos'],
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		// Comprobación de duplicados (34)
		if ( $info['Inmueble']['estado_inmueble_id'] == '01' && $checkdup ) {

			$calle = $info['Inmueble']['nombre_calle'];
			if ( ! empty( $info['Inmueble']['numero_calle'] ) ) {
				$calle .= ', ' . $info['Inmueble']['numero_calle'];
				$calle .= ' (' . $info['Inmueble']['codigo_postal'] . ' - ' . $info['Inmueble']['provincia'] . ')';
			}

			$result[] = array(
					'fecha'          => date( 'Y-m-d H:i:s' ),
					'tipo_evento_id' => 34,
					'inmueble_id'    => $info['Inmueble']['id'],
					'texto'          => $calle,
					'agente_id'      => $agente_id,
					'agencia_id'     => $agencia_id
			);
		}

		return $result;
	}

	/**
	 * @param $info
	 * @param array $classes
	 *
	 * @return mixed
	 */
	public function depurarInfoInmueble( $info, $classes = array() ) {

		foreach ( self::$aliases as $alias ) {
			if ( ! isset( $info[ $alias ] ) || ! is_array( $info[ $alias ] ) ) {
				continue;
			}

			$info_alias = &$info[ $alias ];

			foreach ( $classes as $class ) {
				if ( ! isset( $info_alias[ $class ] ) || ! is_array( $info_alias[ $class ] ) ) {
					continue;
				}

				foreach ( $info_alias[ $class ] as $key => $value ) {
					$info_alias[ $class ][ $key ] = $value['id'];
				}
			}
		}

		return $info;
	}

	/**
	 * @param $request
	 * @param $agencia
	 * @param $is_central
	 *
	 * @return array
	 */
	public function crearBusqueda( $request, $agencia, $is_central ) {

		$conditions = array('Agencia.active' => 't');

		if (!$is_central) {
			$id_agencia = $agencia['id'];
			$conditions[] = "(Agencia.solo_central <> 't' OR Agencia.id=$id_agencia)";
		}
		
		// El resto de las condiciones
		if ( empty($request['q']) && empty($request['data_polygons'])
		     && !empty($request['inc_todas_agencias']) && empty($request['portal_id']) ) {
			//return $conditions;
		}

		/**
		 *  operacion, texto, tipo-inmueble
		 */

		// Tipo de inmueble
		if ( ! empty( $request['tipo'] ) ) {
			$conditions['Inmueble.tipo_inmueble_id'] = $request['tipo'];
		}

		// Subtipo de inmueble
		if ( ! empty( $request['subtipo'] ) ) {
			$subtipo = $request['subtipo'];

			$subcond_or   = array();
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '01' AND Piso.tipo_piso_id = '$subtipo')";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.tipo_chalet_id = '$subtipo')";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.tipo_oficina_id = '$subtipo')";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '05' AND Garaje.tipo_garaje_id = '$subtipo')";

			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Tipo de operación
		if ( ! empty( $request['operacion'] ) ) {
			switch ( $request['operacion'] ) {
				case 'ven':
					$conditions['Inmueble.es_venta'] = 't';
					break;
				case 'alq':
					$conditions['Inmueble.es_alquiler'] = 't';
					break;
				case 'tra':
					$conditions['Inmueble.es_traspaso'] = 't';
					break;
				case 'opc':
					$conditions['Inmueble.es_opcion_compra'] = 't';
					break;
			}
		}

		if (isset($request['precio_min'])) {
      $precio_min = (int) $request['precio_min'];
    } else {
      $precio_min = 0;
    }

    if (isset($request['precio'])) {
      $precio_max = (int) $request['precio'];
    } else {
      $precio_max = 0;
    }

    // Precios mínimos y máximos
    if ($precio_min > 0 && $precio_max > 0) {

        $subcond_or  = array();
        $subcond_or[] = "Inmueble.precio_venta BETWEEN $precio_min AND $precio_max AND Inmueble.es_venta='t'";
        $subcond_or[] = "Inmueble.precio_alquiler BETWEEN $precio_min AND $precio_max AND Inmueble.es_alquiler='t'";
        $subcond_or[] = "Inmueble.precio_traspaso BETWEEN $precio_min AND $precio_max AND Inmueble.es_traspaso='t'";
        $subcond_or = array( 'OR' => $subcond_or );
        $conditions[]['AND'] = $subcond_or;

    } else if ($precio_min > 0) {

        $subcond_or  = array();
        $subcond_or[] = "Inmueble.precio_venta >= $precio_min AND Inmueble.es_venta='t'";
        $subcond_or[] = "Inmueble.precio_alquiler >= $precio_min AND Inmueble.es_alquiler='t'";
        $subcond_or[] = "Inmueble.precio_traspaso >= $precio_min AND Inmueble.es_traspaso='t'";
        $subcond_or = array( 'OR' => $subcond_or );
        $conditions[]['AND'] = $subcond_or;

    } else if ($precio_max > 0) {

        $subcond_or = array();
        $subcond_or[] = "Inmueble.precio_venta <= $precio_max AND Inmueble.es_venta='t'";
        $subcond_or[] = "Inmueble.precio_alquiler <= $precio_max AND Inmueble.es_alquiler='t'";
        $subcond_or[] = "Inmueble.precio_traspaso <= $precio_max AND Inmueble.es_traspaso='t'";
        $subcond_or = array( 'OR' => $subcond_or );
        $conditions[]['AND'] = $subcond_or;
    }

		// Años
		if ( ! empty( $request['anios'] ) ) {
			if ( $request['anios'] == 'on' ) {
				$conditions['Inmueble.es_promocion'] = 't';
			} else {
				$anios               = (int) $request['anios'];
				$anio_construc       = (int) date( 'Y' ) - $anios;
				$subcond_or          = array();
				$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.anio_construccion >= $anio_construc)";
				$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.anio_construccion >= $anio_construc)";
				$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '03' AND Local.anio_construccion >= $anio_construc)";
				$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.anio_construccion >= $anio_construc)";
				$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '07' AND Nave.anio_construccion >= $anio_construc)";
				$subcond_or          = array( 'OR' => $subcond_or );
				$conditions[]['AND'] = $subcond_or;
			}
		}

		// Dormitorios
		if ( ! empty( $request['habitaciones'] ) ) {
			$habitaciones        = (int) $request['habitaciones'];
			$subcond_or          = array();
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.numero_habitaciones >= $habitaciones)";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.numero_habitaciones >= $habitaciones)";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.numero_habitaciones >= $habitaciones)";
			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Baños
		if ( ! empty( $request['banos'] ) ) {
			$banos        = (int) $request['banos'];
			$subcond_or   = array();
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '01' AND (coalesce(Piso.numero_banos, 0) + coalesce(Piso.numero_aseos, 0)) >= $banos)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '02' AND (coalesce(Chalet.numero_banos, 0) + coalesce(Chalet.numero_aseos, 0)) >= $banos)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '03' AND Local.numero_aseos >= $banos)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '04' AND (coalesce(Oficina.numero_banos, 0) + coalesce(Oficina.numero_aseos, 0)) >= $banos)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '07' AND Nave.numero_aseos >= $banos)";

			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Metros mínimos y máximos
		if ( ! empty( $request['min_metros'] ) ) {
			$metros  = (int) $request['min_metros'];
			$subcond_or   = array();
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '01' AND Piso.area_total_construida >= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.area_total_construida >= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '03' AND Local.area_total_construida >= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.area_total_construida >= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '05' AND Garaje.area_total >= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '06' AND Terreno.area_total >= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '07' AND Nave.area_total_construida >= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '08' AND Otro.area_total >= $metros)";

			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		if ( ! empty( $request['max_metros'] ) ) {
			$metros  = (int) $request['max_metros'];
			$subcond_or   = array();
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '01' AND Piso.area_total_construida <= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.area_total_construida <= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '03' AND Local.area_total_construida <= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.area_total_construida <= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '05' AND Garaje.area_total <= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '06' AND Terreno.area_total <= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '07' AND Nave.area_total_construida <= $metros)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '08' AND Otro.area_total <= $metros)";

			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Garaje
		if ( isset( $request['garaje'] ) && $request['garaje'] == 't' ) {
			$subcond_or   = array();
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '01' AND (Piso.con_parking = 't' OR Piso.plazas_parking > 0))";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.plazas_parking > 0)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '03' AND Local.plazas_parking > 0)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.plazas_parking > 0)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '07' AND Nave.plazas_parking > 0)";

			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Ascensor
		if ( isset( $request['ascensor'] ) && $request['ascensor'] == 't' ) {
			$subcond_or   = array();
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '01' AND Piso.numero_ascensores > 0)";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.con_ascensor = 't')";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.numero_ascensores > 0)";

			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Trastero
		if ( isset( $request['trastero'] ) && $request['trastero'] == 't' ) {
			$subcond_or          = array();
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.con_trastero = 't')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.con_trastero = 't')";
			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Piscina
		if ( isset( $request['piscina'] ) && $request['piscina'] == 't' ) {
			$subcond_or          = array();
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.con_piscina = 't')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.con_piscina = 't')";
			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Aire acondicionado
		if ( isset( $request['aire'] ) && $request['aire'] == 't' ) {
			$subcond_or          = array();
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.tipo_aa_id IS NOT NULL AND Piso.tipo_aa_id <> '03')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.tipo_aa_id IS NOT NULL AND Chalet.tipo_aa_id <> '03')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '03' AND Local.tipo_aa_id IS NOT NULL AND Local.tipo_aa_id <> '03')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.tipo_aa_id IS NOT NULL AND Oficina.tipo_aa_id <> '03')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '07' AND Nave.tipo_aa_id IS NOT NULL AND Nave.tipo_aa_id <> '03')";
			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Llaves
		if ( isset( $request['llaves'] ) && $request['llaves'] == 't' ) {
			$conditions[] = "Inmueble.llaves_oficina IS NOT NULL AND Inmueble.llaves_oficina = 't'";
		}

		// Tipo de calefaccióm
		if ( ! empty( $request['tipo_calefaccion'] ) ) {
			$tipo                = $request['tipo_calefaccion'];
			$subcond_or          = array();
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.tipo_calefaccion_id = '$tipo')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.tipo_calefaccion_id = '$tipo')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '03' AND Local.tipo_calefaccion_id = '$tipo')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.tipo_calefaccion_id = '$tipo')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '07' AND Nave.tipo_calefaccion_id = '$tipo')";
			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Tipo de equipamiento
		if ( ! empty( $request['tipo_equipamiento'] ) ) {
			$tipo                = $request['tipo_equipamiento'];
			$subcond_or          = array();
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.tipo_equipamiento_id = '$tipo')";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.tipo_equipamiento_id = '$tipo')";
			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// No bajo
		if ( isset( $request['no_bajo'] ) && $request['no_bajo'] == 't' ) {
			$subcond_or          = array();
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.piso NOT IN ('X0', 'X1', '00'))";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.piso NOT IN ('X0', 'X1', '00'))";
			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Bajo
    if ( isset( $request['bajo'] ) && $request['bajo'] == 't' ) {
      $subcond_or          = array();
      $subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND Piso.piso IN ('X0', 'X1', '00'))";
      $subcond_or[]        = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.piso IN ('X0', 'X1', '00'))";
      $subcond_or          = array( 'OR' => $subcond_or );
      $conditions[]['AND'] = $subcond_or;
    }

		// No último
		if ( isset( $request['no_ultimo'] ) && $request['no_ultimo'] == 't' ) {
			$subcond_or          = array();
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '01' AND (Piso.plantas_edificio IS NULL OR Piso.plantas_edificio > cast(regexp_replace(Piso.piso, E'[^0-9]','','gs') AS integer)))";
			$subcond_or[]        = "(Inmueble.tipo_inmueble_id = '04' AND (Oficina.plantas_edificio IS NULL OR Oficina.plantas_edificio > cast(regexp_replace(Piso.piso, E'[^0-9]','','gs') AS integer)))";
			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Con terraza
    if ( isset( $request['terraza'] ) && $request['terraza'] == 't' ) {
      $subcond_or   = array();
      $subcond_or[] = "(Inmueble.tipo_inmueble_id = '01' AND Piso.area_terraza > 0)";
      $subcond_or[] = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.area_terraza > 0)";
      $subcond_or   = array( 'OR' => $subcond_or );
      $conditions[]['AND'] = $subcond_or;
    }

		// Estado del inmueble
		if ( ! empty( $request['estado_inmueble'] ) ) {
			$conditions['Inmueble.estado_inmueble_id'] = $request['estado_inmueble'];
		}

		// Calidad
		if ( ! empty( $request['calidad_precio'] ) ) {
			$conditions['Inmueble.calidad_precio'] = $request['calidad_precio'];
		}

		// Tipo de encargo
		if ( ! empty( $request['tipo_contrato'] ) ) {

      $tipo_contrato = $request['tipo_contrato'];
		  if ($tipo_contrato == 'AI') {

        $subcond_or   = array();
        $subcond_or[] = "(Inmueble.tipo_contrato_id = 'AI')";
        $subcond_or[] = "(Inmueble.tipo_contrato_id = 'PV')";

        $subcond_or   = array( 'OR' => $subcond_or );
        $conditions[]['AND'] = $subcond_or;

      } else {
        $conditions['Inmueble.tipo_contrato_id'] = $tipo_contrato;
      }

		}

		// Motivo de baja
		if ( ! empty( $request['motivo_baja'] ) ) {
			$conditions['Inmueble.motivo_baja_id'] = $request['motivo_baja'];
		}

		// Fecha de captación mínima y máxima
		if ( ! empty( $request['fecha_captacion_min'] ) ) {
			$conditions['Inmueble.fecha_captacion >='] = $request['fecha_captacion_min'];
		}

		if ( ! empty( $request['fecha_captacion_max'] ) ) {
			$conditions['Inmueble.fecha_captacion <='] = $request['fecha_captacion_max'];
		}

		// Fechas de baja mínima y máxima
		if ( ! empty( $request['fecha_baja_min'] ) ) {
			$conditions['Inmueble.fecha_baja >='] = $request['fecha_baja_min'];
		}
		if ( ! empty( $request['fecha_baja_max'] ) ) {
			$conditions['Inmueble.fecha_baja <='] = $request['fecha_baja_max'];
		}

		// Agente
		if ( ! empty( $request['agente_id'] ) ) {
			$agente_id = $request['agente_id'];
			$conditions['Inmueble.agente_id'] = $agente_id;
		}

		// Portales
		if ( ! empty( $request['portal_id'] ) ) {
			$conditions['Portal.id'] = $request['portal_id'];
		}

		if ( ! isset( $request['inc_bajas'] ) || $request['inc_bajas'] != 't' ) {
			$conditions[] = array( 'Inmueble.fecha_baja IS NULL' );
		}

		// Estado de conservación
		if ( ! empty( $request['estado_conservacion'] ) ) {
			$estado = $request['estado_conservacion'];

			$subcond_or   = array();
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '01' AND Piso.estado_conservacion_id = '$estado')";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '02' AND Chalet.estado_conservacion_id = '$estado')";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '03' AND Local.estado_conservacion_id = '$estado')";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '04' AND Oficina.estado_conservacion_id = '$estado')";
			$subcond_or[] = "(Inmueble.tipo_inmueble_id = '07' AND Nave.estado_conservacion_id = '$estado')";

			$subcond_or          = array( 'OR' => $subcond_or );
			$conditions[]['AND'] = $subcond_or;
		}

		// Portales
		//if (!empty($request['idealista'])) {
		//$conditions[]['AND'] = array('Portal.id' => '01');
		//}

		if ( ! empty( $request['pais_id'] ) ) {
			$conditions['Inmueble.pais_id'] = $request['pais_id'];
		}


		if ( ! empty( $request['data_polygons'] ) ) {
      $polygons_search = [];

      $lines = explode( "\n", $request['data_polygons'] );
      foreach ($lines as $line) {

        $params = explode( ',', $line );
        $param_result = '';
        if ( ( count( $params ) >> 1 ) == ( count( $params ) / 2 ) ) {
          for ( $i = 0; $i < count( $params ); $i += 2 ) {
            $param_result .= ',(' . $params[ $i ] . ',' . $params[ $i + 1 ] . ')';
          }
        }

        if ( $param_result != '' ) {
          $param_result  = '(' . substr( $param_result, 1 ) . ')';
          $polygons_search[] = "(Inmueble.coord_x IS NOT NULL AND Inmueble.coord_y IS NOT NULL AND point(Inmueble.coord_x,Inmueble.coord_y) <@ polygon('$param_result'))";
        }
      }

		  if (!empty($polygons_search)) {
        $conditions[]['AND'] = array('OR' => $polygons_search);
      }

		}

		$subconds_or = array();

		if ( !empty( $request['q'] ) ) {
			$or_array = explode( ',', strtolower( $request['q'] ) );
			foreach ( $or_array as $or_tags ) {

				$subconds_and = array();
				foreach ( explode( ' ', $or_tags ) as $tag ) {
					$tag = str_replace( '/', '|', trim( $tag ) );

					if ( strpos( $tag, '|' ) !== false ) {

						$ref = explode( '|', $tag );
						if ( count( $ref ) >= 2 ) {
							$conditions['Inmueble.numero_agencia'] = (int) $ref[0];
							if ( ! empty( $ref[1] ) ) {
								$conditions['Inmueble.codigo'] = (int) $ref[1];
							}
						}
						continue;
					}

					$subcond = array();

					$tag = str_replace("'", "''", $tag);

					$subcond[]["TRANSLATE(Inmueble.poblacion,'áéíóúÁÉÍÓÚ','aeiouAEIOU') ILIKE"]          = "%$tag%";
					$subcond[]["Inmueble.codigo_postal ILIKE"]                                           = "%$tag%";
          $subcond[]["TRANSLATE(Inmueble.zona, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU') ILIKE"]             = "%$tag%";
					$subcond[]["TRANSLATE(Inmueble.nombre_calle, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU') ILIKE"]     = "%$tag%";
					$subcond[]["TRANSLATE(Contacto.nombre_contacto, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU') ILIKE"]  = "%$tag%";
					$subcond[]["Contacto.telefono1_contacto ILIKE"]                                      = "%$tag%";
					$subcond[]["Contacto.telefono2_contacto ILIKE"]                                      = "%$tag%";
					$subcond[]["TRANSLATE(Propietario.nombre_contacto,'áéíóúÁÉÍÓÚ','aeiouAEIOU') ILIKE"] = "%$tag%";
					$subcond[]["Propietario.telefono1_contacto ILIKE"]                                   = "%$tag%";
					$subcond[]["Propietario.telefono2_contacto ILIKE"]                                   = "%$tag%";
					$subcond[]["TRANSLATE(Agente.nombre_contacto, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU') ILIKE"]    = "%$tag%";

					$subconds_and[] = array( 'OR' => $subcond );
				}

				if ( ! empty( $subconds_and ) ) {
					$subconds_or[] = $subconds_and;
				}
			}
		}

		// Mi agencia
		if ( empty( $request['inc_todas_agencias'] ) ) {
			$conditions['Agencia.id'] = $agencia['id'];
		}

		if ( ! empty( $subconds_or ) ) {
			$conditions += array( 'OR' => $subconds_or );
		}

		return $conditions;
	}

	/**
	 * @param $info
	 * @param $campos
	 *
	 * @return bool
	 */
	public function comprobarDatosObligatorios( $info, &$campos ) {

		$result = true;

		$campos = '';

		$precio = 0;
		$precio += ( isset( $info['Inmueble']['precio_venta'] ) ) ? (int) $info['Inmueble']['precio_venta'] : 0;
		$precio += ( isset( $info['Inmueble']['precio_alquiler'] ) ) ? (int) $info['Inmueble']['precio_alquiler'] : 0;
		$precio += ( isset( $info['Inmueble']['precio_traspaso'] ) ) ? (int) $info['Inmueble']['precio_traspaso'] : 0;
		if ( $precio == 0 ) {
			$campos .= ', precio de venta, alquiler o traspaso';
			$result = false;
		}

		// Precio particular venta
		if (isset($info['Inmueble']['tipo_contrato_id']) && ($info['Inmueble']['tipo_contrato_id'] == 'PV' || $info['Inmueble']['tipo_contrato_id'] == 'AI') ) {
			if ( empty( $info['Inmueble']['precio_particular'] ) ) {
				$campos .= ", precio particular vende";
				$result = false;
			}
		}

		if ( isset( $info['Inmueble']['agente_id'] ) && empty( $info['Inmueble']['agente_id'] ) ) {
			$campos .= ', agente comercial';
			$result = false;
		}

		$datos = array(
				'pais_id' => 'país',
				'nombre_calle' => 'calle',
				'numero_calle' => 'número de la calle',
				'codigo_postal' => 'código postal',
				'poblacion' => 'población',
				'provincia' => 'provincia',
				'zona' => 'zona',
				'tipo_contrato_id' => 'tipo de encargo',
				'honor_agencia' => 'honorarios agencia',
				'honor_compartidos' => 'honorarios compartidos'
		);

		if ( $info['Inmueble']['es_venta'] && $info['Inmueble']['es_alquiler'] ) {
			$datos['honor_agencia_alq'] = 'honorarios agencia alquiler';
		}

		foreach ($datos as $dato => $desc) {
			if ( ! isset( $info['Inmueble'][ $dato ] ) || empty( $info['Inmueble'][ $dato ] ) ) {
				$campos .= ', ' . $desc;
				$result = false;
			}
		}

		if ( ! $info['Inmueble']['sin_ref_catastral'] && empty( $info['Inmueble']['ref_catastral'] ) ) {
			$campos .= ', referencia catastral';
			$result = false;
		}

		$datos = array( 'nombre_contacto', 'telefono1_contacto' );
		foreach ( $datos as $dato ) {
			if ( ! isset( $info['Propietario'][ $dato ] ) || empty( $info['Propietario'][ $dato ] ) ) {
				$campos .= ', nombre y teléfono principal del propietario';
				$result = false;
				break;
			}
		}

		switch ( $info['Inmueble']['tipo_inmueble_id'] ) {
			case '01':
				$tipo  = 'Piso';
				$datos = array(
						'area_total_construida' => 'metros construidos',
						'numero_habitaciones' => 'habitaciones',
						'numero_banos' => 'baños',
						'estado_conservacion_id' => 'conservación',
						'interior_exterior_id' => 'interior/exterior',
						'calificacion_energetica_id' => 'calif. energética'
				);
				break;
			case '02':
				$tipo  = 'Chalet';
				$datos = array(
						'area_total_construida' => 'metros construidor',
						'numero_habitaciones' => 'habitaciones',
						'numero_banos' => 'baños',
						'estado_conservacion_id' => 'conservación',
						'interior_exterior_id' => 'interior/exterior',
						'calificacion_energetica_id' => 'calif. energética'
				);
				break;
			case '03':
				$tipo  = 'Local';
				$datos = array(
						'area_total_construida' => 'metros construidos',
						'estado_conservacion_id' => 'conservación',
						'calificacion_energetica_id' => 'calif. energética');
				break;
			case '04':
				$tipo  = 'Oficina';
				$datos = array(
						'area_total_construida' => 'metros construidos',
						'numero_habitaciones' => 'habitaciones',
						'numero_banos' => 'baños',
						'estado_conservacion_id' => 'conservación',
						'interior_exterior_id' => 'interior/exterior',
						'calificacion_energetica_id' => 'calif. energética'
				);
				break;
			case '05':
				$tipo  = 'Garaje';
				$datos = array( 'area_total' => 'superficie' );
				break;
			case '06':
				$tipo  = 'Terreno';
				$datos = array( 'area_total' => 'superficie' );
				break;
			case '07':
				$tipo  = 'Nave';
				$datos = array(
						'area_total_construida' => 'superficie',
						'estado_conservacion_id' => 'conservación',
						'calificacion_energetica_id' => 'calif. energética');
				break;
			case '08':
				$tipo  = 'Otro';
				$datos = array( 'area_total' => 'área total');
				break;
		}
		if ( isset( $tipo ) ) {
			foreach ( $datos as $dato => $desc) {
				if ( ! isset( $info[ $tipo ][ $dato ] ) || $info[ $tipo ][ $dato ] == null ) {
					$campos .= ', ' . $desc;
					$result = false;
				}
			}
		}
		if ( ! isset( $info['_has_imagenes'] ) ) {
			$campos .= ', fotos';
			$result = false;
		}

		if ( strlen( $campos ) > 0 ) {
			$campos = substr( $campos, 2 ) . '.';
		}

		return $result;
	}

	/**
	 * @param $info
	 *
	 * @return array
	 */
	public function getDuplicadosSql( $info ) {
		$conditions = array();

		$conditions['Agencia.active'] = 't';

		$conditions['Inmueble.id <>'] = $info['Inmueble']['id'];
		$conditions['Inmueble.tipo_inmueble_id'] = $info['Inmueble']['tipo_inmueble_id'];
		$conditions[] = "Inmueble.estado_inmueble_id IN ('02', '03', '04')";

		if ( empty( $info['Inmueble']['ref_catastral'] ) || $info['Inmueble']['sin_ref_catastral'] == 't' ) {

			//
			// El inmueble no tiene referencia catastral
			//
			$conditions['Inmueble.codigo_postal'] = $info['Inmueble']['codigo_postal'];
			$nombre_calle = str_replace("'", "''", $info['Inmueble']['nombre_calle']);
			$conditions[] = "Inmueble.nombre_calle ILIKE '$nombre_calle'";
			$conditions['Inmueble.numero_calle'] = $info['Inmueble']['numero_calle'];

			$tipo = $info['Inmueble']['tipo_inmueble_id'];

			if ( $tipo == '06' || $tipo == '08' ) {

				$coord_x = $info['Inmueble']['coord_x'];
				$coord_y = $info['Inmueble']['coord_y'];

				if ($coord_x == '') $coord_x = 0;
				if ($coord_y == '') $coord_y = 0;

				$conditions[] = "round(Inmueble.coord_x::numeric, 8) = round($coord_x, 8)";
				$conditions[] = "round(Inmueble.coord_y::numeric, 8) = round($coord_y, 8)";

			} elseif ( $tipo == '01' ) {

				if ( ! empty( $info['Piso']['bloque'] ) ) {
					$conditions['Piso.bloque'] = $info['Piso']['bloque'];
				}
				if ( ! empty( $info['Piso']['escalera'] ) ) {
					$conditions['Piso.escalera'] = $info['Piso']['escalera'];
				}
				if ( ! empty( $info['Piso']['piso'] ) ) {
					$conditions['Piso.piso'] = $info['Piso']['piso'];
				}
				if ( ! empty( $info['Piso']['puerta'] ) ) {
					$conditions['Piso.puerta'] = $info['Piso']['puerta'];
				}

			} elseif ( $tipo == '02' ) {

				if ( ! empty( $info['Chalet']['bloque'] ) ) {
					$conditions['Chalet.bloque'] = $info['Chalet']['bloque'];
				}

			} elseif ( $tipo == '03' ) {

				if ( ! empty( $info['Local']['bloque'] ) ) {
					$conditions['Local.bloque'] = $info['Local']['bloque'];
				}
				if ( ! empty( $info['Local']['puerta'] ) ) {
					$conditions['Local.puerta'] = $info['Local']['puerta'];
				}

			} elseif ( $tipo == '07' ) {

				if ( ! empty( $info['Nave']['piso'] ) ) {
					$conditions['Nave.piso'] = $info['Nave']['piso'];
				}
				if ( ! empty( $info['Nave']['bloque'] ) ) {
					$conditions['Nave.bloque'] = $info['Nave']['bloque'];
				}
				if ( ! empty( $info['Nave']['puerta'] ) ) {
					$conditions['Nave.puerta'] = $info['Nave']['puerta'];
				}

			} elseif ( $tipo == '04' ) {

				if ( ! empty( $info['Oficina']['bloque'] ) ) {
					$conditions['Oficina.bloque'] = $info['Oficina']['bloque'];
				}
				if ( ! empty( $info['Oficina']['escalera'] ) ) {
					$conditions['Oficina.escalera'] = $info['Oficina']['escalera'];
				}
				if ( ! empty( $info['Oficina']['piso'] ) ) {
					$conditions['Oficina.piso'] = $info['Oficina']['piso'];
				}
				if ( ! empty( $info['Oficina']['puerta'] ) ) {
					$conditions['Oficina.puerta'] = $info['Oficina']['puerta'];
				}

			} elseif ( $tipo == '05' ) {

				if ( ! empty( $info['Garaje']['numero_plaza'] ) ) {
					$conditions['Garaje.numero_plaza'] = $info['Garaje']['numero_plaza'];
				}
			}

		} else {
			//
			// El inmueble sí tiene referencia catastral
			//
      $ref_catastral = $info['Inmueble']['ref_catastral'];
      $conditions[] = "Inmueble.ref_catastral ILIKE '$ref_catastral'";
			$conditions['Inmueble.sin_ref_catastral <>'] = 't';
		}

		return $conditions;
	}

	/**
	 * @param $direccion
	 * @param $pais
	 *
	 * @return array
	 */
	public function getGoogleCoordinates( $direccion, $pais ) {
		$direccion_google = "$direccion,$pais";
		$result           = file_get_contents( sprintf( 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s', urlencode( $direccion_google ) ) );
		$result           = json_decode( $result, true );

		$point = null;
		if ( isset( $result['results'][0]['geometry'] ) ) {
			$lat = $result['results'][0]['geometry']['location']['lat'];
			$lng = $result['results'][0]['geometry']['location']['lng'];

			$point = array( $lat, $lng );
		}

		return $point;
	}


}
