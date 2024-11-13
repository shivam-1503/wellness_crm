<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
   
class OrderDetail extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'order_id_fk', 'name', 'price', 'quantity', 'tax', 'tax_amount', 'cost',
    ];

    protected $dates = ['deleted_at'];

}