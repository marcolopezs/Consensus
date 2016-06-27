//MOSTRAR TAREAS DE EXPEDIENTE
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
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#tarea-" + id).after(html);
            $("#accion-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="accion-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.fecha_accion +'</td>');
                tr.append('<td>'+ obj.desde +'</td>');
                tr.append('<td>'+ obj.hasta +'</td>');
                tr.append('<td>'+ obj.horas +'</td>');
                tr.append('<td>'+ obj.descripcion +'</td>');
                $("#accion-lista-"+id+" tbody").prepend(tr);
            });

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