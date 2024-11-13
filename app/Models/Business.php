<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class Business extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $table = "my_business";




    protected $fillable = [
        'company_id', 'full_name', 'name', 'established_in', 'state_id', 'address', 'city', 'pincode', 'landline', 'fax', 'email', 'phone'
    ];

    protected $dates = ['deleted_at'];


    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', Auth::user()->company_id);
    //     });
    // }

}