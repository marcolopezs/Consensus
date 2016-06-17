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
        'pais_id' => \Consensus\Entities\Pais::all()->random()->id,
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
        'pais_id' => \Consensus\Entities\Pais::all()->random()->id,
        'estado' => $faker->randomElement([0,1])
    ];
});

//CONTACTOS DE CLIENTE
$factory->define(\Consensus\Entities\ClienteContacto::class, function ($faker) use ($factory) {
    return [
        'cliente_id' => \Consensus\Entities\Cliente::all()->random()->id,
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
        'pais_id' => \Consensus\Entities\Pais::all()->random()->id,
        'estado' => $faker->randomElement([0,1])
    ];
});

//DOCUMENTOS DE CLIENTE
$factory->define(\Consensus\Entities\ClienteDocumento::class, function ($faker) use ($factory) {
    return [
        'cliente_id' => \Consensus\Entities\Cliente::all()->random()->id,
        'titulo' => $faker->sentence(),
        'descripcion' => $faker->text(rand(100,255))
    ];
});

//EXPEDIENTES
$factory->define(\Consensus\Entities\Expediente::class, function ($faker) use ($factory) {
    $servicio = \Consensus\Entities\Service::all()->random();
    $dias = $servicio->dias_ejecucion;
    return [
        'expediente' => $faker->regexify('[A-Z]{1,1}-[0-9]{10,10}'),
        'cliente_id' => \Consensus\Entities\Cliente::all()->random()->id,
        'money_id' => \Consensus\Entities\Money::all()->random()->id,
        'abogado_id' => \Consensus\Entities\Abogado::all()->random()->id,
        'tariff_id' => \Consensus\Entities\Tariff::all()->random()->id,
        'valor' => $faker->randomFloat(2, 5, 15),
        'asistente_id' => \Consensus\Entities\Abogado::all()->random()->id,
        'service_id' => $servicio->id,
        'numero_dias' => $dias,
        'fecha_inicio' => $faker->dateTimeBetween('-2 years', 'now'),
        'fecha_termino' => $faker->dateTimeBetween('now', '+2 years'),
        'descripcion' => $faker->text(rand(100,255)),
        'concepto' => $faker->text(rand(100,255)),
        'matter_id' => \Consensus\Entities\Matter::all()->random()->id,
        'entity_id' => \Consensus\Entities\Entity::all()->random()->id,
        'instance_id' => \Consensus\Entities\Instance::all()->random()->id,
        'encargado' => $faker->name,
        'area_id' => \Consensus\Entities\Area::all()->random()->id,
        'jefe_area' => $faker->name,
        'state_id' => \Consensus\Entities\State::all()->random()->id,
        'bienes_id' => \Consensus\Entities\Bienes::all()->random()->id,
        'situacion_especial_id' => \Consensus\Entities\SituacionEspecial::all()->random()->id,
        'exito_id' => \Consensus\Entities\Exito::all()->random()->id,
        'observacion' => $faker->text(rand(100,255))
    ];
});

//INTERVINIENTES DE EXPEDIENTE
$factory->define(\Consensus\Entities\ExpedienteInterviniente::class, function ($faker) use ($factory) {
    return [
        'expediente_id' => \Consensus\Entities\Expediente::all()->random()->id,
        'nombre' => $faker->name." ".$faker->lastName,
        'dni' => $faker->regexify('[0-9]{8,8}'),
        'email' => $faker->email,
        'telefono' => $faker->phoneNumber,
        'celular' => $faker->phoneNumber,
        'intervener_id' => \Consensus\Entities\Intervener::all()->random()->id
    ];
});

//TAREAS DE EXPEDIENTE
$factory->define(\Consensus\Entities\Tarea::class, function ($faker) use ($factory) {
   return [
       'expediente_id' => \Consensus\Entities\Expediente::all()->random()->id,
       'tarea' => $faker->sentence(),
       'descripcion' => $faker->text(rand(100,255)),
       'fecha_solicitada' => $faker->date('d/m/Y', '+5 years'),
       'fecha_vencimiento' => $faker->date('d/m/Y', '+5 years'),
       'abogado_id' => \Consensus\Entities\Abogado::all()->random()->id,
       'estado' => $faker->randomElement([0,1])
   ];
});

//FLUJO DE CAJA
$factory->define(\Consensus\Entities\FlujoCaja::class, function ($faker) use ($factory) {
    return [
        'expediente_id' => \Consensus\Entities\Expediente::all()->random()->id,
        'referencia' => $faker->sentence(),
        'fecha' => $faker->dateTimeBetween('-2 years', 'now'),
        'money_id' => \Consensus\Entities\Money::all()->random()->id,
        'monto' => $faker->randomFloat(2, 5, 15),
    ];
});

//KARDEX
$factory->define(\Consensus\Entities\Kardex::class, function ($faker) use ($factory) {
    $cliente = \Consensus\Entities\Cliente::all()->random();
    $expediente = $cliente->expedientes->random()->id;
    return [
        'titulo' => $faker->sentence(),
        'cliente_id' => $cliente->id,
        'expediente_id' => $expediente,
        'matter_id' => \Consensus\Entities\Matter::all()->random()->id,
        'entity_id' => \Consensus\Entities\Entity::all()->random()->id,
        'instance_id' => \Consensus\Entities\Instance::all()->random()->id,
        'encargado' => $faker->name,
        'area_id' => \Consensus\Entities\Area::all()->random()->id,
        'jefe_area' => $faker->name,
        'state_id' => \Consensus\Entities\State::all()->random()->id,
        'estado' => $faker->randomElement([0,1])
    ];
});