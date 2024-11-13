<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class CustomerPayment extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'emi_id', 'customer_id', 'order_id', 'emi_amount', 'previous_balance', 'total_amount', 'extra_charges', 'net_payable', 'amount_paid', 'payment_mode', 'payment_date', 'payment_ref_no', 'payment_type', 'status', 'balance', 'remarks', 'audit_remarks', 'audit_by', 'audit_at',
    ];

    protected $dates = ['deleted_at'];

    

}