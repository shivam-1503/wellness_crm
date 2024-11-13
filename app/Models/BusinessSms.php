<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class BusinessSms extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $table = "my_sms_details";




    protected $fillable = [
        'company_id', 'endpoint', 'username', 'password', 'bearer_token', 'sender_name'
    ];

    protected $dates = ['deleted_at'];


    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('company_id', Auth::user()->company_id);
        });
    }

}