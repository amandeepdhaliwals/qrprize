<?php

namespace Modules\Stores\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stores\Database\factories\AdvertisementFactory;
use Modules\Mobilesettings\Entities\CampaignAdsMeta; 
use Modules\Videos\Entities\Video;

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

    public function campaignAdsMeta()
    {
        return $this->hasOne(CampaignAdsMeta::class, 'advertisement_id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'adv_video_id'); // Foreign key 'adv_video_id' in advertisements table
    }
}
