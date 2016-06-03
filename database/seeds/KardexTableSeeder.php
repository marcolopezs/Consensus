<?php

use Illuminate\Database\Seeder;

class KardexTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\Kardex::class, 30)->create();
    }
}
