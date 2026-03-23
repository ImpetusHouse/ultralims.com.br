<?php

namespace App\Models\UltraLims\Articles;

use App\Models\User;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'ultralims_articles';

    protected $fillable = [
        'photo', 'creditos', 'title', 'slug', 'content', 'status',
        'published_at', 'published_by', 'scheduled_for',
        'seo_title', 'seo_description', 'seo_keywords',
        'article_id', 'edited_by', 'version', 'message'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'published_by', 'id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'ultralims_articles_categories_pivot', 'article_id', 'category_id')->withTimestamps();
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'ultralims_articles_tags_pivot', 'article_id', 'tag_id')->withTimestamps();
    }

    public function article(){
        return $this->belongsTo(Article::class)->withTrashed();
    }

    public function edited(){
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }
}
