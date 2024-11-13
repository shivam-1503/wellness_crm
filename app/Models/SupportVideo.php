<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class SupportVideo extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = ['category_id', 'title', 'description', 'url', 'status'];

    protected $dates = ['deleted_at'];


    public function category()
	{
		return $this->belongsTo('App\Models\VideoCategory', 'category_id');
	}


}