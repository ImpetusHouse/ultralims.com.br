<?php

namespace App\Models\Pages;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block_Tab extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'blocks_tabs';

    protected $fillable = [
        'block_id',
        'tab',
        'title', 'title_color',
        'subtitle', 'subtitle_color',
        'content', 'content_alignment', 'content_color', 'content_type', 'display_content', 'content_link', 'image', 'video', 'display_image',
        'background_color',
        'button_display', 'button_title', 'button_title_color', 'button_border_color', 'button_color', 'button_type', 'button_link',
        'button_display_1', 'button_title_1', 'button_title_color_1', 'button_border_color_1', 'button_color_1', 'button_type_1', 'button_link_1',
        'date', 'hour', 'month',
        'icon', 'icon_color',
        'number', 'number_color',
        'divider', 'divider_color',
        'page_value_of', 'page_value_by', 'page_value_of_color', 'page_value_by_color',
        'cards_categories',
        'type',
        'font_title', 'font_subtitle', 'font_description', 'font_button'
    ];

    public function block(){
        $this->belongsTo(Block::class);
    }
}
