<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
class CompanyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view company');
        $this->middleware('permission:create company',['only'=>['create','store']]);
        $this->middleware('permission:edit company',['only'=>['edit','update']]);
        $this->middleware('permission:delete company',['only'=>['destroy']]);
    }

    public function index()
    {


        $company=Company::with('invoice')->get();
        foreach($company as $cmp){

            if($cmp->type=='Vendor'){
                $first='debit';
                $second='credit';
            }else{
                $first='credit';
                $second='debit';
            }

            $balance[$cmp->id]=array_sum($cmp->invoice->pluck($first)->toArray())-array_sum($cmp->invoice->pluck($second)->toArray());
        }
        return response()->json([
            'companies'=>$company,
            'balance'=>$balance,

        ],200);
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required',
            'type'=>'required'
        ]);

        $company=Company::create($request->toArray());
        $company->save();
    }

    public function save(Request $request){
        $company=Company::find($request->id);
        $company->name=$request->name;
        $company->owner=$request->owner;
        $company->address=$request->address;
        $company->phones=$request->phones;
        $company->type=$request->type;
        $company->save();
    }

    public function destroy($id)
    {
        $company=Company::find($id);
        $company->delete();
    }
}
