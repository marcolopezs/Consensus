<?php namespace Consensus\Providers;

use Consensus\Entities\Expediente;
use Consensus\Entities\User;
use Consensus\Policies\ExpedientePolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Expediente::class => ExpedientePolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('mostrar-menu', 'Consensus\Policies\SystemPolicy@menu');

        $gate->define('admin', 'Consensus\Policies\SystemPolicy@admin');

        $gate->define('abogado', 'Consensus\Policies\SystemPolicy@abogado');

        $gate->define('cliente', 'Consensus\Policies\SystemPolicy@cliente');

        $gate->define('create', 'Consensus\Policies\SystemPolicy@create');

        $gate->define('update', 'Consensus\Policies\SystemPolicy@update');

        $gate->define('delete', 'Consensus\Policies\SystemPolicy@delete');

        $gate->define('printer', 'Consensus\Policies\SystemPolicy@printer');

        $gate->define('exportar', 'Consensus\Policies\SystemPolicy@exportar');
    }
}
