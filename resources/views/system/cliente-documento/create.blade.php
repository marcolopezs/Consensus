<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Agregar nuevo registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            <div class="dropzone"></div>

        </div>

    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
</div>

<script>

    $("#formCreateClose").on("click", function (e) {
        e.preventDefault();

        $("#ajax-modal").modal('hide');
        location.reload();

    });

</script>