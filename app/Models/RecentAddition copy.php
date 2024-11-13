<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class RecentAddition extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;


    protected $fillable = ['title','banner', 'redirect_to', 'status',];
    
    protected $dates = ['deleted_at'];
}