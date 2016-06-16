<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$prefixedResourceNames = function($prefix) {
    return [
        'index'   => $prefix . '.index',
        'create'  => $prefix . '.create',
        'store'   => $prefix . '.store',
        'show'    => $prefix . '.show',
        'edit'    => $prefix . '.edit',
        'update'  => $prefix . '.update',
        'destroy' => $prefix . '.destroy'
    ];
};

Route::group(['namespace' => 'System', 'middleware' => 'auth'], function () use ($prefixedResourceNames) {

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    //DOCUMENTOS
    Route::get('documentos/{id}/download', ['as' => 'documentos.download', 'uses' => 'DocumentosController@download']);
    Route::post('documentos/upload', ['as' => 'documentos.upload', 'uses' => 'DocumentosController@upload']);

    //EXPEDIENTES
    Route::resource('expedientes', 'ExpedientesController', ['except' => 'destroy']);
    Route::get('expedientes/cliente/{id}', ['as' => 'expedientes.cliente', 'uses' => 'ExpedientesController@cliente']);
    Route::post('expedientes/ajustes', ['as' => 'expedientes.ajustes', 'uses' => 'ExpedientesController@ajustes']);
    Route::get('expedientes/filtrar', ['as' => 'expedientes.filtrar', 'uses' => 'ExpedientesController@filtrar']);

    //EXPEDIENTES - DOCUMENTOS
    Route::resource('expedientes.documentos', 'ExpDocumentosController', ['except' => 'destroy']);

    //EXPEDIENTES - INTERVINIENTES
    Route::resource('expedientes.intervinientes', 'IntervinientesController', ['except' => 'destroy']);

    //EXPEDIENTES - TAREAS
    Route::resource('expedientes.tareas', 'TareasController', ['except' => 'destroy']);

    //EXPEDIENTES - FLUJO DE CAJA
    Route::resource('expedientes.flujo-caja', 'FlujoCajaController', ['except' => 'destroy']);

    //CLIENTES
    Route::resource('cliente', 'ClienteController', ['except' => 'destroy']);
    Route::post('cliente/{id}/estado', ['as' => 'cliente.estado', 'uses' => 'ClienteController@estado']);
    Route::get('cliente/{cliente}/user', ['as' => 'cliente.user.get', 'uses' => 'ClienteController@userGet']);
    Route::post('cliente/{cliente}/user', ['as' => 'cliente.user.post', 'uses' => 'ClienteController@userPost']);
    Route::post('cliente/{cliente}/user-name', ['as' => 'cliente.user.name', 'uses' => 'ClienteController@userName']);

    //CLIENTE - CONTACTO
    Route::resource('cliente.contactos', 'ClienteContactosController', ['except' => 'destroy']);
    Route::post('cliente/contactos/{id}/estado', ['as' => 'cliente.contactos.estado', 'uses' => 'ClienteContactosController@estado']);

    //CLIENTE - DOCUMENTOS
    Route::resource('cliente.documentos', 'ClienteDocumentosController', ['except' => 'destroy']);
    Route::get('cliente/{cliente}/documentos/{doc}/download', ['as' => 'cliente.documentos.download', 'uses' => 'ClienteDocumentosController@download']);
    Route::get('cliente/{cliente}/documentos/{doc}/downloadHis/{his}', ['as' => 'cliente.documentos.download.his', 'uses' => 'ClienteDocumentosController@downloadHistory']);
    Route::get('cliente/{cliente}/documentos/{doc}/upload', ['as' => 'cliente.documentos.upload.get', 'uses' => 'ClienteDocumentosController@uploadGet']);
    Route::put('cliente/{cliente}/documentos/{doc}/upload', ['as' => 'cliente.documentos.upload.put', 'uses' => 'ClienteDocumentosController@uploadPut']);

    //KARDEX
    Route::resource('kardex', 'KardexController', ['except' => 'destroy']);
    Route::post('kardex/{id}/estado', ['as' => 'kardex.estado', 'uses' => 'KardexController@estado']);

    //CLIENTE - JSON
    Route::get('cliente-all', ['as' => 'cliente.all', 'uses' => 'ClienteController@buscarCliente']);

    //OPCIONES
    Route::group(['prefix' => 'options'], function () use ($prefixedResourceNames) {

        //TIPO DE CAMBIO
        Route::resource('money', 'MoneyController', ['names' => $prefixedResourceNames('money'), 'except' => 'destroy']);
        Route::post('mony/{id}/estado', ['as' => 'money.estado', 'uses' => 'MoneyController@estado']);

        //FORMAS DE PAGO
        Route::resource('payment-method', 'PaymentMethodController', ['names' => $prefixedResourceNames('payment-method'), 'except' => 'destroy']);
        Route::post('payment-method/{id}/estado', ['as' => 'payment-method.estado', 'uses' => 'PaymentMethodController@estado']);

        //TARIFAS
        Route::resource('tariff', 'TariffController', ['names' => $prefixedResourceNames('tariff'), 'except' => 'destroy']);
        Route::post('tariff/{id}/estado', ['as' => 'tariff.estado', 'uses' => 'TariffController@estado']);

        //SERVICIOS
        Route::resource('service', 'ServiceController', ['names' => $prefixedResourceNames('service'), 'except' => 'destroy']);
        Route::post('service/{id}/estado', ['as' => 'service.estado', 'uses' => 'ServiceController@estado']);
        Route::post('service-fecha/{service}', ['as' => 'service.fecha', 'uses' => 'ServiceController@serviceFecha']);
        Route::post('service-fecha-sumadias', ['as' => 'service.fecha.suma', 'uses' => 'ServiceController@serviceFechaSuma']);

        //INSTANCIAS
        Route::resource('instance', 'InstanceController', ['names' => $prefixedResourceNames('instance'), 'except' => 'destroy']);
        Route::post('instance/{id}/estado', ['as' => 'instance.estado', 'uses' => 'InstanceController@estado']);

        //MATERIAS
        Route::resource('matter', 'MatterController', ['names' => $prefixedResourceNames('matter'), 'except' => 'destroy']);
        Route::post('matter/{id}/estado', ['as' => 'matter.estado', 'uses' => 'MatterController@estado']);

        //ENTIDADES
        Route::resource('entity', 'EntityController', ['names' => $prefixedResourceNames('entity'), 'except' => 'destroy']);
        Route::post('entity/{id}/estado', ['as' => 'entity.estado', 'uses' => 'EntityController@estado']);

        //AREAS
        Route::resource('area', 'AreaController', ['names' => $prefixedResourceNames('area'), 'except' => 'destroy']);
        Route::post('area/{id}/estado', ['as' => 'area.estado', 'uses' => 'AreaController@estado']);

        //SITUACION
        Route::resource('ubicacion', 'UbicacionController', ['names' => $prefixedResourceNames('ubicacion'), 'except' => 'destroy']);
        Route::post('ubicacion/{id}/estado', ['as' => 'ubicacion.estado', 'uses' => 'UbicacionController@estado']);

        //ESTADOS
        Route::resource('state', 'StateController', ['names' => $prefixedResourceNames('state'), 'except' => 'destroy']);
        Route::post('state/{id}/estado', ['as' => 'state.estado', 'uses' => 'StateController@estado']);

        //ESTADOS
        Route::resource('intervener', 'IntervenerController', ['names' => $prefixedResourceNames('intervener'), 'except' => 'destroy']);
        Route::post('intervener/{id}/estado', ['as' => 'intervener.estado', 'uses' => 'IntervenerController@estado']);

        //TIPOS DE GASTOS
        Route::resource('expense-type', 'ExpenseTypeController', ['names' => $prefixedResourceNames('expense-type'), 'except' => 'destroy']);
        Route::post('expense-type/{id}/estado', ['as' => 'expense-type.estado', 'uses' => 'ExpenseTypeController@estado']);

        //TIPOS DE KARDEX
        Route::resource('expediente-tipo', 'ExpedienteTipoController', ['names' => $prefixedResourceNames('expediente-tipo'), 'except' => 'destroy']);
        Route::post('expediente-tipo/{id}/estado', ['as' => 'expediente-tipo.estado', 'uses' => 'ExpedienteTipoController@estado']);

    });

    //USUARIO
    Route::resource('users', 'UsersController', ['except' => 'destroy']);

    //USUARIO - MI PERFIL
    Route::get('user/perfil', ['as' => 'users.perfil', 'uses' => 'UsersController@perfil']);

});

//AUTH
Route::group(['namespace' => 'Auth'], function () {

    //LOGIN
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', 'AuthController@postLogin');

    //ACTIVAR CUENTA
    Route::get('active/{codigo}', ['as' => 'auth.active', 'uses' => 'AuthController@getActive']);

    //RECUPEAR CONTRASEÑA
    Route::get('login-password', ['as' => 'auth.login.password', 'uses' => 'PasswordController@getEmail']);
    Route::post('login-password', ['as' => 'auth.login.password', 'uses' => 'PasswordController@postEmail']);

    //RESTABLECER CONTRASEÑA
    Route::get('login-password/reset/{token}', 'PasswordController@getReset');
    Route::post('login-password/reset', 'PasswordController@postReset');

    //LOGOUT
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

});