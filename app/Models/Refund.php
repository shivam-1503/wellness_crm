<?php

namespace App\Models;


use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class Refund extends Model
{
    protected $fillable = [
        'reimbursement_type',
        'bill_number',
        'bill_amount',
        'claim_amount',
        'start_date',
        'end_date',
        'remarks',
        'bill_attachment'
    ];
}