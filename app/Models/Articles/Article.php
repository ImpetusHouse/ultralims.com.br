<?php

namespace App\Models\Articles;

use App\Models\General\Galleries\Gallery;
use App\Models\User;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'articles';

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
        return $this->belongsToMany(Category::class, 'articles_categories_pivot', 'article_id', 'category_id')->withTimestamps();
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'articles_tags_pivot', 'article_id', 'tag_id')->withTimestamps();
    }

    public function galleries(){
        return $this->belongsToMany(Gallery::class, 'articles_galleries_pivot', 'article_id', 'gallery_id')->withTimestamps();
    }

    public function article(){
        return $this->belongsTo(Article::class)->withTrashed();
    }

    public function edited(){
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }
}
