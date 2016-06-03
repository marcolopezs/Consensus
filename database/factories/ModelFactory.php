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
        'descripcion' => $faker->text(rand(100,255)),
        'documento' => $faker->file(public_path('images'), public_path('documento'), false),
        'tipo' => $faker->fileExtension
    ];
});

//EXPEDIENTES
$factory->define(\Consensus\Entities\Expediente::class, function ($faker) use ($factory) {
    return [
        'expediente' => $faker->regexify('[A-Z]{1,1}-[0-9]{10,10}'),
        'cliente_id' => \Consensus\Entities\Cliente::all()->random()->id,
        'money_id' => \Consensus\Entities\Money::all()->random()->id,
        'tariff_id' => \Consensus\Entities\Tariff::all()->random()->id,
        'fecha_inicio' => $faker->date('Y-m-d'),
        'fecha_termino' => $faker->date('Y-m-d'),
        'service_id' => \Consensus\Entities\Service::all()->random()->id,
        'descripcion' => $faker->text(rand(100,255)),
        'observacion' => $faker->text(rand(100,255)),
        'concepto' => $faker->text(rand(100,255)),
        'estado' => $faker->randomElement([0,1])
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