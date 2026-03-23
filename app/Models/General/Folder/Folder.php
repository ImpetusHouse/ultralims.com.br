<?php

namespace App\Models\General\Folder;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'folders';

    protected $fillable = ['title', 'slug'];

    public function items(){
        return $this->hasMany(Item::class);
    }
}
