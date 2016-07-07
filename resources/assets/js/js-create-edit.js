$("#formCreateSubmit").on("click", function(e){
    e.preventDefault();

    var form = $("#formCreate");
    var url = form.attr('action');
    var data = form.serialize();

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        beforeSend: function() { $('.progress').show(); },
        complete: function() { $('.progress').hide(); },
        success: function(result) {
            var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
            $(".form-content").html(successHtml);
            form[0].reset();
        },
        error: function(result) {
            if(result.status === 422){
                var errors = result.responseJSON;
                var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></di>';
                $('.form-content').html(errorsHtml);
            }else{
                errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                errorsHtml += '</ul></div>';
                $('.form-content').html(errorsHtml);
            }
        }
    });

});

$("#formEditSubmit").on("click", function(e){
    e.preventDefault();

    var form = $("#formEdit");
    var url = form.attr('action');
    var data = form.serialize();

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        beforeSend: function() { $('.progress').show(); },
        complete: function() { $('.progress').hide(); },
        success: function(result) {
            var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
            $(".form-content").html(successHtml);
        },
        error: function(result) {
            if(result.status === 422){
                var errors = result.responseJSON;
                var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></di>';
                $('.form-content').html(errorsHtml);
            }else{
                errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                errorsHtml += '</ul></div>';
                $('.form-content').html(errorsHtml);
            }
        }
    });

});