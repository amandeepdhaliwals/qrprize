<?php

namespace Modules\Mobilesettings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Mobilesettings\Database\factories\AppinformationFactory;

class Appinformation extends Model
{
    use HasFactory;
    protected $table = 'app_site_information';  // Define the coins table explicitly

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'type', 'content', 'mobile', 'email'
    ];
    
    protected static function newFactory(): AppinformationFactory
    {
        //return AppinformationFactory::new();
    }
}
