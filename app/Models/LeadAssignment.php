<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class LeadAssignment extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'lead_id', 'user_type', 'user_id', 'is_sarthi', 'remarks', 'status'
    ];

    protected $dates = ['deleted_at'];

    public function sarthi()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}