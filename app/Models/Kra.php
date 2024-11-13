<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class Kra extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'company_id', 'employee_id', 'kpi_id', 'target', 'status', 'weightage', 'review_frequency', 'approved_at', 'approved_by'
    ];


    protected $dates = ['deleted_at'];

    
    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', Auth::user()->company_id);
    //     });
    // }

}