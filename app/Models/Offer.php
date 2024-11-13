<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class Offer extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['partner_id', 'offer_title', 'offer_cat_id', 'offer_group_id', 'offer_code', 'offer_value', 'offer_image', 'offer_tnc', 'offer_details','valid_from','valid_till','status'];

    protected $dates = ['deleted_at'];

}
