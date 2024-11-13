<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class Task extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['lead_id', 'type', 'title','start_date','end_date','priority','description', 'attendee', 'meeting_link', 'status', 'response_remarks', 'response_status', 'user_id'];

    protected $dates = ['deleted_at'];


    public function lead()
    {
        return $this->belongsTo('App\Models\Lead', 'lead_id');
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // public function departments()
    // {
    //     return $this->belongsTo('App\Models\Department', 'available_for');
    // }

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['title','start_date','end_date','available_for','description','status']);
    //     // Chain fluent methods for configuration options
    // }
}
