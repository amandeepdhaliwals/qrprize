<?php

namespace Modules\Customers\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupons\Database\factories\AuditTrailFactory;
use Illuminate\Support\Facades\DB;

class AuditTrail extends BaseModel
{
    use HasFactory;

    protected $table = 'audit_trails';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'action',
        'data'
    ];
    
    protected static function newFactory(): AuditTrailFactory
    {
        //return AuditTrailFactory::new();
    }
}
