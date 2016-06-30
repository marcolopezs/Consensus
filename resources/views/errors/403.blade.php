@extends('layouts.system')

@section('contenido_header')
    {!! HTML::style('assets/pages/css/error.min.css') !!}
@endsection

@section('contenido_body')
<div class="row">
    <div class="col-md-12 page-500">
        <div class=" number font-red"> 403 </div>
        <div class=" details">
            <h3>No tienes acceso a esta sección</h3>
            <p><a href="index.html" class="btn red btn-outline"> Regresar a Dashboard </a></p>
        </div>
    </div>
</div>
@endsection