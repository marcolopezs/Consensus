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
        $this->call('AjustesTableSeeder');
        $this->call('DataTableSeeder');
        $this->call('AbogadoTableSeeder');
        $this->call('ClienteTableSeeder');
        $this->call('ClienteContactoTableSeeder');
        $this->call('ClienteDocumentoTableSeeder');
        $this->call('ExpedienteTableSeeder');
        $this->call('IntervinienteTableSeeder');
        $this->call('ProcesosTableSeeder');
        $this->call('CajaTableSeeder');
        $this->call('KardexTableSeeder');
    }
}
