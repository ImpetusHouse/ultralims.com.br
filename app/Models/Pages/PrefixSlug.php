<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrefixSlug extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prefix_slug';

    protected $fillable = ['slug'];

    public function pages(){
        return $this->belongsToMany(PrefixSlug::class, 'prefix_slug_pages_pivot', 'prefix_slug_id', 'page_id');
    }
}
