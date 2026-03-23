<?php

namespace App\Models\Settings;

use App\Models\Articles\Category;
use App\Models\Pages\Page;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'items_menu';

    protected $fillable = [
        'group_id', 'item_menu_id', 'page_id', 'display_order',
        'title', 'type', 'link', 'display', 'is_mega_menu',
        'menu_with_link', 'menu_with_link_type', 'menu_with_link_mobile',
        'background', 'background_color', 'title_color'
    ];

    public function group(){
        return $this->belongsTo(Group_Item_Menu::class);
    }

    public function itemMenu(){
        return $this->belongsTo(Item_Menu::class)->withTrashed();
    }

    public function itemsMenu(){
        return $this->hasMany(Item_Menu::class, 'item_menu_id', 'id');
    }

    public function page(){
        return $this->belongsTo(Page::class)->withTrashed();
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($itemMenu) {
            $itemMenu->itemsMenu()->delete();
        });
    }
}
