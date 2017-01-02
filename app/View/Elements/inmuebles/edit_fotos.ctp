<?php $this->start('header');
if (!isset($info['Inmueble']['id'])) {
  return;
}
?><script type='text/javascript'>

  var errors = "";

  $(document).ready(function() {
    initGalleryDelFoto('<?php echo $this->Html->assetUrl("/inmuebles/delFoto/") ?>', <?php echo $info['Inmueble']['id']; ?>);
    initGalleryChangeTitle('<?php echo $this->Html->assetUrl("/inmuebles/updFoto/") ?>');
    initGalleryChangeType('<?php echo $this->Html->assetUrl("/inmuebles/updFoto/") ?>');
    initGallerySort('<?php echo $this->Html->assetUrl('/inmuebles/sortFotos/' . $info['Inmueble']['id'] . '/') ?>');
    //initGalleryAddFoto('<?php echo $this->Html->url('/inmuebles/addFoto/' . $info['Inmueble']['id']) ?>', '<?php echo $this->Html->assetUrl('/inmuebles/image/'); ?>');
  });
</script>
<?php $this->end(); ?>
<br>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4">Adjuntar im&aacute;genes:</label>
  <div class="controls col-xs-7 col-lg-8 col-sm-8">
    <div class="input-group">
      <input type="file" name="fotos[]" multiple="true" class="form-control" value="Enviar" accept="image/gif, image/jpeg, image/png">
    </div>
  </div>
</div>
<p class="text-info">Te recomendamos que veas este v&iacute;deo para hacer unas buenas fotos: <a href="https://youtu.be/Izyeut6MshY" target="_blank">V&iacute;deo explicativo</a>.</p>
<p class="text-info">Te recomendamos que veas esta presentación de cómo mejorar la imagen de tus viviendas: <a href="http://www.alfainmo.com/descargas/Home-Staging.ppt">Home Staging</a>.</p>
<p class="text-info">Os enviamos otra manera de realizar los planos con PowerPoint: <a href="https://youtu.be/__lFe-jAGfU" target="_blank">V&iacute;deo explicativo</a> / <a href="http://www.alfainmo.com/descargas/iconos-generador-planos.ppt">Iconos necesarios</a>.</p>

<p class="text-info">Os enviamos un tutorial y un ejemplo para que podáis ver la forma en la cual realizar vídeos con Movie Maker: <a href="https://youtu.be/_QEtrLTBNqo" target="_blank">Tutorial</a> / <a href="https://youtu.be/2kbpOcZweZ8" target="_blank">Ejemplo</a>.</p>

<p class="text-info">Una vez seleccionada la imagen o imágenes debes pulsar el botón &quot;grabar&quot; para que &eacute;stas se adjunten al inmueble.
  Para seleccionar archivos, mant&eacute;n presionada la tecla <strong>Ctrl</strong> y, a continuaci&oacute;n, haz clic en cada uno de
  los elementos que desees seleccionar. <span class="text-danger">M&aacute;ximo, 2 megas por foto.</span>
</p>
<hr>
<div id='gallery-buttons' class="btn-group pull-right">
  <button type="button" class="btn btn-default btn-sm active" itemprop='p'><i class='glyphicon glyphicon-th'></i></button>
  <button type="button" class="btn btn-default btn-sm" itemprop='m'><i class='glyphicon glyphicon-th-large'></i></button>
  <button type="button" class="btn btn-default btn-sm" itemprop='g'><i class='glyphicon glyphicon-th-list'></i></button>
</div>
<br>
<div class="image-gallery-panel">
  <ul class='image-gallery tam-p'>
    <?php
    $images = $this->Inmuebles->getAllImages($info, array('class' => 'img-responsive'));
    foreach ($images as $image):
      ?>
      <li class="panel panel-default" itemprop="<?php echo $image['id'] ?>">
        <div class="panel-heading">

          <div class="chg-image-type btn-group" style="width: 100%">
            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" style="width: 100%">
              <span class="description"><?php echo $image['type-desc'] ?></span> <span class="caret"></span>
            </button>
            <ul class="image-type dropdown-menu">
              <li class="item"><a href="javascript:void(0)" itemprop="00">plano / foto</a></li>
              <li class="divider"></li>
              <?php foreach ($tiposImagen as $tipo): ?>
                <li class="item"><a href="javascript:void(0)" itemprop="<?php echo $tipo['TipoImagen']['id'] ?>"><?php echo $tipo['TipoImagen']['description'] ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="panel-body">
          <?php echo $image['url-p'] ?>
        </div>
        <div class="panel-footer">
          <div class="text-center"><a href="javascript:void(0)" itemid="<?php echo $image['id'] ?>" class="text-danger delfoto" data-title="eliminar">eliminar</a></div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>