<?php

namespace Modules\Coupons\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupons\Database\factories\ClaimFactory;

class Claim extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
     'customer_id',
     'advertisement_id',
     'name',
     'address',
     'coupon_id',
     'is_claimed',
     'request_claim',
     'email_sent'
    ];

    protected static function newFactory(): ClaimFactory
    {
        //return ClaimFactory::new();
    }
}
