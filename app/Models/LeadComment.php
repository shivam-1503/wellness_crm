<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class LeadComment extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [ 'lead_id_fk', 'comment', 'priority', 'old_stage', 'new_stage', 'created_by'];

    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

}