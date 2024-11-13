<?php

namespace App\Models;

use Auth;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class LeadQuestion extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    public $timestamps = true;
    
    public $fillable = ['id', 'company_id', 'form_id', 'type', 'title', 'description', 'status', 'order_by'];

    

    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('company_id', Auth::user()->company_id);
        });
    }

}
