<?php

namespace Consensus\Console\Commands;

use Consensus\Entities\Abogado;
use Consensus\Entities\Cliente;
use Consensus\Entities\Expediente;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar datos de Cliente y Expedientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Excel::load('public/expedientes.csv', function($reader){

            foreach($reader->get() as $item)
            {
                Expediente::create([
                    'id' => $item->id,
                    'expediente' => $item->expediente,
                    'cliente_id' => $item->cliente_id,
                    'tariff_id' => $item->tariff_id,
                    'descripcion' => $item->descripcion,
                    'abogado_id' => $item->abogado_id,
                    'money_id' => $item->money_id,
                    'service_id' => $item->service_id,
                    'concepto' => $item->concepto,
                    'matter_id' => $item->matter_id,
                    'instance_id' => $item->instance_id,
                    'entity_id' => $item->entity_id,
                    'encargado' => $item->encargado,
                    'jefe_area' => $item->jefe_area,
                    'area_id' => $item->area_id,
                    'asistente_id' => $item->asistente_id,
                    'state_id' => $item->state_id,
                    'titulo_expediente' => $item->titulo_expediente,
                    'fecha_inicio' => $item->fecha_inicio,
                    'fecha_termino' => $item->fecha_termino,
                    'bienes_id' => $item->bienes_id,
                    'situacion_especial_id' => $item->situacion_especial_id,
                    'exito_id' => $item->exito_id,
                    'observacion' => $item->observacion,
                    'idticliexp' => $item->idticliexp,
                    'check_poder' => $item->check_poder,
                    'fecha_poder' => $item->fecha_poder,
                    'check_vencimiento' => $item->check_vencimiento,
                    'fecha_vencimiento' => $item->fecha_vencimiento
                ]);
            }

        });

        $this->line('<info>Se importó</info> Expedientes');

        Excel::load('public/clientes.csv', function($reader){

            foreach($reader->get() as $item)
            {
                Cliente::create([
                    'id' => $item->id,
                    'cliente' => $item->cliente,
                    'ruc' => $item->ruc,
                    'email' => $item->email,
                    'telefono' => $item->telefono,
                    'fax' => $item->fax,
                    'dni' => $item->dni,
                    'direccion' => $item->direccion,
                    'pais_id' => $item->pais_id
                ]);
            }

        });

        $this->line('<info>Se importó</info> Clientes');

        Excel::load('public/abogados.csv', function($reader){

            foreach($reader->get() as $item)
            {
                Abogado::create([
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'email' => $item->email
                ]);
            }

        });

        $this->line('<info>Se importó</info> Abogados');
    }
}
