<?php

use Illuminate\Database\Seeder;

class ExpedienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\Expediente::class, 30)->create();
    }
}
