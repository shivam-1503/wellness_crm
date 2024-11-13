<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpanseCategory;
use DataTables;
use Auth;


class ExpanseCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware('permission:list-expense-headers|create-expense-header|update-expense-header|delete-expense-header', ['only' => ['index','store']]);
        $this->middleware('permission:create-expense-header', ['only' => ['create','store']]);
        $this->middleware('permission:update-expense-header', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-expense-header', ['only' => ['destroy']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $p_cats = ExpanseCategory::where('status', 1)->WhereNull('p_id')->pluck('name', 'id')->toArray();
        return view('pages.expanse.expanse_categories', compact('p_cats'));
    }


    public function getExpanseCategoriesData()
    {
        $p_cats = ExpanseCategory::where('status', 1)->pluck('name', 'id')->toArray();

        $data = ExpanseCategory::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                })
                ->addColumn('parent', function($row) use ($p_cats){
                    return @$p_cats[$row->p_id];
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                    $btn = '';
                    if(Auth::user()->can('update-expense-header')) {
                       $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';
                    }

                    if(Auth::user()->can('delete-expense-header')) {
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
        $this->validate($request, ['name'=>'required', 'status'=>'required','description'=>'required']); 
        
        ExpanseCategory::updateOrCreate(
                                    ['id' => $request->cat_id],
                                    [
                                        'name' => ucwords($request->name), 
                                        'p_id' => $request->p_id, 
                                        'description' => $request->description, 
                                        'status'=>$request->status,
                                        'company_id'=>Auth::user()->company_id,
                                    ]
                                );        
        if($request->cat_id){
            $msg = "Expanse Category Updated Successfully.";
        }
        else{
            $msg = "Expanse Category Created Successfully.";
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
        $cats = ExpanseCategory::find($id);
        return response()->json($cats);
    }


    public function destroy($id)
    {
        $del = ExpanseCategory::find($id)->delete();
        return response()->json(['success'=>'Expanse Category deleted successfully.']);
    }


    public function getExpenseSubCatsbyCatId($id)
    {
        $cats = ExpanseCategory::where('p_id', $id)->where('status', 1)->pluck('name', 'id')->toArray();
        return response()->json(['success'=>true, 'data'=>$cats]);
    }

}


