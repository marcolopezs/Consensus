<?php

use Illuminate\Database\Seeder;

class ClienteDocumentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Consensus\Entities\ClienteDocumento::class, 50)->create();
    }
}
