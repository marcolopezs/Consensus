<div class="modal-header">
    <h4 class="modal-title">Crear nuevo registro</h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::open(['route' => 'area.store', 'method' => 'POST', 'id' => 'formCreate', 'onkeypress' => 'return anular(event)']) !!}

                <div class="form-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo') !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

            {!! Form::close() !!}

        </div>
    </div>

    @include('partials.progressbar')

</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose">Cerrar</a>
    <a class="btn blue" id="formCreateSubmit" href="javascript:;">Guardar</a>
</div>

{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}
{!! HTML::script('js/js-form-close.js') !!}

{{-- JS Create --}}
{!! HTML::script('js/js-create-edit.js') !!}
<script>
    $("#formCreateClose").on("click", function (e) {
        e.preventDefault();
        var titulo = $("#titulo").val(), email = $("#email").val();
        formClose([titulo, email]);
    });
</script>