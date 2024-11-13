<?php

namespace App\Models;

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class PaymentTransaction extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;
    
    public $fillable = ['id', 'expanse_id', 'vendor_id', 'amount',  'amount_paid', 'current_balance', 'payment_date', 'payment_mode', 'payment_ref', 'payment_by', 'remarks', 'status'];


    public function expanse()
    {
        return $this->belongsTo('App\Models\Expanse', 'expanse_id');
    }


    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }


    public function payment_user()
    {
        return $this->belongsTo('App\Models\User', 'payment_by');
    }
    

    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', Auth::user()->company_id);
    //     });
    // }

}
