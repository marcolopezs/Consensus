<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\User;

class UserRepo extends BaseRepo {

    public function getModel()
    {
        return new User();
    }

    //FILTRO DE USUARIOS
    public function filterUsers(Request $request)
    {
        return $this->getModel()->join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                                ->select('users.*', 'user_profiles.*')
                                ->nombre($request->get('nombre'))
                                ->username($request->get('usuario'))
                                ->tipo($request->get('tipo_usuario'))
                                ->active($request->get('active'))
                                ->orderBy('nombre','asc')
                                ->with('profile')
                                ->paginate();
    }

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()->join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                                ->select('users.*', 'user_profiles.*')
                                ->nombre($request->get('nombre'))
                                ->username($request->get('usuario'))
                                ->tipo($request->get('tipo_usuario'))
                                ->active($request->get('active'))
                                ->orderBy('nombre','asc')
                                ->with('profile')
                                ->get();
    }

}