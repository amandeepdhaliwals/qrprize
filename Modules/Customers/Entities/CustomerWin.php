<?php

namespace Modules\Customers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customers\Database\factories\CustomerWinFactory;

class CustomerWin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'customer_wins';
    protected $fillable = [
        'customer_results_id',
        'customer_id',
        'coupon_id',
        'win_time'
    ];
    
    protected static function newFactory(): CustomerWinFactory
    {
        //return CustomerWinFactory::new();
    }
}
