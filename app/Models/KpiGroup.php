<?php
  
namespace App\Models;
 

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
   
class KpiGroup extends Model
{
    protected $fillable = [
        'title', 'status',
    ];

}