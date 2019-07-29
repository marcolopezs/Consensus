<?php

use Illuminate\Database\Seeder;

class TareasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\Tarea::class, 100)->create();


        factory(\Consensus\Entities\TareaAccion::class, 300)->create();
    }
}
