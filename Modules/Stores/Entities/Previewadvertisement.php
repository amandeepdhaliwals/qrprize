<?php

namespace Modules\Stores\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stores\Database\factories\PreviewadvertisementFactory;

class Previewadvertisement extends Model
{
    use HasFactory;

    protected $table = 'preview_advertisements';
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
        "winning_type",
        "other_coupon_prize_heading",
        "other_coupon_images_id",
        "coupons_id",
        "total_no_of_coupons",
        "lock_time",
        "winning_ratio",
        "status"
    ];
    
    protected static function newFactory(): PreviewadvertisementFactory
    {
        //return PreviewadvertisementFactory::new();
    }
}
