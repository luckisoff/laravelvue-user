<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view role');
        $this->middleware('permission:create role',['only'=>['create','store']]);
        $this->middleware('permission:edit role',['only'=>['edit','update']]);
        $this->middleware('permission:delete role',['only'=>['destroy']]);
    }

    public function getPermission(){
        $permission=Permission::get();
        return response()->json([
            'permissions'=>$permission
           ],200);
    }

    public function store(Request $request){

        $this->validate($request,[
            'name'=>'required|unique:roles,name'
        ]);
        $role=Role::create(['name'=>$request->input('name')]);
        if(!empty($request->permissionItem)){
            $role->syncPermissions($request->permissionItem);

        }
        return ['message'=>'ok'];
    }
}
