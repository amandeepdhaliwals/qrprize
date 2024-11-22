<?php

namespace Modules\Mobilesettings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coin extends Model
{
    use HasFactory;

    protected $table = 'coins';  // Define the coins table explicitly

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category',          // The category for the coin
        'coins_per_category' // The number of coins per category
    ];

    // If needed, you can add any other relationships or methods to fetch specific data related to 'Coin'
}
