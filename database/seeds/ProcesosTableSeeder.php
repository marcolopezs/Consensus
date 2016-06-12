<?php

use Illuminate\Database\Seeder;

class ProcesosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\Tarea::class, 600)->create();
    }
}
