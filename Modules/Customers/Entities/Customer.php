<?php

namespace Modules\Customers\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupons\Database\factories\CouponFactory;
use Illuminate\Support\Facades\DB;

class Customer extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): CustomerFactory
    {
        //return CustomerFactory::new();
    }
}
