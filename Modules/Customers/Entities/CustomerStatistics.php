<?php

namespace Modules\Customers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customers\Database\factories\CustomerStatisticsFactory;

class CustomerStatistics extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'customer_statistics';
    protected $fillable = [
        'customer_id',
        'win_count',
        'lose_count'
    ];
    
    protected static function newFactory(): CustomerStatisticsFactory
    {
        //return CustomerStatisticsFactory::new();
    }
}
