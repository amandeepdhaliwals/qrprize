<?php

namespace Modules\Coupons\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupons\Database\factories\CouponFactory;
use Illuminate\Support\Facades\DB;

class Coupon extends BaseModel
{
    use HasFactory;

    protected $table = 'coupons';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): CouponFactory
    {
        return CouponFactory::new();
    }

    public function getTableColumns()
    {
        $table_name = DB::getTablePrefix().$this->getTable();

        $columns  = DB::select('SHOW COLUMNS FROM '.$table_name);

        $filteredColumns = array_filter($columns, function ($column) {
            return in_array($column->Field, ['title', 'description', 'code', 'image', 'status','category','terms_and_condition','total_coupons','updated_at', 'created_at']);
        });
        return  $filteredColumns;
    }

}
