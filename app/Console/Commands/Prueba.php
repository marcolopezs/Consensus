<?php

namespace Consensus\Console\Commands;

use Illuminate\Console\Command;

class Prueba extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prueba';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba de correo';

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
        //DATOS PARA EMAIL
        $data = [
            'abogado' => 'Desarrollo',
            'email' => 'mlopez18073@gmail.com',
            'dias' => 7,
            'tarea' => 'Prueba de Correo',
            'descripcion' => 'Rhoncus ultricies quis. Nisi magna phasellus adipiscing et rhoncus, magnis egestas vut ridiculus nunc sociis, cursus! Aenean amet, aliquet tincidunt sit eu eros porta, facilisis lorem'
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
            $message->subject('Consensus - Prueba de correo');
        });
        $this->comment("<info>Se envío Notificación a Abogado</info>");
    }
}
