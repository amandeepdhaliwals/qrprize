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
    protected $table = 'campaign';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'campaign_name',
        'store_id',
        'qr_code_url',
        'qr_code_image',
        'lock_time',
        'advertisement_ids'
    ];

    protected $casts = [
        'advertisement_ids' => 'array',
    ];
    
    protected static function newFactory(): CampaignFactory
    {
        //return CampaignFactory::new();
    }
}
