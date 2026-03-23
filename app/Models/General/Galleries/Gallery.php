<?php

namespace App\Models\General\Galleries;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'galleries';

    protected $fillable = ['title', 'photographer', 'slug', 'status', 'date'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function photos(){
        return $this->hasMany(Photo::class);
    }
}
