<?php

$prefixedResourceNames = function($prefix) {
    return [
        'index'   => $prefix . '.index',
        'create'  => $prefix . '.create',
        'store'   => $prefix . '.store',
        'show'    => $prefix . '.show',
        'edit'    => $prefix . '.edit',
        'update'  => $prefix . '.update',
        'destroyView' => $prefix . 'destroyView',
        'destroy' => $prefix . '.destroy'
    ];
};

Route::group(['as' => 'api.', 'middleware' => 'auth', 'prefix' => 'api/'],
    function () use ($prefixedResourceNames) {

    Route::get('expedientes/{expediente}/tareas/{tarea}/acciones', ['as' => 'expedientes.tareas.acciones', 'uses' => 'AccionesController@index']);
    Route::get('expedientes/{expediente}/tareas/{tarea}/acciones/{accion}/edit', ['as' => 'expedientes.tareas.acciones.edit', 'uses' => 'AccionesController@edit']);

});