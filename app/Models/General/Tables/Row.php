<?php

namespace App\Models\General\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Row extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tables_rows';

    protected $fillable = ['column_id', 'row', 'content'];

    public function column(){
        return $this->belongsTo(Column::class);
    }
}
