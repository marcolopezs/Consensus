<?php namespace Consensus\Repositories;

use Auth;
use Illuminate\Http\Request;

use Consensus\Entities\History;

class HistoryRepo extends BaseRepo {

    public function getModel()
    {
        return new History;
    }

}