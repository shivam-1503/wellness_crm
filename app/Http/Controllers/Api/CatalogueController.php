<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;

use DB;

     

class CatalogueController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_category()
    {
        $category = Category::select('id', 'name')->get();        
        if($category){
            return response()->json([
                'success' => true,
                'data'=> $category
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message'=> 'The Category requested does not Exist'
            ], 404);
        }
    }

    public function get_product_details(Request $request, $id)
    {
        $product = Product::select('id', 'name', 'company_id', 'hsn', 'image', 'description', 'unit_price', 'total_sales_price', 'initial_quantity', 'status')
        ->find($id);
        if($id){
            $product->image = $product->image ?? 'Default Name';
            return response()->json([
                'success' => true,
                'data' => $product
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'The product requested does not exist'
            ], 404);
        }
    }


    public function get_products()
    {
        $product = Product::select('id', 'name', 'description', 'unit_price', 'total_sales_price', 'status')->get();
        if($product){
            return response()->json([
                'success' => true,
                'data' => $product
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'There is no Products available'
            ], 404);
        }
    }
   
}