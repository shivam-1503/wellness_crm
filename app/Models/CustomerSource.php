<?php

namespace App\Models;

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

   
class CustomerSource extends Model
{
	protected $fillable = ['id','name', 'status'];
}