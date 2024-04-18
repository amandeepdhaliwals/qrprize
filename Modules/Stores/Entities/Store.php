<?php

namespace Modules\Stores\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupons\Database\factories\CouponFactory;
use Illuminate\Support\Facades\DB;

class Store extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): StoreFactory
    {
        //return StoreFactory::new();
    }
}
