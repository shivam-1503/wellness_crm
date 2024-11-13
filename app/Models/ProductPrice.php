<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'product_price';
    public $timestamps = true;


    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    
}