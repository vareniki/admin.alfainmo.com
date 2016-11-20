<?php $this->start('header');
	if (!isset($info['Inmueble']['id'])) {
		return;
	}
?>
<script type='text/javascript'>

	var errors = "";

	$(document).ready(function() {
		initGalleryDelDocument('<?php echo $this->Html->assetUrl("/inmuebles/delDocumento/") ?>', <?php echo $info['Inmueble']['id']; ?>);
		initGalleryChgDocumentTitle('<?php echo $this->Html->assetUrl("/inmuebles/updDocumento/") ?>', <?php echo $info['Inmueble']['id']; ?>);
	});
</script>
<?php $this->end(); ?>
<br>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4">Adjuntar documentos:</label>
  <div class="controls col-xs-7 col-lg-8 col-sm-8">
    <div class="input-group">
      <input type="file" name="documentos[]" multiple="true" class="form-control" value="Enviar" accept="">
    </div>
  </div>
</div>
<hr>
<br>
<div class="doc-gallery-panel">
  <ul class="doc-gallery">
    <?php
    foreach ($this->Inmuebles->getAllDocuments($info) as $doc):
      ?>
	    <li class="panel" data-itemid="<?php echo $doc['id'] ?>">
			    <div class="input-group">
				    <span class="input-group-btn">
					    <button type="button" class="btn btn-default deldoc"><i class="glyphicon glyphicon-remove text-danger"></i></button>
						</span>
				    <input type="text" name="nombre" value="<?php echo $doc['desc'] ?>" class="form-control name" maxlength="64">
				    <span class="input-group-btn">
					    <a href="<?php echo $doc['url'] ?>" class="btn btn-default"><i class="glyphicon glyphicon-link"></i></a>
						</span>
			    </div>
	    </li>
    <?php endforeach; ?>
  </ul>
</div>