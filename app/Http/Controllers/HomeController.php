<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');

    }

    public function roles(){
        $roles=Role::all();
        return response()->json([
         'roles'=>$roles
        ],200);
    }

    public function del_role($id){
        $role = Role::find($id);
        $role->delete();
    }

    public function del_sel_roles($ids){
        $all_id = explode(',',$ids);
        foreach ($all_id as $id){
            $role = Role::find($id);
            $role->delete();
        }
     }
}
