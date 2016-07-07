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