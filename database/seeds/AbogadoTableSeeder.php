<?php

use Illuminate\Database\Seeder;

class AbogadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\Abogado::class, 30)->create();
    }
}
