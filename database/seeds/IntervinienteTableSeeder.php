<?php

use Illuminate\Database\Seeder;

class IntervinienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\ExpedienteInterviniente::class, 600)->create();
    }
}
