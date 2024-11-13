<?php

namespace App\Models;

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class Company extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;
    
    public $fillable = ['id', 'name', 'address', 'state', 'email', 'phone', 'cp_name', 'cp_designation', 'cp_phone', 'cp_email', 'employee_prefix', 'account_updated_at', 'account_expires_at', 'status'];


}
