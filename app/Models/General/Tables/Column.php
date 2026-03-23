<?php

namespace App\Models\General\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tables_columns';

    protected $fillable = ['table_id', 'column', 'title'];

    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function rows(){
        return $this->hasMany(Row::class);
    }
}
