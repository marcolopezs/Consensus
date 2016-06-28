<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Lista de gastos de Tarea</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div id="tarea-nueva" class="portlet-body">

                <div class="col-md-12 text-left">
                    <h4>Acción: <strong>{{ $rows->descripcion }}</strong></h4>
                </div>

                <div class="col-md-12">
                    <div class="form-content"></div>
                </div>

                <div class="col-md-12 col-sm-12">

                    <div class="portlet light">

                        <div class="portlet-body">

                            <table class="table table-striped table-bordered table-hover">

                                <thead>
                                    <tr>
                                        <th> Referencia </th>
                                        <th> Moneda </th>
                                        <th> Monto </th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
</div>

{{-- SELECT2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}

{{-- GASTOS DE ACCION --}}
{!! HTML::script('js/js-tarea-agregar-gastos.js') !!}