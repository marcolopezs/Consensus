<?php namespace Consensus\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ExpedientePolicy extends SystemPolicy
{
    use HandlesAuthorization;

    public function clienteExpedientes($user, $expediente)
    {
        return $user->cliente_id === $expediente->cliente_id || $user->isAbogado() || $user->isAsistente();
    }

}
