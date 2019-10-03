$(".col-hide").on("click",function(){var e=$(this).attr("id");$(this).prop("checked")?$("."+e).show():$("."+e).hide()}),$("#ajustes-expediente").on("click",function(){$("#ajustes-expediente-panel").slideToggle()}),$("#ajustes-expediente-cancelar").on("click",function(){$("#ajustes-expediente-panel").slideUp()});var ajustes=$("#expediente-ajustes-data").text(),js=JSON.parse(ajustes);1==getValues(js,"ch-expediente")?$(".col-expediente").show():$(".col-expediente").hide(),1==getValues(js,"ch-cliente")?$(".col-cliente").show():$(".col-cliente").hide(),1==getValues(js,"ch-moneda")?$(".col-moneda").show():$(".col-moneda").hide(),1==getValues(js,"ch-valor")?$(".col-valor").show():$(".col-valor").hide(),1==getValues(js,"ch-tarifa")?$(".col-tarifa").show():$(".col-tarifa").hide(),1==getValues(js,"ch-abogado")?$(".col-abogado").show():$(".col-abogado").hide(),1==getValues(js,"ch-asistente")?$(".col-asistente").show():$(".col-asistente").hide(),1==getValues(js,"ch-servicio")?$(".col-servicio").show():$(".col-servicio").hide(),1==getValues(js,"ch-fecha-inicio")?$(".col-fecha-inicio").show():$(".col-fecha-inicio").hide(),1==getValues(js,"ch-fecha-termino")?$(".col-fecha-termino").show():$(".col-fecha-termino").hide(),1==getValues(js,"ch-materia")?$(".col-materia").show():$(".col-materia").hide(),1==getValues(js,"ch-entidad")?$(".col-entidad").show():$(".col-entidad").hide(),1==getValues(js,"ch-instancia")?$(".col-instancia").show():$(".col-instancia").hide(),1==getValues(js,"ch-encargado")?$(".col-encargado").show():$(".col-encargado").hide(),1==getValues(js,"ch-fecha-poder")?$(".col-fecha-poder").show():$(".col-fecha-poder").hide(),1==getValues(js,"ch-fecha-vencimiento")?$(".col-fecha-vencimiento").show():$(".col-fecha-vencimiento").hide(),1==getValues(js,"ch-area")?$(".col-area").show():$(".col-area").hide(),1==getValues(js,"ch-jefe-area")?$(".col-jefe-area").show():$(".col-jefe-area").hide(),1==getValues(js,"ch-bienes")?$(".col-bienes").show():$(".col-bienes").hide(),1==getValues(js,"ch-situacion")?$(".col-situacion").show():$(".col-situacion").hide(),1==getValues(js,"ch-estado")?$(".col-estado").show():$(".col-estado").hide(),1==getValues(js,"ch-exito")?$(".col-exito").show():$(".col-exito").hide(),$("#filtrar-expediente").on("click",function(){$("#filtrar-expediente-panel").slideToggle()}),$("#filtrar-expediente-cancelar").on("click",function(){$("#filtrar-expediente-panel").slideUp()}),$(".select2-clear").on("click",function(){var e=$(this).data("id");$("."+e+" .select2").val(null).trigger("change")}),$(".text-clear").on("click",function(){var e=$(this).data("id");$("."+e+" .form-control").val(null)}),$(".expediente-tareas").on("click",function(e){e.preventDefault();var t=$(this).data("id"),a=$(this).data("list"),d=$(this).data("create");$.ajax({url:a,type:"GET",success:function(e){var a='<tr id="tarea-'+t+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23"><div class="btn-group pull-left"><h3 class="table-title">Tareas</h3></div><div class="btn-group pull-right table-botones"><a class="btn sbold white tarea-cerrar" href="#" data-id="'+t+'"> Cerrar </a><a class="btn sbold blue-soft" href="'+d+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo tarea <i class="fa fa-plus"></i></a></div><table id="tarea-lista-'+t+'" class="table table-striped table-bordered table-hover order-column"><thead><tr role="row" class="heading"><td class="text-center">Solicitada</td><td class="text-center">Finalizado</td><td>Tarea</td><td>Descripción</td><td>Asignado</td><td class="text-center">Tiempo</td><td class="text-center">Gastos</td><td class="text-center">Estado</td><td></td></tr></thead><tbody></tbody></table></td></tr>';$("#exp-"+t).after(a),$("#tarea-"+t).fadeIn();var o,s,n;$.each(JSON.parse(e),function(e,a){s=a.descripcion,n=a.estado_nombre,o=$('<tr id="tarea-select-'+a.id+'">'),o.append('<td class="text-center">'+a.fecha_solicitada+"</td>"),o.append('<td class="text-center">'+a.fecha_vencimiento+"</td>"),o.append("<td>"+a.titulo_tarea+"</td>"),o.append('<td data-tooltip="'+a.descripcion+'">'+s.substr(0,50)+"...</td>"),o.append("<td>"+a.asignado+"</td>"),o.append('<td class="text-center"><strong>'+a.tiempo_total+"</strong></td>"),o.append('<td class="text-right"><strong>S/ '+a.gastos+"</strong></td>"),o.append('<td class="text-center"><span class="estado-'+n.toLowerCase()+'">'+n+"</span></td>"),o.append('<td class="text-center"><div class="btn-group"><button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos<i class="fa fa-angle-down"></i></button><ul class="dropdown-menu pull-right" role="menu"><li><a href="'+a.url_editar+'" data-target="#ajax" data-toggle="modal">Editar</a></li><li><a href="#" class="expediente-tarea-acciones-lista" data-id="'+a.id+'" data-list="'+a.url_acciones_lista+'" data-create="'+a.url_acciones_crear+'">Acciones</a></li><li><a href="'+a.url_notificacion+'" data-target="#ajax" data-toggle="modal">Notificaciones</a></li></ul></div></td></tr>'),$("#tarea-lista-"+t+" tbody").append(o)}),tareaListaAcciones(),$(".tarea-cerrar").on("click",function(e){e.preventDefault();var t=$(this).data("id");$("#tarea-"+t).fadeOut()})},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},error:function(){}})}),$(".expediente-caja").on("click",function(e){e.preventDefault();var t=$(this).data("id"),a=$(this).data("list"),d=$(this).data("create"),o=$(this).data("exportar"),s=$(this).data("saldo");$.ajax({url:a,type:"GET",success:function(e){var a='<tr id="caja-'+t+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23"><div class="row"><div class="col-md-3"><h3 class="table-title">Flujo de Caja</h3></div><div class="col-md-3 text-center"><h3 class="table-title">Saldo: S/. '+s+'</h3></div><div class="col-md-6"><div class="pull-right btn-group table-botones">';o&&(a+='<a class="btn sbold green caja-exportar" href="'+o+'"> Exportar </a>'),a+='<a class="btn sbold white caja-cerrar" href="#" data-id="'+t+'"> Cerrar </a><a class="btn sbold blue-soft" href="'+d+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo flujo de caja <i class="fa fa-plus"></i></a></div></div></div><table id="caja-lista-'+t+'" class="table table-striped table-bordered table-hover order-column"><thead><tr role="row" class="heading"><td>Fecha</td><td>Referencia</td><td>Monto</td><td>Moneda</td><td>Tipo</td><td>Acciones</td></tr></thead><tbody></tbody></table></td></tr>',$("#exp-"+t).after(a),$("#caja-"+t).fadeIn();var n;$.each(JSON.parse(e),function(e,a){n=$('<tr id="caja-select-'+a.id+'">'),n.append("<td>"+a.fecha_caja+"</td>"),n.append("<td>"+a.referencia+"</td>"),n.append("<td>"+a.monto+"</td>"),n.append("<td>"+a.moneda+"</td>"),n.append("<td>"+a.tipo+"</td>"),n.append('<td><a href="'+a.url_editar+'" data-target="#ajax" data-toggle="modal">Editar</a></td>'),$("#caja-lista-"+t+" tbody").prepend(n)}),$(".caja-cerrar").on("click",function(e){e.preventDefault();var t=$(this).data("id");$("#caja-"+t).fadeOut()})},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},error:function(){}})}),$(".expediente-interviniente").on("click",function(e){e.preventDefault();var t=$(this).data("id"),a=$(this).data("list"),d=$(this).data("create");$.ajax({url:a,type:"GET",success:function(e){var a='<tr id="interviniente-'+t+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23"><div class="btn-group pull-left"><h3 class="table-title">Intervinientes</h3></div><div class="btn-group pull-right table-botones"><a class="btn sbold white interviniente-cerrar" href="#" data-id="'+t+'"> Cerrar </a><a class="btn sbold blue-soft" href="'+d+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo interviniente <i class="fa fa-plus"></i></a></div><table id="interviniente-lista-'+t+'" class="table table-striped table-bordered table-hover order-column"><thead><tr role="row" class="heading"><td>Nombre</td><td>Tipo</td><td>DNI</td><td>Teléfono</td><td>Celular</td><td>Email</td><td>Acciones</td></tr></thead><tbody></tbody></table></td></tr>';$("#exp-"+t).after(a),$("#interviniente-"+t).fadeIn();var o;$.each(JSON.parse(e),function(e,a){o=$('<tr id="interviniente-select-'+a.id+'">'),o.append("<td>"+a.nombre+"</td>"),o.append("<td>"+a.tipo+"</td>"),o.append("<td>"+a.dni+"</td>"),o.append("<td>"+a.telefono+"</td>"),o.append("<td>"+a.celular+"</td>"),o.append("<td>"+a.email+"</td>"),o.append('<td><a href="'+a.url_editar+'" data-target="#ajax" data-toggle="modal">Editar</a></td>'),$("#interviniente-lista-"+t+" tbody").prepend(o)}),$(".interviniente-cerrar").on("click",function(e){e.preventDefault();var t=$(this).data("id");$("#interviniente-"+t).fadeOut()})},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},error:function(e){console.log()}})}),$(".expediente-documento").on("click",function(e){e.preventDefault();var t=$(this).data("id"),a=$(this).data("list"),d=$(this).data("create");$.ajax({url:a,type:"GET",success:function(e){var a='<tr id="documento-'+t+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23"><div class="btn-group pull-left"><h3 class="table-title">Documentos</h3></div><div class="btn-group pull-right table-botones"><a class="btn sbold white documento-cerrar" href="#" data-id="'+t+'"> Cerrar </a><a class="btn sbold blue-soft" href="'+d+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo documento <i class="fa fa-plus"></i></a></div><table id="documento-lista-'+t+'" class="table table-striped table-bordered table-hover order-column"><thead><tr role="row" class="heading"><td>Referencia</td><td>Descripción</td><td>Documento</td><td>Acciones</td></tr></thead><tbody></tbody></table></td></tr>';$("#exp-"+t).after(a),$("#documento-"+t).fadeIn();var o;$.each(JSON.parse(e),function(e,a){o=$('<tr id="documento-select-'+a.id+'">'),o.append("<td>"+a.titulo+"</td>"),o.append("<td>"+a.descripcion+"</td>"),o.append('<td class="text-center"><a href="'+a.descargar+'">Descargar</a></td>'),o.append('<td><a href="'+a.url_editar+'" data-target="#ajax" data-toggle="modal">Editar</a></td>'),$("#documento-lista-"+t+" tbody").prepend(o)}),$(".documento-cerrar").on("click",function(e){e.preventDefault();var t=$(this).data("id");$("#documento-"+t).fadeOut()})},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},error:function(e){console.log(e)}})}),$(".expediente-comprobantes").on("click",function(e){e.preventDefault();var t=$(this).data("id"),a=$(this).data("list");$(this).data("create");$.ajax({url:a,type:"GET",success:function(e){console.log(e);var a='<tr id="comprobante-'+t+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23"><div class="btn-group pull-left"><h3 class="table-title">Comprobantes de Pago</h3></div><div class="btn-group pull-right table-botones"><a class="btn sbold white comprobante-cerrar" href="#" data-id="'+t+'"> Cerrar </a></div><table id="comprobante-lista-'+t+'" class="table table-striped table-bordered table-hover order-column"><thead><tr role="row" class="heading"><td>Tipo de Comprobante</td><td>N° de Comprobante</td><td>Fecha</td><td>Moneda</td><td>Importe</td><td>Documento</td></tr></thead><tbody></tbody></table></td></tr>';$("#exp-"+t).after(a),$("#comprobante-"+t).fadeIn();var d;$.each(JSON.parse(e),function(e,a){d=$('<tr id="comprobante-select-'+a.id+'">'),d.append("<td>"+a.tipo_comprobante+"</td>"),d.append("<td>"+a.comprobante_numero+"</td>"),d.append("<td>"+a.fecha+"</td>"),d.append("<td>"+a.moneda+"</td>"),d.append("<td>"+a.importe+"</td>"),d.append('<td class="text-center"><a href="'+a.url_descargar+'">Descargar</a></td>'),$("#comprobante-lista-"+t+" tbody").prepend(d)}),$(".comprobante-cerrar").on("click",function(e){e.preventDefault();var t=$(this).data("id");$("#comprobante-"+t).fadeOut()})},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},error:function(e){console.log(e)}})}),$(".expediente-anulado").on("click",function(e){e.preventDefault();var t=$(this).data("id"),a=$(this).data("anular"),d=$(this).data("title");bootbox.dialog({title:"Anular registro",message:"<strong>Desea anular el expediente:</strong> "+d,closeButton:!1,buttons:{cancel:{label:"Cancelar",className:"default"},success:{label:"Anular",className:"red",callback:function(){$.ajax({url:a,type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},beforeSend:function(){$(".progress").show()},complete:function(){$(".progress").hide()},success:function(e){$("#exp-"+t+" .btn-group button i.fa").remove(),$("#exp-"+t+" .btn-group .dropdown-menu").remove(),$("#exp-"+t).addClass("danger"),$("#exp-"+t+" .btn-group button").removeClass("blue").addClass("red").text("Anulado")},error:function(e){$("#mensajeAjax").show(),$("#mensajeAjax .alert").show().removeClass("alert-success").addClass("alert-danger"),$("#mensajeAjax span").text("Se produjo un error al eliminar el registro"),$(".accion-select-"+accion).show()}})}}}})});