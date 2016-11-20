/**
 * 
 * @param {type} options
 * @returns {String}
 */
function buscador_ajax_get_html(options) {

    var result = '<form id="buscarAjax_form" class="ajax" action="' + options.action + '" onsubmit="return false">';

    result += '<div class="row"><div class="col-xs-9"><input type="text" class="form-control" id="buscarAjax_input" name="q" style="width:100%" autocomplete="off" placeholder="' + options.help + '"></div>';
    result += '<div class="col-xs-3"><div class="checkbox" style="margin-top: 10px"><label><input type="checkbox" id="buscarAjax_checkbox" name="bajas" value="S"> Incluir bajas</label></div></div></div>';
    result += '</form><br>';
    result += '<div id="buscarAjax_results"></div></div>';

    return result;
}

function buscador_ajax_onkeyup(value, callback, event) {

    if (value != null) {

        if (value.value.length < 3) {
            return;
        }

        if (event.keyCode == 13) {
            event.preventDefault();
        }

    } else {

        var value = $("#buscarAjax_input").val();
        if (value.length < 3) {
            return;
        }
    }


    $("#buscarAjax_form").ajaxSubmit({
        target: "#buscarAjax_results",
        success: function() {
            $("#buscarAjax_results a").on("click", function() {
                var info = eval('(' + $(this).attr("data-info") + ')');
                callback(info);
            });
        }
    });
}

/**
 * 
 * @param {type} properties
 * @param {type} callback
 * @returns {unresolved}
 */
function buscador_ajax(properties, callback) {
    var dialog_obj = bootbox.dialog({
        message: buscador_ajax_get_html({
            action: properties.action,
            help: properties.help
        }),
        title: properties.title,
        buttons: {
            success: { label: "Cerrar", className: "btn-sm btn-default", closeButton: true }
        }
    });

    $(dialog_obj).on('shown.bs.modal', function() {
        $("#buscarAjax_input").focus();
        $("#buscarAjax_input").on("keyup", function(event) {
            buscador_ajax_onkeyup(this, callback, event);
        });
        $("#buscarAjax_checkbox").on("click", function(event) {
            buscador_ajax_onkeyup(null, callback, event);
        });
    });

    return dialog_obj;
}