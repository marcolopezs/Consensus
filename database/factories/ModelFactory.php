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
        'cliente' => $faker->unique()->company,
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
        'pais_id' => rand(1,237),
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
        'pais_id' => rand(1,237),
        'estado' => $faker->randomElement([0,1])
    ];
});

//CONTACTOS DE CLIENTE
$factory->define(\Consensus\Entities\ClienteContacto::class, function ($faker) use ($factory) {
    return [
        'cliente_id' => rand(1,60),
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
        'pais_id' => rand(1,237),
        'estado' => $faker->randomElement([0,1])
    ];
});

//DOCUMENTOS DE CLIENTE
$factory->define(\Consensus\Entities\ClienteDocumento::class, function ($faker) use ($factory) {
    return [
        'cliente_id' => rand(1,60),
        'titulo' => $faker->sentence(),
        'descripcion' => $faker->text(rand(100,255))
    ];
});

//EXPEDIENTES
$factory->define(\Consensus\Entities\Expediente::class, function ($faker) use ($factory) {
    return [
        'expediente' => $faker->regexify('[A-Z]{1,1}-[0-9]{10,10}'),
        'cliente_id' => rand(1,30),
        'money_id' => rand(1,3),
        'abogado_id' => rand(1,30),
        'tariff_id' => rand(1,7),
        'valor' => $faker->randomFloat(2, 5, 15),
        'asistente_id' => rand(1,30),
        'service_id' => rand(1,58),
        'numero_dias' => rand(1,31),
        'fecha_inicio' => '10/07/2018',
        'fecha_termino' => '28/08/2018',
        'descripcion' => $faker->text(rand(100,255)),
        'concepto' => $faker->text(rand(100,255)),
        'matter_id' => rand(1,27),
        'entity_id' => rand(1,35),
        'instance_id' => rand(1,10),
        'encargado' => $faker->name,
        'area_id' => rand(1,13),
        'jefe_area' => $faker->name,
        'state_id' => rand(1,25),
        'bienes_id' => rand(1,4),
        'situacion_especial_id' => rand(1,4),
        'exito_id' => rand(1,2),
        'observacion' => $faker->text(rand(100,255))
    ];
});

//INTERVINIENTES DE EXPEDIENTE
$factory->define(\Consensus\Entities\ExpedienteInterviniente::class, function ($faker) use ($factory) {
    return [
        'expediente_id' => rand(1,150),
        'nombre' => $faker->name." ".$faker->lastName,
        'dni' => $faker->regexify('[0-9]{8,8}'),
        'email' => $faker->email,
        'telefono' => $faker->phoneNumber,
        'celular' => $faker->phoneNumber,
        'intervener_id' => rand(1,53)
    ];
});

//TAREAS DE EXPEDIENTE
$factory->define(\Consensus\Entities\Tarea::class, function ($faker) use ($factory) {
   return [
       'expediente_id' => rand(1,150),
       'tarea_concepto_id' => rand(1,15),
       'descripcion' => $faker->text(rand(100,255)),
       'fecha_solicitada' => $faker->date('d/m/Y', '+5 years'),
       'fecha_vencimiento' => $faker->date('d/m/Y', '+5 years'),
       'abogado_id' => rand(1,30),
       'estado' => $faker->randomElement([0,1])
   ];
});

//FLUJO DE CAJA
$factory->define(\Consensus\Entities\FlujoCaja::class, function ($faker) use ($factory) {
    return [
        'expediente_id' => rand(1,150),
        'referencia' => $faker->sentence(),
        'fecha' => $faker->dateTimeBetween('-2 years', 'now'),
        'money_id' => rand(1,3),
        'monto' => $faker->randomFloat(2, 5, 15),
    ];
});