<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use DataTables;
use Auth;


class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories=Category::where('status', '=', 1)->whereNull('p_id')->pluck('name', 'id')->toArray();        
        return view('pages.category.categories', compact('categories'));
    }


    public function getCategoriesData()
    {
        $data = Category::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('p_id', function($row){ 
                    if(!empty($row->p_id)){
                        $name=Category::find($row->p_id);
                    return $name->name;
                    }                        
                }) 
                ->addColumn('status', function($row) {
                    
                    $checked = $row->status == 1 ? 'checked' : '';

                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" '. $checked .' ></div>';
                    
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                       $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';

                       $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

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
        $rules = [
            'name' => 'required',
        ];
        
        $this->validate($request, $rules);
    
        if($request->slug==null){
            $slug =  Str::of($request->name)->slug('-');
        }else{
            $slug =  Str::of($request->slug)->slug('-');
        }

        if(isset($request->p_id) && !is_null($request->p_id)) {
            $cat = Category::find($request->p_id);
            $full_name = ucwords($request->name).' - '.$cat->name;
        }
        else {
            $full_name = ucwords($request->name);
        }
        // dd($request->toArray());

        Category::updateOrCreate(
            ['id' => $request->category_id],
            [
                'p_id' => $request->p_id,
                'name' => ucwords($request->name),
                'full_name' => $full_name,
                'description'=>$request->description,
                'slug'=>$slug,
                'short_code'=>$request->short_code,
                'status'=>$request->status,
            ]
        );        
        if($request->category_id){
        $msg = "Category Updated Successfully.";

        }
        else{
        $msg = "Category Created Successfully.";
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
        $cats = Category::find($id);
        return response()->json($cats);
    }


    public function destroy($id)
    {
        $del = Category::find($id)->delete();
        return response()->json(['success'=>'Category deleted successfully.']);
    }

    public function getCategories(Request $request)
    { 
        
        $items=Category::where('status', '=', 1)->pluck('name', 'id')->toArray();             
        return response()->json(array('success'=>1, 'message'=>'Category Details', 'data'=>$items));
       
    }


}
