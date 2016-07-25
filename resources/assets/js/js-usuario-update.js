//UPDATE DE DATOS DE USUARIO
$("#btnUserUpdate").on("click", function(e) {
    e.preventDefault();

    var form = $("#formUserUpdate");
    var url = form.attr('action');
    var data = form.serialize();
    var formMessage = $(".form-content.info-personal");

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        success: function (result) {
            var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
            formMessage.html(successHtml);
        },
        error: function (result) {
            if(result.status === 422){
                var errors = result.responseJSON;
                var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div>';
                formMessage.html(errorsHtml);
            }else{
                errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                errorsHtml += '</ul></div>';
                formMessage.html(errorsHtml);
            }
        }
    });
});

//UPDATE DE TARIFAS DE ABOGADO
$("#btnTarifaUpdate").on("click", function(e) {
    e.preventDefault();

    var form = $("#formTarifaUpdate");
    var url = form.attr('action');
    var data = form.serialize();
    var formMessage = $(".form-content.tarifas");

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        success: function (result) {
            var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
            formMessage.html(successHtml);
        },
        error: function (result) {
            if(result.status === 422){
                var errors = result.responseJSON;
                var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div>';
                formMessage.html(errorsHtml);
            }else{
                errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                errorsHtml += '</ul></div>';
                formMessage.html(errorsHtml);
            }
        }
    });

});

/* UPDATE DE FOTO DE USUARIO */
//UPLOAD DE FOTO
var myDropzone = new Dropzone(".dropzone", {
    dictDefaultMessage: 'Da clic para seleccionar el archivo',
    dictMaxFilesExceeded: 'No se puede cargar más archivos',
    method: 'POST',
    headers: {'X-CSRF-Token': '{!! csrf_token() !!}'},
    maxFiles: 1,
    autoProcessQueue: false,
    success: function (file, result) {
        var imagen = "/imagenes/" + result.carpeta + "250x250/" + result.archivo;
        $("#fotoUsuario").attr("src", imagen);
        myDropzone.removeAllFiles();
    }
});

//UPLOAD DE FOTO AL DAR CLICK EN SUBIR
$("#btnFotoCambiar").on("click", function(){
    myDropzone.processQueue();
});

//ELIMINAR FOTOS DE CUADRO DE DROPZONE
$("#btnFotoEliminar").on("click", function(){
    myDropzone.removeAllFiles();
});

//ELIMINAR FOTO ACTUAL DE USUARIO
$("#btnFotoEliminarActual").on("click", function(e) {
    e.preventDefault();

    var url = $(this).data('url');
    var formMessage = $(".form-content.cambiar-foto");

    $.ajax({
        url: url,
        type: 'POST',
        headers: {'X-CSRF-Token': '{!! csrf_token() !!}'},
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        success: function (result) {
            var imagen = "/imagenes/user.png";
            $("#fotoUsuario").attr("src", imagen);

            var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
            formMessage.html(successHtml);
        },
        error: function (result) {
            if(result.status === 422){
                var errors = result.responseJSON;
                var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div>';
                formMessage.html(errorsHtml);
            }else{
                errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                errorsHtml += '</ul></div>';
                formMessage.html(errorsHtml);
            }
        }
    });
});

//CAMBIAR CONTRASEÑA
$("#btnPasswordUpdate").on("click", function (e) {
    e.preventDefault();

    var form = $("#formPasswordUpdate");
    var url = form.attr('action');
    var data = form.serialize();
    var formMessage = $(".form-content.cambiar-clave");

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        success: function (result) {
            var mensaje;
            if(result.correo == true){ mensaje = 'La contraseña se envío por correo al usuario.' }
            else{ mensaje = ''; }
            var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente. '+ mensaje +'</div>';
            formMessage.html(successHtml);
            form[0].reset();
            $(".checker span").removeClass('checked');
        },
        error: function (result) {
            if(result.status === 422){
                var errors = result.responseJSON;
                var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div>';
                formMessage.html(errorsHtml);
            }else{
                errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                errorsHtml += '</ul></div>';
                formMessage.html(errorsHtml);
            }
        }
    });

});