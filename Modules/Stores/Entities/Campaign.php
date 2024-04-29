<?php

namespace Modules\Stores\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stores\Database\factories\CampaignFactory;

class Campaign extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_coupons_assign';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'coupon_id',
        'qr_code_url',
        'user_id',
        'qrcode_id',
        'coupon_id',
        'total_no_of_coupons',
        'no_of_winned_coupons',
        'qrcode_id',
        'qrcode_id',
    ];
    
    protected static function newFactory(): CampaignFactory
    {
        //return CampaignFactory::new();
    }
}
