<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserTableSeeder');
        $this->call('DataTableSeeder');
        $this->call('ClienteTableSeeder');
        $this->call('ClienteContactoTableSeeder');
        $this->call('ClienteDocumentoTableSeeder');
        $this->call('ExpedienteTableSeeder');
        $this->call('KardexTableSeeder');
    }
}
