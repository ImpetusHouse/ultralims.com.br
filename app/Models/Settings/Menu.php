<?php

namespace App\Models\Settings;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'menu';

    protected $fillable = [
        'default', 'title',
        'logo', 'logo_scroll', 'layout',
        'background_color', 'item_color', 'item_color_scroll', 'item_hover_color', 'item_hover_color_scroll',
        'background_color_dropdown', 'item_color_dropdown', 'item_hover_color_dropdown',
    ];
}
