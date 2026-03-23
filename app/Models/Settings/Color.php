<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'colors';

    protected $fillable = [
        'color',
        'is_default_title_light', 'is_default_content_light', 'is_default_icon_light',
        'is_default_title_dark', 'is_default_content_dark', 'is_default_icon_dark'
    ];
}
