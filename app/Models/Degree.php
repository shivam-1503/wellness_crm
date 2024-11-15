<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

use \Carbon\Carbon;

class Degree extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = ['title', 'status'];

    protected $dates = ['deleted_at'];


}