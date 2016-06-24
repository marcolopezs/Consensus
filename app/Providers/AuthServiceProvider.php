<?php

namespace Consensus\Providers;

use Consensus\Entities\User;
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
        'Consensus\Model' => 'Consensus\Policies\ModelPolicy',
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

        $gate->before(function (User $user){
            if($user->isAdmin()){
                return true;
            }
        });

        $gate->define('mostrar-menu', function(User $user){
            return $user->isAbogado();
        });

    }
}
