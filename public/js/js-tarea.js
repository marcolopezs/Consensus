//MOSTRAR ACCIONES DE TAREA DEL EXPEDIENTE
$(".tarea-acciones").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var list = $(this).data('list');
    var create = $(this).data('create');

    $.ajax({
        url: list,
        type: 'GET',
        success: function(result){

            var html = '<tr id="accion-'+id+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23">' +
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
                                        '<td>Descripcion</td>' +
                                        '<td></td>' +
                                    '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                '</tbody>' +
                            '</table>' +
                        '</td></tr>';

            $("#tarea-" + id).after(html);
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="accion-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.fecha_accion +'</td>');
                tr.append('<td>'+ obj.desde +'</td>');
                tr.append('<td>'+ obj.hasta +'</td>');
                tr.append('<td>'+ obj.horas +'</td>');
                tr.append('<td>'+ obj.descripcion +'</td>');
                tr.append('<td class="text-center">' +
                                '<div class="btn-group">' +
                                    '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos' +
                                        '<i class="fa fa-angle-down"></i>' +
                                    '</button>' +
                                    '<ul class="dropdown-menu pull-right" role="menu">' +
                                        '<li><a href="'+ obj.url_lista_gastos +'" data-target="#ajax" data-toggle="modal">Gastos</a></li>' +
                                        '<li><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></li>' +
                                        '<li><a href="#" data-url="'+ obj.url_eliminar +'" data-title="'+ obj.descripcion +'" data-accion="'+ obj.id +'" class="btn-delete">Eliminar</a></li>' +
                                    '</ul>' +
                                '</div>' +
                            '</td></tr>');
                $("#accion-lista-"+id+" tbody").append(tr);

            });
            $("#accion-" + id).fadeIn();

            borrarAccion();

            var tr;

            $(".accion-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#accion-" + id).fadeOut();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function() {

        }
    });

});
//# sourceMappingURL=js-tarea.js.map
