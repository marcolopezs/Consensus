<?php

namespace Consensus\Console\Commands;

use Consensus\Entities\Abogado;
use Consensus\Entities\Cliente;
use Consensus\Entities\Expediente;
use Consensus\Entities\Tarea;
use Consensus\Entities\TarifaAbogado;
use Consensus\Entities\Tariff;
use Consensus\Entities\User;
use Consensus\Entities\UserProfile;
use Consensus\Entities\UserRole;
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
        /*
         * IMPORTAR EXPEDIENTES
         */
        Excel::load('public/expedientes.csv', function($reader){

            foreach($reader->get() as $item)
            {
                Expediente::create([
                    'id' => $item->id,
                    'expediente_tipo_id' => $item->expediente_tipo_id,
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

        /*
         * IMPORTAR CLIENTES
         */
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
                    'pais_id' => $item->pais_id,
                    'estado' => $item->estado
                ]);
            }

        });

        $this->line('<info>Se importó</info> Clientes');

        /*
         * IMPORTAR ABOGADOS
         */
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

        $this->line('----------------------------------------');
        $this->line('----------------------------------------');

        /*
         * IMPORTAR USUARIOS
         */
        Excel::load('public/usuarios.csv', function($reader){

            foreach($reader->get() as $item)
            {
                User::create([
                    'id' => $item->id,
                    'username' => $item->username,
                    'password' => $item->password,
                    'active' => $item->active,
                    'admin' => $item->admin,
                    'abogado_id' => $item->abogado_id
                ]);
            }

        });

        $this->line('<info>Se importó</info> Usuarios');

        /*
         * IMPORTAR PERFIL  DE USUARIOS
         */
        Excel::load('public/usuarios.csv', function($reader){

            foreach($reader->get() as $item)
            {
               UserProfile::create([
                    'user_id' => $item->user_id,
                    'nombre' => $item->nombre,
                    'apellidos' => $item->apellidos,
                    'email' => $item->email
                ]);
            }

        });

        $this->line('<info>Se importó</info> Perfil de Usuarios');

        /*
         * IMPORTAR ROLES DE USUARIOS
         */
        Excel::load('public/usuarios.csv', function($reader){

            foreach($reader->get() as $item)
            {
                UserRole::create([
                    'user_id' => $item->user_id,
                    'create' => $item->create,
                    'update' => $item->update,
                    'delete' => $item->delete,
                    'exporta' => $item->exporta,
                    'printer' => $item->printer
                ]);
            }

        });

        $this->line('<info>Se importó</info> Roles de Usuario');

        $this->line('----------------------------------------');
        $this->line('----------------------------------------');

        /*
         * IMPORTAR TAREAS
         */
        Excel::load('public/tareas.csv', function($reader){

            foreach($reader->get() as $item)
            {
                $expediente = Expediente::where('expediente', $item->expediente)->first();

                Tarea::create([
                    'id' => $item->id,
                    'expediente_id' => $expediente->id,
                    'expediente_tipo_id' => $expediente->expediente_tipo_id,
                    'fecha_solicitada' => $item->fecha_solicitada,
                    'fecha_vencimiento' => $item->fecha_vencimiento,
                    'tarea_concepto_id' => $item->tarea_concepto_id,
                    'titular_id' => $item->titular_id,
                    'abogado_id' => $item->abogado_id,
                    'descripcion' => $item->descripcion,
                    'estado' => $item->estado
                ]);
            }

        });

        $this->line('<info>Se importó</info> Tareas de Expedientes');


        $this->line('----------------------------------------');
        $this->line('----------------------------------------');

        /*
         * TARIFAS DE ABOGADOS
         */
        $abogados = Abogado::all();
        $tarifas = Tariff::all();

        foreach($abogados as $abogado){
            foreach($tarifas as $tarifa){
                $tarAbogado = new TarifaAbogado();
                $tarAbogado->tariff_id = $tarifa->id;
                $tarAbogado->abogado_id = $abogado->id;
                $tarAbogado->estado = $tarifa->estado;
                $tarAbogado->save();
            }
        }

        $this->line('<info>Creación</info> Tarifas de Abogados');
    }
}
