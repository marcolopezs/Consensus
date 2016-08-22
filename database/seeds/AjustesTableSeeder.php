<?php

use Illuminate\Database\Seeder;

class AjustesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ajustes')->insert([
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 1,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 2,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 3,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 4,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 5,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 6,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 7,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 8,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 9,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 10,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 11,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 2,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 13,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 14,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
            [
                'model' => \Consensus\Entities\Expediente::class,
                'user_id' => 15,
                'contenido' => '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}'
            ],
        ]);
    }
}
