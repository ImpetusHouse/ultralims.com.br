<?php

namespace App\Models\Articles;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'articles_tags';

    protected $fillable = ['title'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'articles_tags_pivot', 'tag_id', 'article_id')->withTimestamps();
    }
}
