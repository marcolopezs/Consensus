<?php

use Illuminate\Database\Seeder;

class ClienteContactoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\ClienteContacto::class, 60)->create();
    }
}
