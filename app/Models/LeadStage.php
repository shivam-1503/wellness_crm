<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class LeadStage extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [ 'name', 'icon', 'status', 'disp_order' ];

    protected $dates = ['deleted_at'];

}