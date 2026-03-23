<?php

namespace App\Models\Pages;

use App\Models\Articles\Article;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Hashid, SoftDeletes;
    protected $table = 'pages_categories';
    protected $fillable = ['title', 'color', 'slug'];

    public function pages()
    {
        return $this->hasMany(Page::class)->withTimestamps();
    }
}
