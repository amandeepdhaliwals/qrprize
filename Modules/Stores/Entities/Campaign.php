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
        'qr_code_image',
        'user_id',
        'qrcode_id',
        'coupon_id',
        'total_no_of_coupons',
        'no_of_winned_coupons',
        'campaign_name',
        'adv_video_id',
        'primary_image_id',
        'secondary_images_id',
        'coupons_id',
        'lock_time',
        'winning_ratio',
    ];

    protected $casts = [
        'secondary_images_id' => 'array',
        'coupons_id' => 'array',
    ];
    
    protected static function newFactory(): CampaignFactory
    {
        //return CampaignFactory::new();
    }
}
