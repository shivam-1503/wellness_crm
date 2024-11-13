<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class LeadActivity extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [ 'lead_id_fk', 'user_id', 'act_time', 'act_with', 'act_slot', 'location', 'description', 'waiting_days', 'activity_type', 'old_stage', 'new_stage', 'status' ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function activity_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}