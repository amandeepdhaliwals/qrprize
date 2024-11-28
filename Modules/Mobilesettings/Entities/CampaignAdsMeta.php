<?php

namespace Modules\Mobilesettings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Mobilesettings\Database\factories\CampaignAdsMetaFactory;
use Modules\Stores\Entities\Campaign; 
use Modules\Stores\Entities\Advertisement; 

class CampaignAdsMeta extends Model
{
    use HasFactory;

    protected $table = 'campaign_ads_meta';  // Define the coins table explicitly

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'campaign_id', 'advertisement_id', 'is_new_ad', 'is_trending_ad', 'is_ad_of_the_day'
    ];
    
    protected static function newFactory(): CampaignAdsMetaFactory
    {
        //return CampaignAdsMetaFactory::new();
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'id');
    }

    // Define the relationship with the Campaign model
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }
}
