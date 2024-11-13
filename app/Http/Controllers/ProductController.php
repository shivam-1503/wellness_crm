<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Tax;
use App\Models\SeoMetaDetail;
use App\Models\RelatedProduct;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;


use Auth;
use DataTables;
use DB;
use File;


//use App\Http\Traits\ProductHelper;

class ProductController extends Controller
{
    //use ProductHelper;

    public function __construct()
    {
        $this->middleware('auth');
    }



    public $imagesPath = '';
    public $thumbnailPath = '';

    private function getAllProductCatNames()
    {
        $products = Product::Join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.status', 1)
            ->select('products.id', DB::raw("CONCAT(products.name, ' - ', categories.name) as product_cat_name"))->pluck('product_cat_name', 'id')->toArray();
        return $products;
    }





    

    private function getRelatedProductsIDs($id)
    {
        $products = RelatedProduct::where('product_id', $id)->select(DB::raw('GROUP_CONCAT(related_id) AS ids'))->first();

        return $products->ids;
    }


    public function index(Request $request)
    {
        $categories = Category::where('status', '=', 1)->whereNull('p_id')->pluck('name', 'id');

        return view('products.products_list', compact('categories'));
    }

    public function getProductsData()
    {
        $categories = Product::with('category')->where('status', '=', 1)->get();

        return Datatables::of($categories)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                // $name = $row->status . ".png";
                // $icon = '<img src="' . asset("images") . "/" . $name . '">';
                // return $icon;

                $checked = $row->status == 1 ? 'checked' : '';
                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" '. $checked .' ></div>';
              
            })
            
            ->editColumn('updated_at', function ($row) {
                return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();
            })
            ->editColumn('category', function ($row) {
                return $row->category ? $row->category->name : '';
            })
            ->addColumn('action', function ($row) {
                $btn = '<abbr title="Edit"><a href="' . url('/product/edit/' . $row->id) . '" data-toggle="tooltip"  data-original-title="Edit Product" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a></abbr>';

                $btn = $btn . ' <abbr title="Images"><a href="' . url('/product/images/' . $row->id) . '" data-toggle="tooltip" data-original-title="Product Images" class="btn btn-success btn-sm productImages"><i class="fa fa-image"></i></a></abbr>';

                $btn = $btn . ' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $products = $this->getAllProductCatNames();
        return view('products.product_create', compact('categories', 'products'));
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
            'category' => 'required',
            'short_description' => 'required',
            'tax' => 'required',
            'hsn_code' => 'required',
        ];

        $this->validate($request, $rules);

        $slug = Str::of($request->name)->slug('-');
        $is_slug_exist = Product::where('slug', '=', $slug)->count();

        if ($is_slug_exist > 0) {
            $slug = Str::of($request->name)->slug('-') . '-' . mt_rand(1, 1000);
        }

        
        $cat_data = Category::find($request->category);
        if(!isset($request->sku)) { 
            $sku = $cat_data->short_code.sprintf('%03d', ($cat_data->product_counter + 1));
        }
        else {
            $sku = $cat_data->short_code.sprintf('%03d', ($cat_data->product_counter + 1));
        }
        

        DB::beginTransaction();

        try {
            $object = Product::create([
                'name' => $request->name,
                'slug' => $slug,
                'sku' => $sku,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'attribute' => $request->attribute,
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
                'tax' => $request->tax,
                'hsn_code' => $request->hsn_code,
                'status' => $request->status,
            ]);

            if ($object) {

                if(is_array($request->related_products) && count($request->related_products) > 0) {
                    foreach ($request->related_products as $key => $value) {
                        $obj = RelatedProduct::create([
                            'product_id' => $object->id,
                            'related_id' => $value,
                            'status' => 1,
                        ]);
                    }
                }   


                if(is_array($request->attribute) && count($request->attribute) > 0) {
                    foreach ($request->attribute as $key => $value) {
                        $obj = ProductAttribute::create([
                            'product_id' => $object->id,
                            'attribute_id' => $value,
                            'status' => 1,
                        ]);
                    }
                }

                $cat_data->product_counter = $cat_data->product_counter+1;
                $cat_data->save(); 

                DB::commit();
                return response()->json(['success' => 1, 'msg' => 'Product created successfully']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['success' => 0, 'msg' => $e]);
        }

        
    }

    public function images(Request $request, $product_id)
    {
        $items = ProductImages::where('product_id', $product_id)->orderBy('display_order', 'ASC')->get();
        $product = Product::where('id', $product_id)->select('name', 'id')->first();
        return view('products.product_images', compact('product_id', 'items', 'product'));
    }

    public function createDirecrotory()
    {
        $paths = [
            'image_path' => public_path('uploads/products/'),
            'thumbnail_path' => public_path('uploads/products/thumbs/'),
        ];
        foreach ($paths as $key => $path) {
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        }
        $this->imagesPath = $paths['image_path'];
        $this->thumbnailPath = $paths['thumbnail_path'];
    }

    public function store_images(Request $request, $id)
    {
        $product_id = $id;
        $user_id = Auth::user()->id;

        // $request->validate([
        //     'product_images' => 'required|max:2048',
        // ]);

        $request->validate([
            'product_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20096',
        ]);

        if ($request->hasfile('product_images')) {

            $this->createDirecrotory();

            foreach ($request->file('product_images') as $file) {

                $image = Image::make($file);

                $imageName = time() . '-' . $file->getClientOriginalName();
                $image->save($this->imagesPath . $imageName);

                // resize and save thumbnail
                $image->resize(150, 150);
                $image->save($this->thumbnailPath . $imageName);

                $img = new ProductImages();
                $img->product_id = $product_id;
                $img->image = $imageName;
                $img->save();


                // Update thumb image in product table
                $product = Product::find($product_id);

                if(is_null($product->thumb_image)) {
                    $product->thumb_image = $imageName;
                    $product->save();
                }
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Uploaded successfully',
        ]);

    }

    public function delete_images(Request $request)
    {

        $productImage = ProductImages::find($request->key);
        $image_path = public_path("/uploads/products/" . $productImage->image);
        $thumbs_image_path = public_path("/uploads/products/thumbs/" . $productImage->image);

        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        if (File::exists($thumbs_image_path)) {
            File::delete($thumbs_image_path);
        }
        $productImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->pimg = true) {

            $items = ProductImages::where('product_id', '=', $id)->orderBy('display_order', 'ASC')->get();

            // $items=Products::find($id)->product_images();
            return response()->json(array('success' => 1, 'message' => 'Product Images Details', 'data' => $items));

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('status', '=', 1)->pluck('name', 'id')->toArray();
        $product = Product::find($id);
        $product->related_products = $this->getRelatedProductsIDs($id);
        $products = $this->getAllProductCatNames();
        return view('products.product_edit', compact('product', 'products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'product_id' => 'required',
            'name' => 'required',
            'category' => 'required',
            'short_description' => 'required',
        ];

        $this->validate($request, $rules);


        $slug = Str::of($request->name)->slug('-');


        // Cat data
        $cat_data = Category::find($request->category);


        DB::beginTransaction();

        try {
            $product = [
                'name' => $request->name,
                'slug' => $slug,
                // 'sku' => $request->sku,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
                'attribute' => $request->attribute?implode(',', $request->attribute):NULL,
                'tax' => $request->tax,
                'hsn_code' => $request->hsn_code,
                'status' => $request->status,
            ];


            $object = Product::where('id', '=', $request->product_id)->update($product);

            if ($object) {


                
                // Delete old attributes which are not in current selecttion
                if(is_array($request->attribute) && count($request->attribute) > 0) {
                    $delete_existed = ProductAttribute::where('product_id', $request->product_id)->whereNotIn('attribute_id', $request->attribute)->delete();

                    foreach ($request->attribute as $key => $value) {

                        $find_obj = ProductAttribute::where('product_id', $request->product_id)->where('attribute_id', $value)->count();

                        if ($find_obj == 0) {
                            $obj = ProductAttribute::create([
                                'product_id' => $request->product_id,
                                'attribute_id' => $value,
                                'status' => 1,
                            ]);
                        }
                    }
                }
                else {
                    $delete_existed = ProductAttribute::where('product_id', $request->product_id)->delete();
                }  
            }
            DB::commit();
            return response()->json(['success' => 1, 'msg' => 'Product Updated successfully']);
        } 
        catch (\Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['success' => 0, 'msg' => $e]);
        }        
    }


    public function status($id, $status)
    {
        $is_updated = Products::where('id', '=', $id)->update(['status' => $status]);

        if ($is_updated) {
            return array('success' => 1, 'message' => 'Status Updated successfully');
        } else {
            return array('success' => 0, 'message' => 'Please try again after some time');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Product::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seo_data($id)
    {
        $product_id = $id;
        $product = Product::find($product_id);
        $seo_data = SeoMetaDetail::where('product_id', $product_id)->where('status', 1)->get()->first();
        return view('products.product_seo', compact('seo_data', 'product'));
    }



    public function update_seo_data(Request $request)
    {
        $rules = [
            'product_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ];

        $this->validate($request, $rules);

        $product_id = $request->product_id;


        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'alias' => $request->alias,
        ];

        $check_exists = SeoMetaDetail::where('product_id', $product_id)->where('status', 1)->get()->first();

        if($check_exists) {
            SeoMetaDetail::where('id', $check_exists->id)->update($data);
        }
        else {
            $data['product_id'] = $request->product_id;
            $data['status'] = 1;
            $data['url'] = 'product/'.$product_id;

            SeoMetaDetail::create($data);
        }


        if(isset($request->alias) && $request->alias != '') {
            $slug = Str::of($request->alias)->slug('-');
            $is_slug_exist = Product::where('slug', '=', $slug)->count();

            if ($is_slug_exist > 0) {
                $slug = Str::of($request->alias)->slug('-') . '-' . mt_rand(1, 1000);
            }

            $update = Product::where('id', $request->product_id)->update(['slug'=>$slug]);

        }
        

        return response()->json(['success' => 1, 'msg' => 'Details Updated Successfully']);
    }



    public function variants(Request $request, $id)
    {
        // $attributes = explode(',', Product::find($id)->attribute);

        $attributes = ProductAttribute::where('product_id', $id)->pluck('attribute_id', 'id')->toArray();

        // dd($attributes);

        
        $data = [];

        foreach($attributes as $key => $obj) {
            $a = Attribute::find($obj);
            $options = AttributeValue::where('attribute_id', $obj)->pluck('value', 'id')->toArray();
            $array = ['id' => $a->id, 'name'=>$a->name, 'data'=>$options];
            $data[$obj] = $array;
        }


        $product = Product::find($id);


        $skus = Sku::where('product_id', $id)->select('id', 'sku', 'details', 'is_default', 'show_amount', 'unit_amount', 'quantity', 'status')->get();

        //dd($skus);
        return view('products.product_variants', compact('data', 'product', 'attributes', 'skus'));
    }


    private function check_sku_exists($product_id, $details) {
        return Sku::where('product_id', $product_id)->where('details', $details)->get()->count();
        
    }



    public function store_variant_details(Request $request) {
       
        $attributes = ProductAttribute::where('product_id', $request->product_id)->pluck('attribute_id', 'id')->toArray();

 

        // dd($request->toArray());

        $vals = array_values($attributes);
        $keys = array_keys($attributes);

        if(count($attributes) == 0) { 
            $sku_obj = new Sku();
            $sku_obj->product_id = $request->product_id;
            $sku_obj->sku = $request->name;
            $sku_obj->details = "NA";
            $sku_obj->save();
        }

        elseif(count($attributes) == 1) {


            $sel_attribute = $vals[0];

            foreach ($request[$sel_attribute] as $sel_attribute_value) {
                
                $val1 = AttributeValue::find($sel_attribute_value)->value;

                if($this->check_sku_exists($request->product_id, $val1) == 0 ) {
                    $sku_obj = new Sku();
                    $sku_obj->product_id = $request->product_id;
                    $sku_obj->sku = $request->name.'-'.$val1;
                    $sku_obj->details = $val1;
                    $sku_obj->status = 1;
                    $sku_obj->save();


                    $attribute_sku = new AttributeSkuPivot();
                    $attribute_sku->sku_id = $sku_obj->id;
                    $attribute_sku->product_attribute_id = $keys[0];
                    $attribute_sku->value = $val1;
                    $attribute_sku->status = 1;
                    $attribute_sku->save();
                }
            }

        }

        else {

            foreach($request[$vals[0]] as $attr1) {
            
                foreach($request[$vals[1]] as $attr2) {
    
                    // Add into SKU Table
    
                    $val1 = AttributeValue::find($attr1)->value;
                    $val2 = AttributeValue::find($attr2)->value;
    
    
                    $sku_obj = new Sku();
                    $sku_obj->product_id = $request->product_id;
                    $sku_obj->sku = $request->name.'-'.$val1.'-'.$val2;
                    $sku_obj->details = $val1.' - '.$val2;
                    $sku_obj->save();
    
    
                    $attribute_sku = new AttributeSkuPivot();
                    $attribute_sku->sku_id = $sku_obj->id;
                    $attribute_sku->product_attribute_id = $keys[0];
                    $attribute_sku->value = $val1;
                    $attribute_sku->save();
    
    
                    $attribute_sku = new AttributeSkuPivot();
                    $attribute_sku->sku_id = $sku_obj->id;
                    $attribute_sku->product_attribute_id = $keys[1];
                    $attribute_sku->value = $val2;
                    $attribute_sku->save();
    
                }
            }

        }
       
        return response()->json(['success' => 1, 'msg' => 'Variants Created Successfully']);
                
    }





    public function set_variant_cost(Request $request) {

        $rules = [
            'id' => 'required',
            'c' => 'required',
            's' => 'required',
        ];

        $this->validate($request, $rules);

        if(!is_null($request->s) && $request->s != 0) {
            $d = (($request->s - $request->c) / $request->s) * 100;
        }
        
        $sku = Sku::find($request->id);
        // dd($sku->toArray());
        $sku->unit_amount = $request->c;
        $sku->show_amount = $request->s;
        $sku->discount = number_format((float)$d, 2, '.', '');  ;
        $sku->save();


        $product = Product::find($sku->product_id);

        
        if($product->start_price > $request->c) {
            $product->start_price = $request->c;
        }

        if(is_null($product->start_price)) {
            $product->start_price = $request->c;
        }

        if($product->end_price < $request->c) {
            $product->end_price = $request->c;
        }

        $product->save();



        return response()->json(['success' => 1, 'msg' => 'Variants Cost Saved Successfullly']);

    }



    public function set_default_variant($id)
    {
        $current_sku = Sku::find($id);
        
        // find all the sku related to that product
        $skus = Sku::where('product_id', $current_sku->product_id)->get();

        foreach($skus as $obj) {
            // update sku default
            Sku::where('id', $obj->id)->update(['is_default' => 0]);

            // update attribute_sku_pivot table default
            AttributeSkuPivot::where('sku_id', $obj->id)->update(['is_default' => 0]);
        }

        // Set default in sku table now
        $sku = Sku::find($id);
        $sku->is_default = 1;
        $sku->save();


        // Set default in attribute_sku_pivot_table
        AttributeSkuPivot::where('sku_id', $sku->id)->update(['is_default' => 1]);

        return response()->json(['success' => 1, 'msg' => 'Variants Default Configured Successfullly']);
    }


    public function deactivate_variant($id)
    {

        // Set default in sku table now
        $sku = Sku::find($id);
        $sku->status = 0;
        $sku->save();


        // Set default in attribute_sku_pivot_table
        AttributeSkuPivot::where('sku_id', $sku->id)->update(['status' => 0]);

        return response()->json(['success' => 1, 'msg' => 'Variants Deactivated Successfullly']);
    }


    

    public function product_images(Request $request, $id)
    {
        $product_id = $id;
        $images = ProductImages::where('product_id', $product_id)->select('id', 'image','option_id', 'is_thumb', 'updated_at')->get();
        // $skus = Sku::where('product_id', $product_id)->pluck('sku', 'id')->toArray();

        $options = ProductOption::leftJoin('attribute_values', 'product_options.attribute_value_id', '=', 'attribute_values.id')->where('product_id', $product_id)->select('product_options.id', 'attribute_values.value')->pluck('value', 'id')->toArray();

        return view('products.product_images_list', compact('images', 'options'));
    }



    public function set_thumb_image(Request $request, $id)
    {
        $image_id = $id;
        $image = ProductImages::find($image_id);

        $update = ProductImages::where('product_id', $image->product_id)->update(['is_thumb'=>0]);

        $image->is_thumb = 1;
        $image->save();

        $product = Product::find($image->product_id);
        $product->thumb_image = $image->image;
        if($product->save()) {
            return response()->json(['success' => 1, 'msg' => 'Thumb Image Configured Successfully']);
        }
        else {
            return response()->json(['success' => false, 'msg' => 'Error']);
        }

    }



    public function set_variant_image(Request $request, $id, $sku)
    {
        $image_id = $id;

        $image = ProductImages::find($image_id);
        $image->option_id = $sku;

        if($image->save()) {
            return response()->json(['success' => 1, 'msg' => 'Image Configured Successfully']);
        }
        else {
            return response()->json(['success' => false, 'msg' => 'Error']);
        }

    }




    public function set_product_options(Request $request, $id)
    {
        $product = Product::find($id);

        $attributes = AttributeValue::where('attribute_id', $product->product_option)->pluck('value', 'id')->toArray();

        $options = ProductOption::with('attribute_value')->where('product_id', $id)->select('id', 'attribute_value_id', 'status')->get();

        return view('products.product_options', compact('product', 'attributes', 'options'));
    }


    public function store_options_details(Request $request) {
       
        foreach($request->attribute_value_id as $key => $value) {

            $check = ProductOption::where('product_id', $request->product_id)->where('attribute_value_id', $value)->count();
            
            if($check == 0) {
                $obj = new ProductOption();
                $obj->product_id = $request->product_id;
                $obj->attribute_value_id = $value;
                $obj->status = 1;
                $obj->save();
            }
        }
       
        return response()->json(['success' => 1, 'msg' => 'Options Created Successfully']);
                
    }



    public function change_option_status($id)
    {
        $obj = ProductOption::find($id);

        $new_status = $obj->status==1 ? 0 : 1;

        $obj->status = $new_status;
        $obj->save();

        return response()->json(['success' => 1, 'msg' => 'Options Status Successfully']);
    }


}
