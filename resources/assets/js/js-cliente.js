//MOSTRAR CONTACTOS DE CLIENTE
$(".cliente-contacto").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var list = $(this).data('list');
    var create = $(this).data('create');

    $.ajax({
        url: list,
        type: 'GET',
        success: function(result){
            var html = '<tr id="contacto-'+id+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23">' +
                '<div class="btn-group pull-left">' +
                '<h3 class="table-title">Contactos</h3>' +
                '</div>' +
                '<div class="btn-group pull-right table-botones">' +
                '<a class="btn sbold white contacto-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                '<a class="btn sbold blue-soft" href="'+create+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo contacto <i class="fa fa-plus"></i></a>' +
                '</div>' +
                '<table id="contacto-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                '<thead>' +
                '<tr role="row" class="heading">' +
                '<td>Contacto</td>' +
                '<td>DNI</td>' +
                '<td>RUC</td>' +
                '<td>Email</td>' +
                '<td>Acciones</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#cliente-" + id).after(html);
            $("#contacto-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="contacto-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.contacto +'</td>');
                tr.append('<td>'+ obj.dni +'</td>');
                tr.append('<td>'+ obj.ruc +'</td>');
                tr.append('<td>'+ obj.email +'</td>');
                tr.append('<td><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>');
                $("#contacto-lista-"+id+" tbody").prepend(tr);
            });

            $(".contacto-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#contacto-" + id).remove();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function(result) {
            console.log(result)
        }
    });

});

//MOSTRAR DOCUMENTOS DE CLIENTE
$(".cliente-documento").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var list = $(this).data('list');
    var create = $(this).data('create');

    $.ajax({
        url: list,
        type: 'GET',
        success: function(result){
            console.log(result);
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
                '<td>Titulo</td>' +
                '<td>Descripción</td>' +
                '<td>Fecha subida</td>' +
                '<td>Descargar</td>' +
                '<td>Acciones</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#cliente-" + id).after(html);
            $("#documento-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="documento-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.titulo +'</td>');
                tr.append('<td>'+ obj.descripcion +'</td>');
                tr.append('<td>'+ obj.fecha_subida +'</td>');
                tr.append('<td class="text-center"><a href="'+ obj.descargar +'">'+ obj.descargar +'</a></td>');
                tr.append('<td><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>');
                $("#documento-lista-"+id+" tbody").prepend(tr);
            });

            $(".documento-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#documento-" + id).remove();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function(result) {
            console.log(result)
        }
    });

});