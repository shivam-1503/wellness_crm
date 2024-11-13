<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class Dealer extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = ['name','date_of_birth','aadhar','mobile','email','rating','type_id','permanent_address','permanent_state_id','permanent_district_id','permanent_city','permanent_pincode','present_address','present_state_id','present_district_id','present_city','present_pincode','status','is_kyc'];

    protected $dates = ['deleted_at'];
}
