<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class Service extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'type', 'status', 'company_id',
    ];

    protected $dates = ['deleted_at'];

    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', Auth::user()->company_id);
    //     });
    // }

}