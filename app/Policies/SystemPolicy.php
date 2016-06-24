<?php namespace Consensus\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class SystemPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if($user->isAdmin())
        {
            return true;
        }
    }

    public function menu($user){
        return $user->isAdmin() || $user->isAbogado();
    }

    public function cliente($user)
    {
        return $user->isCliente();
    }

    public function create($user)
    {
        return $user->yesCreate();
    }

    public function update($user)
    {
        return $user->yesUpdate();
    }

    public function delete($user)
    {
        return $user->yesDelete();
    }

    public function printer($user)
    {
        return $user->yesPrint();
    }



}
