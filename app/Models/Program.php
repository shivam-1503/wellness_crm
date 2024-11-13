<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class Program extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id', 'title','user_id','status', 'description', 'valid_from', 'valid_till',  'is_deactive','deactivated_by'];

    protected $dates = ['deleted_at'];

    public function clientName()
{
    return $this->belongsTo('App\Models\Client', 'client_id');
}

}
