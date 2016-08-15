<?php namespace Consensus\Console\Commands;

use Carbon\Carbon;
use Consensus\Entities\Tarea;
use Illuminate\Console\Command;

class TareaNotificacionAsignadoLista extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tarea:notif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar notificación a correo de Abogados que esten asiganados a una Tarea';

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

            foreach($tarea->notificacion as $notificaion)
            {
                if($dias <= $notificaion->dias){

                    //DATOS PARA EMAIL
                    $data = [
                        'abogado' => $notificaion->abogado->nombre,
                        'email' => $notificaion->abogado->email,
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

            $this->comment("No hay Abogados adicionales a Notificar");
        }
    }
}
