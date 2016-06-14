$(".btn-estado").on("click", function(e){
    e.preventDefault();

    var id = $(this).data("id");
    var url = $(this).data("url");
    var title = $(this).data("title");

    bootbox.confirm({
        message: "Desea cambiar el estado de <strong>" + title + "</strong>",
        closeButton: false,
        buttons: {
            confirm: {
                label: "Cambiar estado",
                className: "green"
            },
            cancel: {
                label: "Cancelar"
            }
        },
        callback: function(result){
            if(result == true)
            {
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    beforeSend: function() { $("#progressbar").show(); },
                    complete: function() { $("#progressbar").hide(); },
                    success: function(result){
                        if(result.estado == 1){ $("#estado-"+id+" span").removeClass('label-default').addClass('label-success').text('Activo'); }
                        else if(result.estado == 0){ $("#estado-"+id+" span").removeClass('label-success').addClass('label-default').text('No activo'); }
                        $("#mensajeAjax").show();
                        $("#mensajeAjax .alert").removeClass('alert-danger').addClass('alert-success');
                        $("#mensajeAjax .alert span").text("Se cambió es estado del registro: " + title);
                    },
                    error: function(result){
                        $("#mensajeAjax").show();
                        $("#mensajeAjax .alert").removeClass('alert-success').addClass('alert-danger');
                        $("#mensajeAjax .alert span").text("Se produjo un eror al cambiar el estado. Intentarlo nuevamente.");
                    }

                });
            }
        }

    });

});