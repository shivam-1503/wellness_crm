<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class Order extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = ['lead_id', 'customer_id', 'project_id', 'property_type_id', 'property_id', 'order_stage', 'total_amount', 'advance_amopunt', 'current_balance', 'months', 'emi_paid', 'late_emi', 'upcoming_emi_date', 'rate', 'monthly_emi', 'payment_type', 'order_date', 'is_quoted', 'is_invoice', 'status'];

    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }


    public function property()
    {
        return $this->belongsTo('App\Models\Property', 'property_id');
    }

    public function property_type()
    {
        return $this->belongsTo('App\Models\PropertyType', 'property_type_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }



}