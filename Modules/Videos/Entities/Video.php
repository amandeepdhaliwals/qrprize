<?php

namespace Modules\Videos\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Video extends BaseModel
{

    use HasFactory;

    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     */
 
    protected $fillable = [];
    

    public function getTableColumns()
    {
        
        $table_name = DB::getTablePrefix().$this->getTable();

        $columns  = DB::select('SHOW COLUMNS FROM '.$table_name);

        $filteredColumns = array_filter($columns, function ($column) {
            return in_array($column->Field, ['title', 'description', 'media', 'media_type', 'status','updated_at', 'created_at']);
        });
        return  $filteredColumns;
    }
}
