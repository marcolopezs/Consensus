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
        ]);
    }
}
