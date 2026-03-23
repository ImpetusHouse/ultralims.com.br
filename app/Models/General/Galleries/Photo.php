<?php

namespace App\Models\General\Galleries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'galleries_photos';

    protected $fillable = ['gallery_id', 'path'];

    public function gallery(){
        return $this->belongsTo(Gallery::class);
    }
}
