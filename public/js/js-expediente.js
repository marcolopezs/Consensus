$(".col-hide").on("click", function () {
    var id = $(this).attr('id');
    $(this).prop("checked") ? $('.'+id).show() : $('.'+id).hide();
});


/* AJUSTES */
$("#ajustes-expediente").on("click", function() {
    $("#ajustes-expediente-panel").slideToggle();
});

$("#ajustes-expediente-cancelar").on("click", function() {
    $("#ajustes-expediente-panel").slideUp();
});


//MOSTRAR U OCULTAR COLUMNAS DE LA TABLA EXPEDIENTE
var ajustes = $("#expediente-ajustes-data").text();
var js = JSON.parse(ajustes);

getValues(js,'ch-expediente') == 1 ? $('.col-expediente').show() : $('.col-expediente').hide();
getValues(js,'ch-cliente') == 1 ? $('.col-cliente').show() : $('.col-cliente').hide();
getValues(js,'ch-moneda') == 1 ? $('.col-moneda').show() : $('.col-moneda').hide();
getValues(js,'ch-valor') == 1 ? $('.col-valor').show() : $('.col-valor').hide();
getValues(js,'ch-tarifa') == 1 ? $('.col-tarifa').show() : $('.col-tarifa').hide();
getValues(js,'ch-abogado') == 1 ? $('.col-abogado').show() : $('.col-abogado').hide();
getValues(js,'ch-asistente') == 1 ? $('.col-asistente').show() : $('.col-asistente').hide();
getValues(js,'ch-servicio') == 1 ? $('.col-servicio').show() : $('.col-servicio').hide();
getValues(js,'ch-fecha-inicio') == 1 ? $('.col-fecha-inicio').show() : $('.col-fecha-inicio').hide();
getValues(js,'ch-fecha-termino') == 1 ? $('.col-fecha-termino').show() : $('.col-fecha-termino').hide();
getValues(js,'ch-materia') == 1 ? $('.col-materia').show() : $('.col-materia').hide();
getValues(js,'ch-entidad') == 1 ? $('.col-entidad').show() : $('.col-entidad').hide();
getValues(js,'ch-instancia') == 1 ? $('.col-instancia').show() : $('.col-instancia').hide();
getValues(js,'ch-encargado') == 1 ? $('.col-encargado').show() : $('.col-encargado').hide();
getValues(js,'ch-fecha-poder') == 1 ? $('.col-fecha-poder').show() : $('.col-fecha-poder').hide();
getValues(js,'ch-fecha-vencimiento') == 1 ? $('.col-fecha-vencimiento').show() : $('.col-fecha-vencimiento').hide();
getValues(js,'ch-area') == 1 ? $('.col-area').show() : $('.col-area').hide();
getValues(js,'ch-jefe-area') == 1 ? $('.col-jefe-area').show() : $('.col-jefe-area').hide();
getValues(js,'ch-bienes') == 1 ? $('.col-bienes').show() : $('.col-bienes').hide();
getValues(js,'ch-situacion') == 1 ? $('.col-situacion').show() : $('.col-situacion').hide();
getValues(js,'ch-estado') == 1 ? $('.col-estado').show() : $('.col-estado').hide();
getValues(js,'ch-exito') == 1 ? $('.col-exito').show() : $('.col-exito').hide();


/* FILTRAR */
$("#filtrar-expediente").on("click", function() {
    $("#filtrar-expediente-panel").slideToggle();
});

$("#filtrar-expediente-cancelar").on("click", function() {
    $("#filtrar-expediente-panel").slideUp();
});

$(".select2-clear").on("click", function(){
    var id = $(this).data('id');
    $("." + id + " .select2").val(null).trigger('change');
});

$(".text-clear").on("click", function(){
    var id = $(this).data('id');
    $("." + id + " .form-control").val(null);
});


//MOSTRAR TAREAS DE EXPEDIENTE
$(".expediente-tareas").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var list = $(this).data('list');
    var create = $(this).data('create');

    $.ajax({
        url: list,
        type: 'GET',
        success: function(result){

            var html = '<tr id="tarea-'+id+'" class="bg-default" style="display:none;">' +
                    '<td style="padding:20px 15px;" colspan="23">' +
                        '<div class="btn-group pull-left">' +
                            '<h3 class="table-title">Tareas</h3>' +
                        '</div>' +
                        '<div class="btn-group pull-right table-botones">' +
                            '<a class="btn sbold white tarea-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                            '<a class="btn sbold blue-soft" href="'+create+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo tarea <i class="fa fa-plus"></i></a>' +
                        '</div>' +
                        '<table id="tarea-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                            '<thead>' +
                                '<tr role="row" class="heading">' +
                                    '<td class="text-center">Solicitada</td>' +
                                    '<td class="text-center">Finalizado</td>' +
                                    '<td>Tarea</td>' +
                                    '<td>Descripción</td>' +
                                    '<td>Asignado</td>' +
                                    '<td class="text-center">Tiempo</td>' +
                                    '<td class="text-center">Gastos</td>' +
                                    '<td class="text-center">Estado</td>' +
                                    '<td></td>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody></tbody>' +
                        '</table>' +
                    '</td>' +
                '</tr>';

            $("#exp-" + id).after(html);
            $("#tarea-" + id).fadeIn();

            var tr, descripcion, estado;

            $.each(JSON.parse(result), function(idx, obj) {
                descripcion = obj.descripcion;
                estado = obj.estado_nombre;
                tr = $('<tr id="tarea-select-'+ obj.id +'">');
                tr.append('<td class="text-center">'+ obj.fecha_solicitada +'</td>');
                tr.append('<td class="text-center">'+ obj.fecha_vencimiento +'</td>');
                tr.append('<td>'+ obj.titulo_tarea +'</td>');
                tr.append('<td data-tooltip="'+ obj.descripcion +'">'+ descripcion.substr(0,50) + "..." +'</td>');
                tr.append('<td>'+ obj.asignado +'</td>');
                tr.append('<td class="text-center"><strong>'+ obj.tiempo_total +'</strong></td>');
                tr.append('<td class="text-right"><strong>S/ '+ obj.gastos +'</strong></td>');
                tr.append('<td class="text-center"><span class="estado-'+ estado.toLowerCase() +'">'+ estado +'</span></td>');
                tr.append('<td class="text-center">' +
                    '<div class="btn-group">' +
                        '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos' +
                            '<i class="fa fa-angle-down"></i>' +
                        '</button>' +
                        '<ul class="dropdown-menu pull-right" role="menu">' +
                            '<li><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></li>' +
                            '<li><a href="#" class="expediente-tarea-acciones-lista" data-id="'+ obj.id +'" ' +
                                    'data-list="'+ obj.url_acciones_lista +'" data-create="'+ obj.url_acciones_crear +'">Acciones</a></li>' +
                            '<li><a href="'+ obj.url_notificacion +'" data-target="#ajax" data-toggle="modal">Notificaciones</a></li>' +
                        '</ul>' +
                    '</div>' +
                    '</td></tr>');
                $("#tarea-lista-"+id+" tbody").append(tr);
            });

            tareaListaAcciones();

            $(".tarea-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#tarea-" + id).fadeOut();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function() {

        }
    });

});




//MOSTRAR FLUJO DE CAJA DE EXPEDIENTE
$(".expediente-caja").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var list = $(this).data('list');
    var create = $(this).data('create');
    var saldo = $(this).data('saldo');

    $.ajax({
        url: list,
        type: 'GET',
        success: function(result){
            var html = '<tr id="caja-'+id+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23">' +
                '<div class="row">' +
                    '<div class="col-md-3">' +
                    '<h3 class="table-title">Flujo de Caja</h3>' +
                    '</div>' +
                    '<div class="col-md-5 text-center">' +
                    '<h3 class="table-title">Saldo: S/. '+ saldo + '</h3>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                        '<div class="pull-right btn-group table-botones">' +
                            '<a class="btn sbold white caja-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                            '<a class="btn sbold blue-soft" href="'+create+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo flujo de caja <i class="fa fa-plus"></i></a>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<table id="caja-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                '<thead>' +
                '<tr role="row" class="heading">' +
                '<td>Fecha</td>' +
                '<td>Referencia</td>' +
                '<td>Monto</td>' +
                '<td>Moneda</td>' +
                '<td>Tipo</td>' +
                '<td>Acciones</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#exp-" + id).after(html);
            $("#caja-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="caja-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.fecha_caja +'</td>');
                tr.append('<td>'+ obj.referencia +'</td>');
                tr.append('<td>'+ obj.monto +'</td>');
                tr.append('<td>'+ obj.moneda +'</td>');
                tr.append('<td>'+ obj.tipo +'</td>');
                tr.append('<td><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>');
                $("#caja-lista-"+id+" tbody").prepend(tr);
            });

            $(".caja-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#caja-" + id).fadeOut();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function() {

        }
    });

});


//MOSTRAR INTERVINIENTES DE EXPEDIENTE
$(".expediente-interviniente").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var list = $(this).data('list');
    var create = $(this).data('create');

    $.ajax({
        url: list,
        type: 'GET',
        success: function(result){
            var html = '<tr id="interviniente-'+id+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23">' +
                '<div class="btn-group pull-left">' +
                '<h3 class="table-title">Intervinientes</h3>' +
                '</div>' +
                '<div class="btn-group pull-right table-botones">' +
                '<a class="btn sbold white interviniente-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                '<a class="btn sbold blue-soft" href="'+create+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo interviniente <i class="fa fa-plus"></i></a>' +
                '</div>' +
                '<table id="interviniente-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                '<thead>' +
                '<tr role="row" class="heading">' +
                '<td>Nombre</td>' +
                '<td>Tipo</td>' +
                '<td>DNI</td>' +
                '<td>Teléfono</td>' +
                '<td>Celular</td>' +
                '<td>Email</td>' +
                '<td>Acciones</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#exp-" + id).after(html);
            $("#interviniente-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="interviniente-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.nombre +'</td>');
                tr.append('<td>'+ obj.tipo +'</td>');
                tr.append('<td>'+ obj.dni +'</td>');
                tr.append('<td>'+ obj.telefono +'</td>');
                tr.append('<td>'+ obj.celular +'</td>');
                tr.append('<td>'+ obj.email +'</td>');
                tr.append('<td><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>');
                $("#interviniente-lista-"+id+" tbody").prepend(tr);
            });

            $(".interviniente-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#interviniente-" + id).fadeOut();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function(result) {
            console.log()
        }
    });

});


//MOSTRAR DOCUMENTOS DE EXPEDIENTE
$(".expediente-documento").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var list = $(this).data('list');
    var create = $(this).data('create');

    $.ajax({
        url: list,
        type: 'GET',
        success: function(result){
            var html = '<tr id="documento-'+id+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23">' +
                '<div class="btn-group pull-left">' +
                '<h3 class="table-title">Documentos</h3>' +
                '</div>' +
                '<div class="btn-group pull-right table-botones">' +
                '<a class="btn sbold white documento-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                '<a class="btn sbold blue-soft" href="'+create+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo documento <i class="fa fa-plus"></i></a>' +
                '</div>' +
                '<table id="documento-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                '<thead>' +
                '<tr role="row" class="heading">' +
                '<td>Referencia</td>' +
                '<td>Descripción</td>' +
                '<td>Documento</td>' +
                '<td>Acciones</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#exp-" + id).after(html);
            $("#documento-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="documento-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.titulo +'</td>');
                tr.append('<td>'+ obj.descripcion +'</td>');
                tr.append('<td class="text-center"><a href="'+ obj.descargar +'">Descargar</a></td>');
                tr.append('<td><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>');
                $("#documento-lista-"+id+" tbody").prepend(tr);
            });

            $(".documento-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#documento-" + id).fadeOut();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function(result) {
            console.log(result)
        }
    });

});


//MOSTRAR COMPROBANTES DE PAGO DE EXPEDIENTE
$(".expediente-comprobantes").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var list = $(this).data('list');
    var create = $(this).data('create');

    $.ajax({
        url: list,
        type: 'GET',
        success: function(result){
            console.log(result);
            var html = '<tr id="comprobante-'+id+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23">' +
                '<div class="btn-group pull-left">' +
                '<h3 class="table-title">Comprobantes de Pago</h3>' +
                '</div>' +
                '<div class="btn-group pull-right table-botones">' +
                '<a class="btn sbold white comprobante-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                '</div>' +
                '<table id="comprobante-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                '<thead>' +
                '<tr role="row" class="heading">' +
                    '<td>Tipo de Comprobante</td>' +
                    '<td>N° de Comprobante</td>' +
                    '<td>Fecha</td>' +
                    '<td>Moneda</td>' +
                    '<td>Importe</td>' +
                    '<td>Documento</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#exp-" + id).after(html);
            $("#comprobante-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="comprobante-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.tipo_comprobante +'</td>');
                tr.append('<td>'+ obj.comprobante_numero +'</td>');
                tr.append('<td>'+ obj.fecha +'</td>');
                tr.append('<td>'+ obj.moneda +'</td>');
                tr.append('<td>'+ obj.importe +'</td>');
                tr.append('<td class="text-center"><a href="'+ obj.url_descargar +'">Descargar</a></td>');
                $("#comprobante-lista-"+id+" tbody").prepend(tr);
            });

            $(".comprobante-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#comprobante-" + id).fadeOut();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function(result) {
            console.log(result)
        }
    });

});


//ANULAR EXPEDIENTES
$(".expediente-anulado").on("click", function (e) {
    e.preventDefault();

    var id = $(this).data('id');
    var url = $(this).data('anular');
    var title = $(this).data('title');

    bootbox.dialog({
        title: 'Anular registro',
        message: '\<\strong\>\Desea anular el expediente:\</\strong\>\ '+ title,
        closeButton: false,
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'default'
            },
            success: {
                label: 'Anular',
                className: 'red',
                callback: function() {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        beforeSend: function () { $('.progress').show(); },
                        complete: function () { $('.progress').hide(); },
                        success: function (result) {
                            $("#exp-" + id + " .btn-group button i.fa").remove();
                            $("#exp-" + id + " .btn-group .dropdown-menu").remove();
                            $("#exp-" + id).addClass('danger');
                            $("#exp-" + id + " .btn-group button").removeClass('blue').addClass('red').text('Anulado');
                        },
                        error: function (result) {
                            $("#mensajeAjax").show();
                            $("#mensajeAjax .alert").show().removeClass('alert-success').addClass('alert-danger');
                            $("#mensajeAjax span").text("Se produjo un error al eliminar el registro");
                            $(".accion-select-"+ accion).show();
                        }
                    });
                }
            }
        }
    });
});


//# sourceMappingURL=js-expediente.js.map
