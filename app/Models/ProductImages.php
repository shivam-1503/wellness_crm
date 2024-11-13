<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class ProductImages extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    protected $guarded = [];
    protected $table = 'product_images';
    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    

    
}
