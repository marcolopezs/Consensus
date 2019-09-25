<div class="modal-header">
    <h4 class="modal-title">Expedientes</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Cliente: <strong>{{ $row->cliente }}</strong></h3>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover" style="width: 50%;margin: 0 auto;">
                    <thead>
                        <tr>
                            <th>Expedientes: <strong>{{ $row->cantidad_expedientes }}</strong></th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expedientes as $expediente)
                        <tr>
                            <td>{{ $expediente->expediente }}</td>
                            <td>{{ $expediente->exp_estado }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
</div>