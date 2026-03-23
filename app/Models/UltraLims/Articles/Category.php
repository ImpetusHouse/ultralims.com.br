<?php

namespace App\Models\UltraLims\Articles;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Category extends Model
{
    use HasFactory, Hashid, SoftDeletes;
    protected $table = 'ultralims_articles_categories';

    protected $fillable = ['title', 'slug', 'color'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'ultralims_articles_categories_pivot', 'category_id', 'article_id')->withTimestamps();
    }
}
