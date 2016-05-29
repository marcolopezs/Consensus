@extends('layouts.system')

@section('title')
    Contactos de Cliente: {{ $prin->cliente }}
@stop

@section('contenido_header')
{{-- Select2 --}}
{!! HTML::style('assets/global/plugins/select2/css/select2.min.css') !!}
{!! HTML::style('assets/global/plugins/select2/css/select2-bootstrap.min.css') !!}
@stop

@section('contenido_body')

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">Editar registro</span>
                    </div>
                </div>
                <div class="portlet-body form">

                    {!! Form::model($row, ['route' => ['cliente.contactos.update', $prin->id, $row->id], 'method' => 'PUT', 'id' => 'formCreate', 'class' => 'form-horizontal']) !!}

                    <div class="form-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('contacto', 'Contacto', ['class' => 'col-md-2 control-label']) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('contacto', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('dni', 'DNI', ['class' => 'col-md-2 control-label']) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('dni', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('ruc', 'RUC', ['class' => 'col-md-2 control-label']) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('ruc', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email', ['class' => 'col-md-2 control-label']) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('telefono', 'Teléfono', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('fax', 'Fax', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('fax', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('direccion', 'Dirección', ['class' => 'col-md-2 control-label']) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('pais', 'País', ['class' => 'col-md-2 control-label']) !!}
                                    <div class="col-md-10">
                                        {!! Form::select('pais', ['' => ''] + $pais, $row->pais_id, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="form-actions left">
                        <a href="{{ route('cliente.index') }}" class="btn default">Cancelar</a>
                        <button type="submit" class="btn blue"><i class='fa fa-check'></i> Guardar</button>
                    </div>


                    {!! Form::close() !!}

                </div>
            </div>

        </div>

    </div>

@stop

@section('contenido_footer')
{{-- Select2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}
<script>
    $(document).on("ready", function(){

        var placeholder = "Seleccionar";

        $('.select2').select2({
            placeholder: placeholder
        });

        $('.js-data-example-ajax').select2({
            placeholder: 'Busca productos para relacionar',
            minimumInputLength: 2,
            ajax: {
                url: '{{ route('cliente.all') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });

        function formatRepo (repo) {
            if (repo.loading) return repo.text;

            var markup = "<div class='select2-result-options clearfix'>" +
                    "<div class='select2-result-options__meta'>" +
                    "<div class='select2-result-options__title'>" + repo.cliente + "</div></div></div>";

            return markup;
        }

        function formatRepoSelection (repo) {
            return repo.cliente || repo.id;
        }
    });
</script>
@stop