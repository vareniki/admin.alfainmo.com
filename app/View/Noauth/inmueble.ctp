<?php $subinfo = $this->Inmuebles->getSubtipoInfo( $info ); ?>
[vc_row_inner]
[vc_column_inner width="1/1"]
[vc_column_text]
<div class="gallery gallery-fotos gallery-size-thumbnail dt-gallery-container mfp-ready">
	<?php
	$images = $this->Inmuebles->getAllImages( $info, array( 'no_forzar' => true ) );
	foreach ( $images as $image ):
		$src_g = str_replace('/g/', '/gw/', $image['src-g']);
		?>
		<dl class="gallery-item">
			<dt class="gallery-icon">
				<a href="http://admin.alfainmo.com<?php echo $src_g ?>" class="rollover rollover-zoom dt-mfp-item mfp-image this-ready" title="" data-dt-img-description=""><img src="http://admin.alfainmo.com<?php echo $image['src-m'] ?>" height="150" width="150" alt=""><i></i></a>
			</dt>
		</dl>
	<?php endforeach; ?>
</div>
[/vc_column_text]
[/vc_column_inner]
[/vc_row_inner]
[vc_row_inner]
[vc_column_inner width="1/2"]
<div class="info-ficha">
<?php
	if ( !empty($info['Inmueble']['descripcion']) || !empty($info['Inmueble']['observaciones_pvi'])) {
		echo '[dt_fancy_title title="Descripción" title_align="left" title_size="normal" title_color="default" title_bg="disabled" separator_color="default"]';
		echo '[vc_column_text]';

		if ($pvi == 'N') {
          $this->Model->printIfExists( $info, 'descripcion', array( 'tag' => 'p' ) );
        } else {
          $this->Model->printIfExists( $info, 'observaciones_pvi', array( 'tag' => 'p' ) );
        }

		if (!empty($info['Inmueble']['video'])) {

          $videos = $this->Inmuebles->parseVideos($info['Inmueble']['video']);

          $i=1;
          foreach($videos[0] as $video) {
            echo "<p style='text-align: center; font-size: 20px'><a href='$video' target='_blank'>VER V&Iacute;DEO $i</a></p><br>";
            $i++;
          }

          if ($pvi == 'S') {
            if ( isset( $videos[1] ) ) {
              foreach ( $videos[1] as $video ) {
                echo "<p style='text-align: center; font-size: 20px'><a href='$video' target='_blank'>VER V&Iacute;DEO $i</a></p><br>";
                $i ++;
              }
            }
          }

		}

	echo '[/vc_column_text]';
}?><br>
[dt_fancy_title title="Localización" title_align="left" title_size="normal" title_color="default" title_bg="disabled" separator_color="default"]
[vc_column_text]<?php
  $ciudad = $this->Inmuebles->printCiudad( $info );
  if (!empty($ciudad)) { echo $ciudad; }
?>
[/vc_column_text]
<br>[dt_fancy_title title="Contacto" title_align="left" title_size="normal" title_color="default" title_bg="disabled" separator_color="default"]
[vc_column_text]%datos_agencia%[/vc_column_text]
</div>
[/vc_column_inner]
[vc_column_inner width="1/2"]
<div class="info-ficha">
[dt_fancy_title title="Información" title_align="left" title_size="normal" title_color="default" title_bg="disabled" separator_color="default"]
[vc_column_text]
<p><?php
	$adicional = '';
	echo $this->Inmuebles->printDescripcion( $info, $adicional );
	?>
</p>
<ul>
	<?php
	if ( $info['Inmueble']['es_venta'] == 't' ) {

	    $campo = ($pvi == 'S') ? 'precio_particular' : 'precio_venta';

		$this->Model->printIfExists( $info, $campo, array(
				'label'  => 'Precio de venta',
				'format' => 'currency'
		) );
	}
	if ( $info['Inmueble']['es_alquiler'] == 't' || $info['Inmueble']['es_opcion_compra'] == 't' ) {
		$this->Model->printIfExists( $info, 'precio_alquiler', array(
				'label'  => 'Precio de alquiler',
				'format' => 'currency'
		) );
	}
	if ( $info['Inmueble']['es_traspaso'] == 't' ) {
		$this->Model->printIfExists( $info, 'precio_traspaso', array(
				'label'  => 'Precio de traspaso',
				'format' => 'currency'
		) );
	}
	if ( $info['Inmueble']['es_opcion_compra'] == 't' ) {
		echo '<p class="text-info">(el inmueble tiene opci&oacute;n a compra)</p>';
	}
	
	if ( isset($tipoInmueble) ) {	
		$tipoUC = ucfirst($tipoInmueble);
		if ( isset($info[$tipoUC]['es_vpo']) && $info[$tipoUC]['es_vpo'] == 't' ) {
			echo '<p class="text-info">(el inmueble es VPO)</p>';
		}
	}	
	?>
</ul>
<?php
if ( $info['Inmueble']['es_promocion'] == 't' ) {
	echo '<p class="text-info">El inmueble forma parte de una promoci&oacute;n.</p>';
	echo '<ul>';
	$this->Model->printIfExists( $info, 'nombre_promocion', array( 'label' => 'Nombre promoci&oacute;n: ' ) );
	$this->Model->printIfExists( $info, 'entrega_promocion', array( 'label' => 'Entrega promoci&oacute;n: ' ) );
	echo '</ul>';
}

if ( isset($tipoInmueble) ) {
	echo $this->element( "inmuebles/view_info_$tipoInmueble" );
}
?>
[/vc_column_text]
</div>
[/vc_column_inner]
[/vc_row_inner]
