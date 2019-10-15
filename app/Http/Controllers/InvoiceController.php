<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
class InvoiceController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:view invoice');
        $this->middleware('permission:create invoice',['only'=>['create','store']]);
        $this->middleware('permission:edit invoice',['only'=>['edit','update']]);
        $this->middleware('permission:delete invoice',['only'=>['destroy']]);
    }

    public function index($company_id)
    {

        $invoices=Invoice::where('company_id',$company_id)->orderBy('created_at','desc')->paginate(5);

        $totalCredit=array_sum(Invoice::where('company_id',$company_id)->pluck('credit')->toArray());
        $totalDebit=array_sum(Invoice::where('company_id',$company_id)->pluck('debit')->toArray());
        return response()->json([
            'invoices'=>$invoices,
            'totalCredit'=>$totalCredit,
            'totalDebit'=>$totalDebit,
        ]);
    }

    public function search($id,$searchtext){
        $invoices=Invoice::where(function($query) use ($id,$searchtext){
            $query->where('company_id',$id)->where('description','LIKE','%'.$searchtext.'%');
        })->orWhere(function($query) use ($id,$searchtext){
            $query->where('company_id',$id)->where('duedate','LIKE','%'.$searchtext.'%');
        })->orderBy('created_at','DESC')->get();

        return response()->json([
            'invoices'=>$invoices
        ]);
    }

    public function store(Request $request)
    {
        $invoice=new Invoice();

        $this->validate($request,[
            'description'=>'required'
        ]);
        $invoice->description=$request->description;
        $request->credit==null?$invoice->credit=0:$invoice->credit=$request->credit;
        $request->debit==null?$invoice->debit=0:$invoice->debit=$request->debit;
        $invoice->duedate=$request->duedate;
        $invoice->company_id=$request->company_id;

        $invoice->save();
    }
    public function save()
    {

    }
    public function destroy($id)
    {
        $invoice=Invoice::find($id);
        $invoice->delete();

    }
}
