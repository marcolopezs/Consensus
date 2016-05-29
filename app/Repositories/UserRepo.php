<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\User;

class UserRepo extends BaseRepo {

    public function getModel()
    {
        return new User();
    }

}