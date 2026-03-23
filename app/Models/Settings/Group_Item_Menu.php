<?php

namespace App\Models\Settings;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group_Item_Menu extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'group_items_menu';

    protected $fillable = ['title', 'default'];

    public function items(){
        return $this->hasMany(Item_Menu::class, 'group_id', 'id')->orderBy('display_order');
    }
}
