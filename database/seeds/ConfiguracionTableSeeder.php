<?php

use Illuminate\Database\Seeder;

class ConfiguracionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuraciones')->insert([
            ['id' => '1', 'accion' => 'web_nombre', 'valor' => 'Consensus'],
            ['id' => '2', 'accion' => 'web_logo', 'valor' => 'logo.jpg'],
            ['id' => '3', 'accion' => 'notificacion_dias', 'valor' => '7']
        ]);
    }
}
