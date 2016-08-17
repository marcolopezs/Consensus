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

        DB::table('comprobante_tipos')->insert([
            ['id' => '1', 'titulo' => 'Factura', 'estado' => '1'],
            ['id' => '2', 'titulo' => 'Boleta', 'estado' => '1'],
            ['id' => '3', 'titulo' => 'Recibo por Honorarios', 'estado' => '1']
        ]);
    }
}
