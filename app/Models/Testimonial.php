<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class Testimonial extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;


    protected $fillable = ['user_id', 'name', 'city', 'image', 'description', 'rating', 'status',];
    
    protected $dates = ['deleted_at'];


    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}