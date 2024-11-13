<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class BusinessSocial extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $table = "my_social_details";




    protected $fillable = [
        'company_id', 'facebook', 'google_plus', 'instagram', 'linkedin', 'youtube', 'twitter', 'google_business'
    ];

    protected $dates = ['deleted_at'];


    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', Auth::user()->company_id);
    //     });
    // }

}