<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class OrderStage extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'stage'
    ];

    protected $dates = ['deleted_at'];

}