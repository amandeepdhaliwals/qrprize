<?php

namespace Modules\Stores\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stores\Database\factories\AdvertisementFactory;

class Advertisement extends Model
{
    use HasFactory;

    protected $table = 'advertisement';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "advertisement_name",
        "store_id",
        "adv_video_id",
        "heading",
        "primary_image_id",
        "secondary_images_id",
        "other_coupon_prize_heading",
        "other_coupon_images_id",
        "coupons_id",
        "total_no_of_coupons",
        "lock_time",
        "winning_ratio",
        "status"
    ];
    
    
    protected static function newFactory(): AdvertisementFactory
    {
        //return AdvertisementFactory::new();
    }
}
