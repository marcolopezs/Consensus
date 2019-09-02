//return an array of objects according to key, value, or key and value matching
function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getObjects(obj[i], key, val));
        } else
        //if key matches and value matches or if key matches and value is not passed (eliminating the case where key matches but passed value does not)
        if (i == key && obj[i] == val || i == key && val == '') { //
            objects.push(obj);
        } else if (obj[i] == val && key == ''){
            //only add if the object is not already in the array
            if (objects.lastIndexOf(obj) == -1){
                objects.push(obj);
            }
        }
    }
    return objects;
}

//return an array of values that match on a certain key
function getValues(obj, key) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getValues(obj[i], key));
        } else if (i == key) {
            objects.push(obj[i]);
        }
    }
    return objects;
}

//return an array of keys that match on a certain value
function getKeys(obj, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getKeys(obj[i], val));
        } else if (obj[i] == val) {
            objects.push(i);
        }
    }
    return objects;
}


/*
Función para editar acción
 */
function editarAccion() {

    $(".editar-accion").on("click", function(e){
        e.preventDefault();

        var url = $(this).data('url');
        var update = $(this).data('update');
        var token = $("#token").attr('content');

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () { $('.progress').show(); },
            complete: function () {
                $('.progress').hide();
                $("#form-agregar").fadeOut();
                $("#formCreateSubmit").fadeOut();
                $("#form-editar").fadeIn();
                $("#formUpdateSubmit").fadeIn();
            },
            success: function(result){
                var html = '<form method="POST" action='+ update +' id="formEdit" class="horizontal-form" autocomplete="off">' +
                    '<input name="_method" type="hidden" value="PUT">' +
                    '<input name="_token" type="hidden" value="'+ token +'">' +
                    '<div class="form-body">' +
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="fecha" class="control-label">Fecha</label>' +
                    '<div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">' +
                    '<input type="text" name="fecha" value="'+ result.fecha +'" class="form-control" />' +
                    '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="desde" class="control-label">Desde</label>' +
                    '<div class="input-group">' +
                    '<input type="text" name="desde" value="'+ result.desde +'" class="form-control timepicker timepicker-24" />' +
                    '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="hasta" class="control-label">Hasta</label>' +
                    '<div class="input-group">' +
                    '<input type="text" name="hasta" value="'+ result.hasta +'" class="form-control timepicker timepicker-24" />' +
                    '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-12">' +
                    '<div class="form-group">' +
                    '<label for="descripcion" class="control-label">Descripción</label>' +
                    '<textarea name="descripcion" class="form-control" rows="3">'+ result.descripcion +'</textarea>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';

                $("#formulario-contenido").append(html);

                $('.date-picker').datepicker({
                    orientation: "left",
                    autoclose: true,
                    language: "es"
                });

                $('.timepicker-24').timepicker({
                    autoclose: true,
                    minuteStep: 5,
                    showSeconds: false,
                    showMeridian: false
                });

                $("#form-editar").fadeIn();
            }
        });
    });
}


/*
Función para borrar Acción que se muestra
en la lista de Expedientes/Tareas o Tiempos/Tareas
 */
function borrarAccion(){
    $('.btn-delete').on("click", function(e){
        e.preventDefault();

        var url = $(this).data('url');
        var title = $(this).data('title');
        var accion = $(this).data('accion');

        bootbox.dialog({
            title: 'Eliminar registro',
            message: '\<\strong\>\Desea eliminar la acción:\</\strong\>\ '+ title,
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
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {'_method': 'DELETE'},
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            beforeSend: function () { $('.progress').show(); },
                            complete: function () { $('.progress').hide(); },
                            success: function (result) {
                                $("#mensajeAjax").show();
                                $("#mensajeAjax .alert").show().removeClass('alert-danger').addClass('alert-success');
                                $("#mensajeAjax span").text(result.message);
                                $("#accion-select-"+ accion).fadeOut();
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
}


/*
Funcion para mostar la lista de acciones de
tarea seleccionada en la vista Lista de Expedientes
 */
function tareaListaAcciones()
{
    $(".expediente-tarea-acciones-lista").on("click", function (e) {
        e.preventDefault();

        var id = $(this).data('id');
        var list = $(this).data('list');
        var create = $(this).data('create');

        $.ajax({
            url: list,
            type: 'GET',
            success: function (result) {
                var html = '<tr id="acciones-'+id+'" class="bg-default" style="display:none;">' +
                    '<td style="padding:20px 15px; border: 2px solid #b0b0b0;" colspan="23">' +
                    '<div class="btn-group pull-left">' +
                    '<h3 class="table-title">Acciones</h3>' +
                    '</div>' +
                    '<div class="btn-group pull-right table-botones">' +
                    '<a class="btn sbold white accion-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                    '<a class="btn sbold blue-soft" href="'+create+'" data-target="#ajax" data-toggle="modal"> Agregar nueva acción <i class="fa fa-plus"></i></a>' +
                    '</div>' +
                    '<table id="accion-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                    '<thead>' +
                    '<tr role="row" class="heading">' +
                    '<td>Fecha</td>' +
                    '<td>Desde</td>' +
                    '<td>Hasta</td>' +
                    '<td>Horas</td>' +
                    '<td>Descripción</td>' +
                    '<td>Gastos</td>' +
                    '<td></td>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody></tbody>' +
                    '</table>' +
                    '</td>' +
                    '</tr>';

                $("#tarea-select-" + id).after(html);
                $("#acciones-" + id).fadeIn();

                var tr, descripcion;

                $.each(JSON.parse(result), function(idx, obj) {

                    descripcion = obj.descripcion;

                    tr = $('<tr id="accion-select-'+ obj.id +'">');
                    tr.append('<td>'+ obj.fecha_accion +'</td>');
                    tr.append('<td>'+ obj.desde +'</td>');
                    tr.append('<td>'+ obj.hasta +'</td>');
                    tr.append('<td>'+ obj.horas +'</td>');
                    tr.append('<td data-tooltip="'+ obj.descripcion +'">'+ descripcion.substr(0,50) + "..." +'</td>');
                    tr.append('<td>S/ '+ obj.gastos +'</td>');
                    tr.append('<td class="text-center">' +
                        '<div class="btn-group">' +
                        '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos' +
                        '<i class="fa fa-angle-down"></i>' +
                        '</button>' +
                        '<ul class="dropdown-menu pull-right" role="menu">' +
                        '<li><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></li>' +
                        '<li><a href="'+ obj.url_lista_gastos +'" data-target="#ajax" data-toggle="modal">Gastos</a></li>' +
                        '</ul>' +
                        '</div>' +
                        '</td>' +
                        '</tr>');
                    $("#accion-lista-"+id+" tbody").append(tr);
                });

                $(".accion-cerrar").on("click", function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $("#acciones-" + id).fadeOut();
                });
            },
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            error: function(error) {
                console.log("ERROR: Lista de Acciones");
                console.log(error);
            }
        });
    });
}
//# sourceMappingURL=js-funciones.js.map
