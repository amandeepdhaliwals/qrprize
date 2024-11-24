<?php

namespace Modules\Mobilesettings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appsiteinformation extends Model
{
    use HasFactory;

    protected $table = 'app_site_information';  // Define the coins table explicitly

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'type', 'content', 'mobile', 'email'
    ];

    // If needed, you can add any other relationships or methods to fetch specific data related to 'Coin'
}
