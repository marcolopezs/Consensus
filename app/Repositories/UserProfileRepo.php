<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\UserProfile;

class UserProfileRepo extends BaseRepo {

    public function getModel()
    {
        return new UserProfile();
    }

}