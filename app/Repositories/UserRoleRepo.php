<?php namespace Consensus\Repositories;

use Consensus\Entities\UserRole;
use Illuminate\Http\Request;

class UserRoleRepo extends BaseRepo {

    public function getModel()
    {
        return new UserRole();
    }

}