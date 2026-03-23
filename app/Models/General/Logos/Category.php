<?php

namespace App\Models\General\Logos;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'logos_categories';

    protected $fillable = ['title', 'status'];

    public function logos(){
        return $this->hasMany(Logo::class);
    }
}
