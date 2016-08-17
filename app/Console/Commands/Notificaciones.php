<?php namespace Consensus\Console\Commands;

use Consensus\Entities\Expediente;
use Consensus\Entities\Tarea;
use Illuminate\Console\Command;

class Notificaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consensus:notif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creando notificaciones de Expedientes y Tareas';

    /**
     * Create a new command instance.
     *
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
         * CREANDO NOTIFICACIONES DE EXPEDIENTES
         */
        $expedientes = Expediente::all();
        foreach($expedientes as $expediente){
            $expediente->notificaciones()->create([
                'abogado_id' => $expediente->abogado_id,
                'fecha_vencimiento' => $expediente->fecha_vencimiento,
                'descripcion' => 'Quedan {dias} días para la fecha de vencimiento de poder del Expediente '. $expediente->expediente
            ]);
        }

        $this->line('<info>Creación</info> Notificación de Expedientes');

        /*
         * CREANDO NOTIFICACIONES DE TAREAS
         */
        $tareas = Tarea::all();
        foreach($tareas as $tarea){
            $tarea->notificaciones()->create([
                'abogado_id' => $tarea->abogado_id,
                'fecha_vencimiento' => formatoFecha($tarea->fecha_vencimiento),
                'descripcion' => 'Quedan {dias} días para tarea '. $tarea->concepto->titulo .', del Expediente '. $tarea->expedientes->expediente
            ]);
        }

        $this->line('<info>Creación</info> Notificación de Tareas');
    }
}
