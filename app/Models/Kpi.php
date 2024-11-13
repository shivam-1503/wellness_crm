<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class Kpi extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'company_id', 'title', 'kpi_group_id', 'description', 'unit', 'status', 'company_id',
    ];



    protected $dates = ['deleted_at'];


    public function group()
    {
        return $this->belongsTo('App\Models\KpiGroup', 'kpi_group_id');
    }

    
    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', Auth::user()->company_id);
    //     });
    // }

}