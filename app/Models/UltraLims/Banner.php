<?php

namespace App\Models\UltraLims;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_banners';

    protected $fillable = [
        'display_order', 'image',
        'tag', 'tag_color', 'tag_title_color',
        'title', 'title_color',
        'description',
        'button_display', 'button_title', 'button_type', 'button_link',
        'button_color', 'button_color_hover', 'button_title_color',
        'status'
    ];
}
