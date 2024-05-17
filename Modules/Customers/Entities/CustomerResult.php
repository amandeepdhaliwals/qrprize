<?php

namespace Modules\Customers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customers\Database\factories\CustomerResultFactory;

class CustomerResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'customer_results';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'store_id',
        'campaign_id',
        'advertisement_id',
        'win'
    ];

    protected $casts = [
        //'advertisement_ids' => 'array',
    ];
    
    protected static function newFactory(): CampaignFactory
    {
        //return CampaignFactory::new();
    }
}
