<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class OrderEmi extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'company_id', 'customer_id', 'order_id', 'month', 'emi_amount', 'due_date', 'status', 'balance', 'transaction_id', 'invoice_date', 'invoice_code'
    ];

    protected $dates = ['deleted_at'];


    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('company_id', Auth::user()->company_id);
        });
    }

}