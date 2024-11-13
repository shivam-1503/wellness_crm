<?php

namespace App\Models;

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class Customer extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;
    
    public $fillable = ['id', 'company_id', 'account_manager_id', 'source_id', 'first_name', 'last_name', 'dob', 'uidai', 'pan', 'state_id', 'city', 'address', 'pincode', 'position', 'email', 'current_balance', 'phone', 'company', 'status', 'website', 'remarks', 'company'];


    public function source()
    {
        return $this->belongsTo('App\Models\CustomerSource', 'source_id');
    }
    

    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('company_id', Auth::user()->company_id);
        });
    }

}
