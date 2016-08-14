<?php namespace Consensus\Console\Commands;

use Carbon\Carbon;
use Consensus\Entities\Tarea;
use Illuminate\Console\Command;
use Consensus\Repositories\ConfiguracionRepo;

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

    protected $configuracionRepo;

    /**
     * Create a new command instance.
     * @param ConfiguracionRepo $configuracionRepo
     */
    public function __construct(ConfiguracionRepo $configuracionRepo)
    {
        parent::__construct();
        $this->configuracionRepo = $configuracionRepo;
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
            $conf = $this->configuracionRepo->where('accion','notificacion_dias')->first();

            if($dias <= $conf->valor){

                //DATOS PARA EMAIL
                $data = [
                    'abogado' => $tarea->abogado->nombre,
                    'email' => $tarea->abogado->email,
                    'dias' => $conf->valor,
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