<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class InvoiceActivity extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [ 'emi_id', 'comment', 'act_time', 'act_with', 'location', 'description', 'waiting_days', 'activity_type', 'status' ];

    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

}