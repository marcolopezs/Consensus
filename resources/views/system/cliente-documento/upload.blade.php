<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Administrar versiones</h4>
</div>
<div class="modal-body">
    <div class="row">

        <div class="col-md-6">
            Versiones:
            <ul class="version-file">
                @foreach($row->historiesFile as $item)
                {{--*/
                $contenido = json_decode($item->descripcion, true);
                $fecha = fecha($item->created_at);
                $usuario = $item->user->nombre_completo;
                /*--}}
                <li>
                    <div class="datos">
                        <span class="archivo">{{ $contenido['archivo'] }}</span>
                    </div>
                    <div class="fecha-usuario">
                        <span class="fecha">{{ $fecha }}</span>
                        <span class="usuario">{{ $usuario }}</span>
                    </div>
                    <div class="download">
                        <span>
                            <a href="{{ route('cliente.documentos.download.his', [$prin->id, $row->id, $item->id]) }}">
                                <i class="fa fa-download fa-2x" aria-hidden="true"></i>
                            </a>
                        </span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-6">
            {!! Form::open(['route' => ['cliente.documentos.upload.put', $prin->id, $row->id], 'method' => 'PUT', 'class' => 'dropzone']) !!}
            {!! Form::close() !!}
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