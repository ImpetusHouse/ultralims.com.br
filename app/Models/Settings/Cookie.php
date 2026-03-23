<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cookie extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cookie';

    protected $fillable = [
        'title', 'description', 'status',
        'color',
        'button_decline_color', 'button_decline_border_color', 'button_decline_title_color',
        'button_hover_decline_color', 'button_hover_decline_border_color', 'button_hover_decline_title_color',
        'button_accept_color', 'button_accept_border_color', 'button_accept_title_color',
        'button_hover_accept_color', 'button_hover_accept_border_color', 'button_hover_accept_title_color'
    ];
}
