$('.btn-delete').on("click", function(e){
    e.preventDefault();
    var row = $(this).parents("tr");
    var id = row.data("id");
    var title = row.data("title");
    var form = $("#FormDeleteRow");
    var url = form.attr("action").replace(':REGISTER', id);
    var data = form.serialize();

    bootbox.dialog({
        title: 'Eliminar registro',
        message: 'Desea elminar el registro: '+title,
        closeButton: false,
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'default'
            },
            success: {
                label: 'Eliminar',
                className: 'blue',
                callback: function() {
                    row.fadeOut();
                    $.post(url, data, function(result){
                        $("#mensajeAjax").show();
                        $("#mensajeAjax .alert").show().removeClass('alert-danger').addClass('alert-success');
                        $("#mensajeAjax span").text(result.message);
                    }).fail(function(){
                        $("#mensajeAjax").show();
                        $("#mensajeAjax .alert").show().removeClass('alert-success').addClass('alert-danger');
                        $("#mensajeAjax span").text("Se produjo un error al eliminar el registro");
                        row.show();
                    });
                }
            }
        }
    });
});
