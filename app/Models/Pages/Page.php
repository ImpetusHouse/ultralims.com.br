<?php

namespace App\Models\Pages;

use App\Models\Settings\Group_Item_Menu;
use App\Models\Settings\Menu;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'pages';

    protected $fillable = [
        'category_id', 'page_id', 'menu_id', 'group_id', 'display_order', 'intranet', 'svg', 'title', 'slug', 'menu', 'status', 'mode', 'header', 'footer',
        'seo_title', 'seo_description', 'seo_keywords', 'seo_image'
    ];

    public function group(){
        return $this->belongsTo(Group_Item_Menu::class);
    }

    public function menuItem(){
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function prefix_slug(){
        return $this->belongsToMany(PrefixSlug::class, 'prefix_slug_pages_pivot', 'page_id', 'prefix_slug_id')->withPivot('id')->orderBy('prefix_slug_pages_pivot.id');
    }

    public function page(){
        return $this->belongsTo(Page::class);
    }

    public function pages(){
        return $this->hasMany(Page::class);
    }

    public function blocks(){
        return $this->hasMany(Block::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'pages_categories_pivot', 'page_id', 'category_id');
    }

    public function pages_parents(){
        return $this->belongsToMany(Page::class, 'pages_pages_pivot', 'page_id', 'page_parent_id');
    }

    public function pages_childrens(){
        return $this->belongsToMany(Page::class, 'pages_pages_pivot', 'page_parent_id', 'page_id')
            ->withTimestamps()
            ->withPivot('display_order')
            ->orderBy('pages_pages_pivot.display_order', 'asc');
    }
}
