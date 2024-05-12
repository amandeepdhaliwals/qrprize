<?php

namespace Modules\Gallery\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Gallery extends BaseModel
{
    use HasFactory;

    protected $table = 'galleries';

    /**
     * The attributes that are mass assignable.
     */
    
    protected $fillable = [];

    public function getTableColumns()
    {
        
        $table_name = DB::getTablePrefix().$this->getTable();

        $columns  = DB::select('SHOW COLUMNS FROM '.$table_name);

        $filteredColumns = array_filter($columns, function ($column) {
            return in_array($column->Field, ['title', 'description', 'image', 'image_type', 'status','free_services','updated_at', 'created_at']);
        });
        return  $filteredColumns;
    }
}
    
