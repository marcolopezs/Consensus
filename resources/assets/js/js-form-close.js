//MENSAJE AL CERRAR FORMULARIO
function formClose(array){
    var valor = "";
    array.forEach(function(c){ if(c != ""){ valor += c; } });

    if(valor != ""){
        bootbox.dialog({
            title: 'Alerta',
            message: 'El fomulario tiene datos que ha ingresado. ¿Desea cerrar sin guardar?',
            closeButton: false,
            buttons: {
                cancel: { label: 'No', className: 'default' },
                success: { label: 'Si', className: 'blue', callback: function() { $('#ajax').modal('hide'); } }
            }
        });
    }else{ $('#ajax').modal('hide'); }
}

//MENSAJE AL CERRAR FORMULARIO DE EXPEDIENTE
function formCloseExpediente(boton, array){
    var valor = "";
    var url = $(boton).data('url');
    array.forEach(function(c){ if(c != ""){ valor += c; } });

    if(valor != ""){
        bootbox.dialog({
            title: 'Alerta',
            message: 'El fomulario tiene datos que ha ingresado. ¿Desea cerrar sin guardar?',
            closeButton: false,
            buttons: {
                cancel: { label: 'No', className: 'default' },
                success: { label: 'Si', className: 'blue', callback: function() { window.location=url } }
            }
        });
    }else{ window.location=url }
}