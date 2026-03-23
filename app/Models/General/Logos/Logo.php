<?php

namespace App\Models\General\Logos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'logos';

    protected $fillable = ['category_id', 'path'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
