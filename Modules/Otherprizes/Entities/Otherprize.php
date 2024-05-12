<?php
namespace Modules\Otherprizes\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupons\Database\factories\AdvertisementFactory;
use Illuminate\Support\Facades\DB;

class Otherprize extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'otherprizes';
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
            return in_array($column->Field, ['title', 'description', 'media', 'media_type', 'status','free_services','updated_at', 'created_at']);
        });
        return  $filteredColumns;
    }
}
