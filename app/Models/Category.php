<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class Category extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'name', 'p_id', 'slug', 'short_code', 'status', 'company_id',
    ];

    protected $dates = ['deleted_at'];

    /*
    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('company_id', Auth::user()->company_id);
        });
    }
    */

}