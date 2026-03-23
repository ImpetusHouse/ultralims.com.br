<?php

namespace App\Models\General\Tables;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'tables';

    protected $fillable = ['identification', 'title'];

    public function columns(){
        return $this->hasMany(Column::class);
    }
}
