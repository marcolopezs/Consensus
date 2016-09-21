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

Route::get('/imagenes/{folder}/{width}x{height}/{image}', ['as' => 'image.adaptiveResize', 'uses' => 'ImageController@adaptiveResize']);

Route::group(['namespace' => 'System', 'middleware' => 'auth'], function () use ($prefixedResourceNames) {

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    //CONFIGURACIONES DEL SISTEMA
    Route::get('configuracion', ['as' => 'system.conf', 'uses' => 'ConfController@confGet']);
    Route::post('configuracion', ['as' => 'system.conf.post', 'uses' => 'ConfController@confPost']);

    //TAREAS ASIGNADAS A ABOGADO
    Route::get('tareas-asignadas', ['as' => 'tareas.asignadas', 'uses' => 'TareasAsignadasController@tareas']);
    Route::get('tareas-asignadas/exportar/excel', ['as' => 'tareas.asignadas.excel', 'uses' => 'TareasAsignadasController@excel']);
    Route::resource('tareas.acciones', 'TareasAsignadasController');
    Route::resource('accion.gastos', 'TareasAccionGastosController');

    //DOCUMENTOS
    Route::get('documentos/{id}/download', ['as' => 'documentos.download', 'uses' => 'DocumentosController@download']);
    Route::post('documentos/upload', ['as' => 'documentos.upload', 'uses' => 'DocumentosController@upload']);

    //EXPEDIENTES
    Route::resource('expedientes', 'ExpedientesController', ['except' => 'destroy']);
    Route::get('expedientes/cliente/{id}', ['as' => 'expedientes.cliente', 'uses' => 'ExpedientesController@cliente']);
    Route::post('expedientes/ajustes', ['as' => 'expedientes.ajustes', 'uses' => 'ExpedientesController@ajustes']);
    Route::get('expedientes/filtrar', ['as' => 'expedientes.filtrar', 'uses' => 'ExpedientesController@filtrar']);
    Route::post('expedientes/abogado/{abogado}/tarifa/{tarifa}', ['as' => 'expedientes.abogado.tarifa', 'uses' => 'ExpedientesController@abogadoTarifa']);
    Route::get('expedientes/exportar/excel', ['as' => 'expedientes.excel', 'uses' => 'ExpedientesController@excel']);

    //EXPEDIENTES - DOCUMENTOS
    Route::resource('expedientes.documentos', 'ExpDocumentosController', ['except' => 'destroy']);
    Route::get('expedientes/{expedientes}/documentos/{documentos}/file', ['as' => 'expedientes.documentos.file.get', 'uses' => 'ExpDocumentosController@fileGet']);
    Route::delete('expedientes/{expedientes}/documentos/{documentos}/file/destroy', ['as' => 'expedientes.documentos.file.destroy', 'uses' => 'ExpDocumentosController@fileDestroy']);

    //EXPEDIENTES - INTERVINIENTES
    Route::resource('expedientes.intervinientes', 'IntervinientesController', ['except' => 'destroy']);

    //EXPEDIENTES - TAREAS
    Route::resource('expedientes.tareas', 'TareasController', ['except' => 'destroy']);

    //EXPEDIENTES - TAREAS - NOTIFICACIONES
    Route::resource('expedientes.tareas.notificacion', 'TareasNotificacionController', ['except' => 'destroy']);

    //EXPEDIENTES - FLUJO DE CAJA
    Route::resource('expedientes.flujo-caja', 'FlujoCajaController', ['except' => 'destroy']);

    //CLIENTES
    Route::resource('cliente', 'ClienteController', ['except' => 'destroy']);
    Route::post('cliente/{id}/estado', ['as' => 'cliente.estado', 'uses' => 'ClienteController@estado']);
    Route::get('cliente/{cliente}/user', ['as' => 'cliente.user.get', 'uses' => 'ClienteController@userGet']);
    Route::post('cliente/{cliente}/user', ['as' => 'cliente.user.post', 'uses' => 'ClienteController@userPost']);
    Route::post('cliente/{cliente}/user-name', ['as' => 'cliente.user.name', 'uses' => 'ClienteController@userName']);
    Route::get('cliente/exportar/excel', ['as' => 'cliente.excel', 'uses' => 'ClienteController@excel']);

    //CLIENTE - CONTACTO
    Route::resource('cliente.contactos', 'ClienteContactosController', ['except' => 'destroy']);
    Route::post('cliente/contactos/{id}/estado', ['as' => 'cliente.contactos.estado', 'uses' => 'ClienteContactosController@estado']);

    //CLIENTE - DOCUMENTOS
    Route::resource('cliente.documentos', 'ClienteDocumentosController', ['except' => 'destroy']);

    //CLIENTE - JSON
    Route::get('cliente-all', ['as' => 'cliente.all', 'uses' => 'ClienteController@buscarCliente']);

    //OPCIONES
    Route::group(['prefix' => 'options'], function () use ($prefixedResourceNames) {

        //TIPO DE CAMBIO
        Route::resource('money', 'MoneyController', ['names' => $prefixedResourceNames('money'), 'except' => 'destroy']);
        Route::post('mony/{id}/estado', ['as' => 'money.estado', 'uses' => 'MoneyController@estado']);
        Route::get('money/exportar/excel', ['as' => 'money.excel', 'uses' => 'MoneyController@excel']);

        //FORMAS DE PAGO
        Route::resource('payment-method', 'PaymentMethodController', ['names' => $prefixedResourceNames('payment-method'), 'except' => 'destroy']);
        Route::post('payment-method/{id}/estado', ['as' => 'payment-method.estado', 'uses' => 'PaymentMethodController@estado']);
        Route::get('payment-method/exportar/excel', ['as' => 'payment-method.excel', 'uses' => 'PaymentMethodController@excel']);

        //TARIFAS
        Route::resource('tariff', 'TariffController', ['names' => $prefixedResourceNames('tariff'), 'except' => 'destroy']);
        Route::post('tariff/{id}/estado', ['as' => 'tariff.estado', 'uses' => 'TariffController@estado']);
        Route::get('tariff/exportar/excel', ['as' => 'tariff.excel', 'uses' => 'TariffController@excel']);

        //SERVICIOS
        Route::resource('service', 'ServiceController', ['names' => $prefixedResourceNames('service'), 'except' => 'destroy']);
        Route::post('service/{id}/estado', ['as' => 'service.estado', 'uses' => 'ServiceController@estado']);
        Route::post('service-fecha/{service}', ['as' => 'service.fecha', 'uses' => 'ServiceController@serviceFecha']);
        Route::post('service-fecha-sumadias', ['as' => 'service.fecha.suma', 'uses' => 'ServiceController@serviceFechaSuma']);
        Route::get('service/exportar/excel', ['as' => 'service.excel', 'uses' => 'ServiceController@excel']);

        //INSTANCIAS
        Route::resource('instance', 'InstanceController', ['names' => $prefixedResourceNames('instance'), 'except' => 'destroy']);
        Route::post('instance/{id}/estado', ['as' => 'instance.estado', 'uses' => 'InstanceController@estado']);
        Route::get('instance/exportar/excel', ['as' => 'instance.excel', 'uses' => 'InstanceController@excel']);

        //MATERIAS
        Route::resource('matter', 'MatterController', ['names' => $prefixedResourceNames('matter'), 'except' => 'destroy']);
        Route::post('matter/{id}/estado', ['as' => 'matter.estado', 'uses' => 'MatterController@estado']);
        Route::get('matter/exportar/excel', ['as' => 'matter.excel', 'uses' => 'MatterController@excel']);

        //ENTIDADES
        Route::resource('entity', 'EntityController', ['names' => $prefixedResourceNames('entity'), 'except' => 'destroy']);
        Route::post('entity/{id}/estado', ['as' => 'entity.estado', 'uses' => 'EntityController@estado']);
        Route::get('entity/exportar/excel', ['as' => 'entity.excel', 'uses' => 'EntityController@excel']);

        //AREAS
        Route::resource('area', 'AreaController', ['names' => $prefixedResourceNames('area'), 'except' => 'destroy']);
        Route::post('area/{id}/estado', ['as' => 'area.estado', 'uses' => 'AreaController@estado']);
        Route::get('area/exportar/excel', ['as' => 'area.excel', 'uses' => 'AreaController@excel']);

        //SITUACION
        Route::resource('ubicacion', 'UbicacionController', ['names' => $prefixedResourceNames('ubicacion'), 'except' => 'destroy']);
        Route::post('ubicacion/{id}/estado', ['as' => 'ubicacion.estado', 'uses' => 'UbicacionController@estado']);
        Route::get('ubicacion/exportar/excel', ['as' => 'ubicacion.excel', 'uses' => 'UbicacionController@excel']);

        //ESTADOS
        Route::resource('state', 'StateController', ['names' => $prefixedResourceNames('state'), 'except' => 'destroy']);
        Route::post('state/{id}/estado', ['as' => 'state.estado', 'uses' => 'StateController@estado']);
        Route::get('state/exportar/excel', ['as' => 'state.excel', 'uses' => 'StateController@excel']);

        //ESTADOS
        Route::resource('intervener', 'IntervenerController', ['names' => $prefixedResourceNames('intervener'), 'except' => 'destroy']);
        Route::post('intervener/{id}/estado', ['as' => 'intervener.estado', 'uses' => 'IntervenerController@estado']);
        Route::get('intervener/exportar/excel', ['as' => 'intervener.excel', 'uses' => 'IntervenerController@excel']);

        //TIPOS DE GASTOS
        Route::resource('expense-type', 'ExpenseTypeController', ['names' => $prefixedResourceNames('expense-type'), 'except' => 'destroy']);
        Route::post('expense-type/{id}/estado', ['as' => 'expense-type.estado', 'uses' => 'ExpenseTypeController@estado']);
        Route::get('expense-type/exportar/excel', ['as' => 'expense-type.excel', 'uses' => 'ExpenseTypeController@excel']);

        //TIPOS DE EXPEDIENTE
        Route::resource('expediente-tipo', 'ExpedienteTipoController', ['names' => $prefixedResourceNames('expediente-tipo')]);
        Route::post('expediente-tipo/{id}/estado', ['as' => 'expediente-tipo.estado', 'uses' => 'ExpedienteTipoController@estado']);
        Route::get('expediente-tipo/exportar/excel', ['as' => 'expediente-tipo.excel', 'uses' => 'ExpedienteTipoController@excel']);

        //TAREAS - CONCEPTOS
        Route::resource('tarea-concepto', 'TareaConceptoController', ['names' => $prefixedResourceNames('tarea-concepto'), 'except' => 'destroy']);
        Route::post('tarea-concepto/{id}/estado', ['as' => 'tarea-concepto.estado', 'uses' => 'TareaConceptoController@estado']);
        Route::get('tarea-concepto/exportar/excel', ['as' => 'tarea-concepto.excel', 'uses' => 'TareaConceptoController@excel']);
    });

    //FACTURACION
    Route::resource('facturacion', 'FacturacionController');
    Route::get('facturacion/exportar/excel', ['as' => 'facturacion.excel', 'uses' => 'FacturacionController@excel']);

    //USUARIO
    Route::resource('users', 'UsersController', ['except' => 'destroy']);
    Route::put('users/update/admin/{id}', ['as' => 'users.update.admin', 'uses' => 'UsersController@updateAdmin']);
    Route::put('users/update/abogado/{id}', ['as' => 'users.update.abogado', 'uses' => 'UsersController@updateAbogado']);
    Route::put('users/update/asistente/{id}', ['as' => 'users.update.asistente', 'uses' => 'UsersController@updateAsistente']);
    Route::put('users/update/cliente/{id}', ['as' => 'users.update.cliente', 'uses' => 'UsersController@updateCliente']);
    Route::post('users/{id}/estado', ['as' => 'users.estado', 'uses' => 'UsersController@estado']);
    Route::get('users/exportar/excel', ['as' => 'users.excel', 'uses' => 'UsersController@excel']);

    Route::put('users/{id}/abogado/tarifa', ['as' => 'abogado.tarifas.update', 'uses' => 'UsersController@abogadoTarifaUpdate']);
    Route::post('users/{id}/abogado/foto', ['as' => 'abogado.foto.upload', 'uses' => 'UsersController@abogadoFotoUpload']);
    Route::post('users/{id}/abogado/foto/delete', ['as' => 'abogado.foto.delete', 'uses' => 'UsersController@abogadoFotoDelete']);
    Route::post('users/{id}/abogado/password', ['as' => 'abogado.password', 'uses' => 'UsersController@abogadoPassword']);
    Route::post('users/{id}/abogado/permisos', ['as' => 'abogado.permisos', 'uses' => 'UsersController@abogadoPermisos']);

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