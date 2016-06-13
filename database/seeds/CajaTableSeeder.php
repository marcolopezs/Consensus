<?php

use Illuminate\Database\Seeder;

class CajaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\FlujoCaja::class, 600)->create();
    }
}
