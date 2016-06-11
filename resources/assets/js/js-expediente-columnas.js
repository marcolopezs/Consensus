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