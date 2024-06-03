<?php

namespace Modules\Customers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customers\Database\factories\VisitorFactory;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitors';
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'user_id_cookie',
        'store_id',
        'campaign_id',
        'advertisement_id',
        'view'
    ];
    
    protected static function newFactory(): VisitorFactory
    {
        //return VisitorFactory::new();
    }
}
