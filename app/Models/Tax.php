<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class Tax extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'name', 'status', 'client_id_fk',
    ];

    protected $dates = ['deleted_at'];

    protected static function booted()
    {
        static::addGlobalScope('client', function (Builder $builder) {
            $builder->where('client_id_fk', Auth::user()->client_id_fk);
        });
    }

}