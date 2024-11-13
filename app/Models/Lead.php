<?php

namespace App\Models;


use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class Lead extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes, HasFactory;

    public $timestamps = true;

    protected $fillable = [ 'company_id', 'priority',  'title', 'customer_id_fk', 'first_name', 'last_name', 'company', 'email', 'phone', 'whatsapp', 'state_id', 'city', 'address', 'source_id_fk', 'source_type', 'est_amount', 'service_id', 'category', 'description', 'remarks', 'stage_id_fk', 'assigned_to', 'prospecting_status', 'prospecting_at', 'status' ];

    protected $dates = ['deleted_at'];

    // protected $appends = ['full_name'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id_fk');
    }

    public function stage()
    {
        return $this->belongsTo('App\Models\LeadStage', 'stage_id_fk');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function assignee()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to');
    }


    public function currentJob()
    {
        return $this->hasOne('App\Models\LeadActivity', 'lead_id_fk')->latest();
    }

    public function lastComment()
    {
        return $this->hasOne('App\Models\LeadComment', 'lead_id_fk')->latest();
    }

    // public function getFullNameAttribute()
    // {
    //     return $this->attributes['first_name'] . " " . $this->attributes["last_name"];
    // }

    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', Auth::user()->company_id);
    //     });
    // }

}
