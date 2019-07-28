<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//USUARIOS
$factory->define(\Consensus\Entities\User::class, function ($faker) {
    return [
        'username' => $faker->unique()->userName,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10)
    ];
});

//PERFIL DE USUARIO
$factory->define(\Consensus\Entities\UserProfile::class, function ($faker) use ($factory) {
    return [
        'nombre' => $faker->name,
        'apellidos' => $faker->lastName,
        'email' => $faker->unique()->email
    ];
});

//ROLE DE USUARIO
$factory->define(\Consensus\Entities\UserRole::class, function ($faker) use ($factory) {
    return [
        'create' => 0,
        'update' => 0,
        'delete' => 0,
        'printer' => 0
    ];
});

//CLIENTES
$factory->define(\Consensus\Entities\Cliente::class, function ($faker) use ($factory) {
    return [
        'cliente' => $faker->unique()->catchPhrase,
        'dni' => $faker->unique()->regexify('[0-9]{8,8}'),
        'ruc' => $faker->unique()->regexify('[0-9]{11,11}'),
        'carnet_extranjeria' => $faker->unique()->regexify('[0-9]{12,12}'),
        'pasaporte' => $faker->unique()->regexify('[0-9]{12,12}'),
        'partida_nacimiento' => $faker->unique()->regexify('[0-9]{15,15}'),
        'otros' => $faker->unique()->regexify('[0-9]{15,15}'),
        'email' => $faker->unique()->email,
        'telefono' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber,
        'direccion' => $faker->address,
        'pais_id' => DB::table('paises')->inRandomOrder()->first()->id,
        'estado' => $faker->randomElement([0,1])
    ];
});

//ABOGADOS
$factory->define(\Consensus\Entities\Abogado::class, function ($faker) use ($factory) {
    return [
        'nombre' => $faker->unique()->company,
        'dni' => $faker->unique()->regexify('[0-9]{8,8}'),
        'ruc' => $faker->unique()->regexify('[0-9]{11,11}'),
        'carnet_extranjeria' => $faker->unique()->regexify('[0-9]{12,12}'),
        'pasaporte' => $faker->unique()->regexify('[0-9]{12,12}'),
        'partida_nacimiento' => $faker->unique()->regexify('[0-9]{15,15}'),
        'otros' => $faker->unique()->regexify('[0-9]{15,15}'),
        'email' => $faker->unique()->email,
        'telefono' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber,
        'direccion' => $faker->address,
        'pais_id' => DB::table('paises')->inRandomOrder()->first()->id,
        'estado' => $faker->randomElement([0,1])
    ];
});

//CONTACTOS DE CLIENTE
$factory->define(\Consensus\Entities\ClienteContacto::class, function ($faker) use ($factory) {
    return [
        'cliente_id' => DB::table('clientes')->inRandomOrder()->first()->id,
        'contacto' => $faker->name." ".$faker->lastName,
        'dni' => $faker->regexify('[0-9]{8,8}'),
        'ruc' => $faker->regexify('[0-9]{11,11}'),
        'carnet_extranjeria' => $faker->regexify('[0-9]{12,12}'),
        'pasaporte' => $faker->regexify('[0-9]{12,12}'),
        'partida_nacimiento' => $faker->regexify('[0-9]{15,15}'),
        'otros' => $faker->regexify('[0-9]{15,15}'),
        'email' => $faker->email,
        'telefono' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber,
        'direccion' => $faker->address,
        'pais_id' => DB::table('paises')->inRandomOrder()->first()->id,
        'estado' => $faker->randomElement([0,1])
    ];
});

//DOCUMENTOS DE CLIENTE
$factory->define(\Consensus\Entities\ClienteDocumento::class, function ($faker) use ($factory) {
    return [
        'cliente_id' => DB::table('clientes')->inRandomOrder()->first()->id,
        'titulo' => $faker->sentence(6),
        'descripcion' => $faker->text(rand(100,255))
    ];
});

//EXPEDIENTES
$factory->define(\Consensus\Entities\Expediente::class, function ($faker) use ($factory) {
    $servicio = DB::table('services')->inRandomOrder()->first();
    $dias = $servicio->dias_ejecucion;
    return [
        'expediente' => $faker->regexify('[A-Z]{1,1}-[0-9]{6,6}'),
        'expediente_tipo_id' => DB::table('expediente_tipos')->inRandomOrder()->first()->id,
        'cliente_id' => DB::table('clientes')->inRandomOrder()->first()->id,
        'abogado_id' => DB::table('abogados')->inRandomOrder()->first()->id,
        'tariff_id' => DB::table('tariffs')->inRandomOrder()->first()->id,
        'asistente_id' => DB::table('abogados')->inRandomOrder()->first()->id,
        'service_id' => $servicio->id,
        'numero_dias' => $dias,
        'fecha_inicio' => $faker->date('d/m/Y', '-5 years'),
        'fecha_termino' => $faker->date('d/m/Y', '+5 years'),
        'descripcion' => $faker->text(rand(100,255)),
        'matter_id' => DB::table('matters')->inRandomOrder()->first()->id,
        'area_id' => DB::table('areas')->inRandomOrder()->first()->id,
        'entity_id' => DB::table('entities')->inRandomOrder()->first()->id,
        'state_id' => DB::table('states')->inRandomOrder()->first()->id,
        'observacion' => $faker->text(rand(100,255))
    ];
});

//INTERVINIENTES DE EXPEDIENTE
$factory->define(\Consensus\Entities\ExpedienteInterviniente::class, function ($faker) use ($factory) {
    return [
        'expediente_id' => DB::table('expedientes')->inRandomOrder()->first()->id,
        'nombre' => $faker->name." ".$faker->lastName,
        'dni' => $faker->regexify('[0-9]{8,8}'),
        'email' => $faker->email,
        'telefono' => $faker->phoneNumber,
        'celular' => $faker->phoneNumber,
        'intervener_id' => DB::table('interveners')->inRandomOrder()->first()->id
    ];
});

//TAREAS DE EXPEDIENTE
$factory->define(\Consensus\Entities\Tarea::class, function ($faker) use ($factory) {
   return [
       'expediente_id' => DB::table('expedientes')->inRandomOrder()->first()->id,
       'tarea_concepto_id' => DB::table('tarea_conceptos')->inRandomOrder()->first()->id,
       'descripcion' => $faker->text(rand(100,255)),
       'fecha_solicitada' => $faker->date('d/m/Y', '+5 years'),
       'fecha_vencimiento' => $faker->date('d/m/Y', '+5 years'),
       'abogado_id' => DB::table('abogados')->inRandomOrder()->first()->id,
       'estado' => $faker->randomElement([0,1])
   ];
});

//FLUJO DE CAJA
$factory->define(\Consensus\Entities\FlujoCaja::class, function ($faker) use ($factory) {
    return [
        'expediente_id' => DB::table('expedientes')->inRandomOrder()->first()->id,
        'referencia' => $faker->sentence(6),
        'fecha' => $faker->date(),
        'money_id' => DB::table('money')->inRandomOrder()->first()->id,
        'monto' => $faker->randomFloat(2, 5, 15),
    ];
});