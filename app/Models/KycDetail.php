<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class KycDetail extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = ['kyc_ref_no','user_type','user_id','kyc_document_id','kyc_document_no','kyc_document_image','kyc_date','status'];

    protected $dates = ['deleted_at'];

    public function dealer()
    {
        return $this->belongsTo('App\Models\Dealer', 'user_id');
    } 
    public function distributer()
    {
        return $this->belongsTo('App\Models\Distributer', 'user_id');
    } 
    public function influencer()
    {
        return $this->belongsTo('App\Models\Influencer', 'user_id');
    } 
}
