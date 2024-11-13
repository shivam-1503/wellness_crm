<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class RedeemRequest extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'offer_id', 'gift_id', 'status', 'points', 'request_date', 'reject_remarks'];

    protected $dates = ['deleted_at'];


    public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}


    public function offer()
	{
		return $this->belongsTo('App\Models\Offer', 'offer_id');
	}


    public function gift()
	{
		return $this->belongsTo('App\Models\Gift', 'gift_id');
	}

}
