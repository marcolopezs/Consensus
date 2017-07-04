<?php

namespace Consensus\Console\Commands;

use Consensus\Entities\UserRole;
use Illuminate\Console\Command;

class Prueba extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View User Role';

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
        \DB::table('user_roles')->update(['view' => 1]);

        $this->comment("<info>Se modificó el campo View en User Role</info>");
    }
}
