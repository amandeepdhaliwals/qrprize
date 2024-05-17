<?php

namespace Modules\Customers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customers\Database\factories\OtpVerificationFactory;

class OtpVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'otp_verifications';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'otp_code',
        'type',
        'is_verified',
        'expires_at'
    ];

    protected $casts = [
        //'advertisement_ids' => 'array',
    ];
    
    protected static function newFactory(): CampaignFactory
    {
        //return CampaignFactory::new();
    }
}
