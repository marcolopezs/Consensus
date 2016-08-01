<?php namespace Consensus\Console\Commands;

use Carbon\Carbon;
use Consensus\Entities\Tarea;
use Illuminate\Console\Command;

class TareaNotificacionAsignado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tarea:abogado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar notificación a correo de Abogado asignado';

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
        $tareas = Tarea::all();

        foreach($tareas as $tarea)
        {
            $fecha_fin = Carbon::createFromFormat('Y-m-d', formatoFecha($tarea->fecha_vencimiento));
            $fecha_hoy = Carbon::now();
            $dias = $fecha_fin->diffInDays($fecha_hoy);

            if($fecha_hoy <= $fecha_fin){

                //DATOS PARA EMAIL
                $data = [
                    'abogado' => $tarea->abogado->nombre,
                    'email' => $tarea->abogado->email,
                    'dias' => $dias,
                    'tarea' => $tarea->concepto->titulo,
                    'descripcion' => $tarea->descripcion
                ];

                //ENVIAR A
                $deEmail = 'noreply@consensus.com';
                $deNombre = 'Consensus';

                //ENVIAR DE
                $aEmail = $data['email'];
                $aNombre = $data['abogado'];

                \Mail::send('emails.notificacion', $data, function($message) use ($deNombre, $deEmail, $aNombre, $aEmail){
                    $message->to($aEmail, $aNombre);
                    $message->from($deEmail, $deNombre);
                    $message->subject('Consensus - Notificación de Tarea');
                });
                $this->comment("<info>Se envío Notificación a Abogado</info>");
            }else{
                $this->comment("No hay tarea por vencer");
            }

        }
    }
}