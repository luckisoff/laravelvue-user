<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:view user');
        $this->middleware('permission:create user',['only'=>['create','store']]);
        $this->middleware('permission:edit user',['only'=>['edit','update']]);
        $this->middleware('permission:delete user',['only'=>['destroy']]);
    }

    public function users(){
        $users=User::all();
        foreach($users as $user){
            $user=$user->roles->pluck('name','name')->first();
        }
        return response()->json([
         'users'=>$users,
        ],200);
    }


    public function store(Request $request){

        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);

        $input['name']=$request->name;
        $input['email']=$request->email;
        $input['password']=Hash::make($request->input('password'));

        $user=User::create($input);
        $user->assignRole($request->input('role'));

        return ['username'=>$input['name']];
    }

    public function destroy($ids){
        $all_id = explode(',',$ids);
        foreach ($all_id as $id){

            $user = User::find($id);
            if(Auth::user()->email != $user->email){
                $user->delete();
            }
        }
     }
}
