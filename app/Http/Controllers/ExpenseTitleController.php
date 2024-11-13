<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseTitle;
use DataTables;
use Auth;


class ExpenseTitleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:list-expense-titles|create-expense-title|update-expense-title|delete-expense-title', ['only' => ['index','store']]);
        $this->middleware('permission:create-expense-title', ['only' => ['create','store']]);
        $this->middleware('permission:update-expense-title', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-expense-title', ['only' => ['destroy']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.expanse.expense_titles');
    }


    public function getExpenseTitlesData()
    {
        $data = ExpenseTitle::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                }) 
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                    $btn = '';

                    if(Auth::user()->can('update-expense-title')) {
                       $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';
                    }

                    if(Auth::user()->can('delete-expense-title')) {
                       $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';
                    }
                        return $btn;
                })
                ->rawColumns(['country','status', 'action'])
                ->make(true);
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title'=>'required', 'type'=>'required', 'status'=>'required']); 
        
        ExpenseTitle::updateOrCreate(
                                    ['id' => $request->cat_id],
                                    [
                                        'type' => $request->type, 
                                        'title' => ucwords($request->title), 
                                        'status'=>$request->status,
                                    ]
                                );        
        if($request->cat_id){
            $msg = "Expense Title Updated Successfully.";
        }
        else{
            $msg = "Expense Title Created Successfully.";
        }
        return response()->json(['msg'=>$msg]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cats = ExpenseTitle::find($id);
        return response()->json($cats);
    }


    public function destroy($id)
    {
        $del = ExpenseTitle::find($id)->delete();
        return response()->json(['success'=>'Expense Title deleted successfully.']);
    }



}
