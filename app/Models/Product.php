<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

use App\Models\ProductPrice;
use \Carbon\Carbon;
use App\Models\Attribute;
use App\Models\Attributes;
use App\Models\Tax;
use App\Models\Category;
use DB;

class Product extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = ['name','sku','description','short_description','tax','category_id', 'product_option', 'hsn_code','specification','slug','attribute', 'is_diy_enabled', 'is_diy', 'product_option', 'rating', 'thumb_image', 'start_price', 'end_price', 'status'];

    protected $dates = ['deleted_at'];


    public function product_images()
    {
        return $this->hasMany('App\Models\ProductImages');
    }

	public function seo_data()
	{
		return $this->belongsTo('App\Models\SeoMetaDetail', 'product_id');
	}

	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}


	// public function sub_category()
	// {
	// 	return $this->belongsTo('App\Models\Category', 'sub_category_id');
	// }


	public function getProductWithCategory() 
	{

	}



	public function skus()
    {
        return $this->hasMany('App\Models\Sku');
    }


	public function getPriceStartsFrom(){
        $starts_from=$this->skus()->min('unit_amount');
        return $starts_from;
    }


	public function getThumbImage() {
		$img = $this->product_images()->first();
		return asset('uploads/products/'.$img->image);
	}


    public function getCategoryName(){
        $cat=explode(',', $this->category);
        
		$data = \DB::table('categories')->select(DB::raw("GROUP_CONCAT(name) as `names`"))
				->whereIn('id', $cat)
				->get();
		return @$data[0]->names;
	}

}