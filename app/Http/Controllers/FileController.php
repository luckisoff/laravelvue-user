<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
class FileController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:view file');
        $this->middleware('permission:create file',['only'=>['create','store']]);
        $this->middleware('permission:edit file',['only'=>['edit','update']]);
        $this->middleware('permission:delete file',['only'=>['destroy']]);
    }

    public function store(Request $request)
    {
        $file=new File();
        $this->validate($request,[
            'name'=>'required',
        ]);

        $file->name=$request->name;
        if($request->file){
            $fileName = time().'.'.$request->file->getClientOriginalExtension();
            $type=$request->file->getClientOriginalExtension();
        }else{
            return null;
        }


        $file->path='/media/'.$fileName;
        $file->url=env('APP_URL').'/storage/media/'.$fileName;
        $file->type=$type;
        if($request->file->move(storage_path('/app/public/').'/media', $fileName)){
            $file->save();
        }

        event(new \App\Events\FileAdded());


    }

    public function index(){
        $files=File::orderBy('created_at','desc')->get();
        return response()->json([
            'files'=>$files
        ]);
    }

    public function destroy($id){
        $file=File::find($id);
        if(!empty($file->path)){
            unlink(storage_path('/app/public/').$file->path);
        }
        $file->delete();
    }
}
