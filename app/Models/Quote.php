<?php

namespace App\Models;


use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class Quote extends Model
{
	use AuditableWithDeletesTrait, SoftDeletes;

    protected $fillable = [
        'lead_id_fk', 'customer_id_fk', 'quote_stage', 'amount', 'subject', 'instruction',  'quote_date', 'due_date', 'is_quoted', 'is_invoice', 'status'
    ];

    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

}
