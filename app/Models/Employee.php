<?php

namespace App\Models;

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class Employee extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;
    
    public $fillable = ['id', 'company_id', 'name', 'profile_image', 'designation_id', 'reporting_manager_id', 'employee_code', 'email', 'phone', 'dob', 'gender', 'uidai', 'pan', 'state_id', 'city', 'address', 'pincode', 'experience',  'joining_date', 'last_working_date', 'display_order', 'kpi_group', 'kra_status', 'status',];

    public function source()
    {
        return $this->belongsTo('App\Models\CustomerSource', 'source_id');
    }

    public function designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }


    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', Auth::user()->company_id);
    //     });
    // }

}
