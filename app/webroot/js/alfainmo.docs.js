var ultimo_tamano = 'p';

function initGalleryButtons() {

  $("#gallery-buttons").on("click", "button", function() {
    $("#gallery-buttons button").removeClass('active');
    var btn = $(this);
    btn.addClass('active');
    ultimo_tamano = btn.attr('itemprop');

    $('.image-gallery').removeClass('tam-g tam-m tam-p');
    $('.image-gallery').addClass('tam-' + ultimo_tamano);

    $(".image-gallery img").each(function(i, obj) {
      var img = $(obj);
      var url = img.attr("itemprop");
      var type = img.attr("itemtype");
      if (type == '07') {
        ultimo_tamano = 'o';
      }
      if (url != null) {
        url = url.replace('size', ultimo_tamano);
        img.prop("src", url);
      }
    });
  });

}

function getGalleryOrderedIds() {
  var j = 0;
  var ids = new Array();
  var elements = $('ul.image-gallery li.panel');
  for (var i = 0; i < elements.length; i++) {
    var itemprop = elements[i].getAttribute("itemprop");
    if (itemprop != null) {
      ids[j++] = itemprop;
    }
  }
  return ids.toString();
}

function initGalleryDelFoto(ajaxUrl, inmuebleId) {

  $('ul.image-gallery').on("click", "a.delfoto", function() {
    if (confirm("¿Desea eliminar la foto seleccionada?")) {
      var id = $(this).attr("itemid");
      var $panel = $(this).closest('li.panel');
      $panel.remove();
      $.ajax({
        type: "GET",
        url: ajaxUrl + id + '/' + inmuebleId
      });
    }
  });
}

function initGalleryChangeTitle(ajaxUrl) {
  $('ul.image-gallery').on("click", "a.image-title", function() {
    var photoId = $(this).closest('li.panel').attr("itemprop");

    var newName = prompt("Por favor, escriba un nombre", null);
    if (newName != null) {
      $(this).text(newName);
      $.ajax({
        type: "POST",
        url: ajaxUrl + photoId,
        data: {'descripcion': newName}
      });
    }
    return false;
  });
}

function initGalleryChangeType(ajaxUrl) {
  $('ul.image-gallery').on("click", "ul.image-type li.item a", function() {
    var typeId = $(this).attr("itemprop");
    var typeDesc = $(this).text();
    var photoId = $(this).closest('li.panel').attr("itemprop");

    $('.description', $(this).closest('div.chg-image-type')).text(typeDesc);

    $.ajax({
      type: "POST",
      url: ajaxUrl + photoId,
      data: {'tipo_imagen_id': typeId}
    });

  });
}

function initGallerySort(ajaxUrl) {

  $("ul.image-gallery").sortable({
    revert: true,
    update: function() {
      $.ajax({
        type: "GET",
        url: ajaxUrl + getGalleryOrderedIds()
      });

    }
  });

}

/* Documentos */

function initGalleryDelDocument(ajaxUrl, inmuebleId) {

    $('ul.doc-gallery').on("click", ".deldoc", function() {
        if (confirm("¿Desea eliminar el documento seleccionado?")) {
            var $panel = $(this).closest('li.panel');
            var id = $panel.attr("data-itemid");
            $panel.remove();
            $.ajax({
                type: "GET",
                url: ajaxUrl + id + '/' + inmuebleId
            });
        }
    });
}

function initGalleryChgDocumentTitle(ajaxUrl, inmuebleId) {
    $('ul.doc-gallery').on("change", "input.name", function() {

        var $panel = $(this).closest('li.panel');
        var id = $panel.attr("data-itemid");
        var descripcion = this.value;

        $.ajax({
            type: "POST",
            url: ajaxUrl + id + '/' + inmuebleId,
            data: {'descripcion': descripcion}
        });

        return false;
    });
}