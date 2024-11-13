<?php

namespace App\Models;

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class ExpanseRequest extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;
    
    public $fillable = ['id', 'vendor_id', 'cat_id', 'sub_cat_id', 'title', 'description', 'amount', 'invoice_ref', 'invoice_date', 'invoice_due_date', 'status', 'remarks', 'action_by', 'action_at'];

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }


    public function category()
    {
        return $this->belongsTo('App\Models\ExpanseCategory', 'cat_id');
    }

    public function sub_category()
    {
        return $this->belongsTo('App\Models\ExpanseCategory', 'sub_cat_id');
    }

}
