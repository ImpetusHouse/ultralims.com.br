<?php

namespace App\Models\General\Events;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'events';

    protected $fillable = [
        'display_order', 'photo', 'photo_square', 'date', 'end_date', 'title', 'slug', 'description', 'content', 'time', 'local',
        'button_display', 'button_title', 'button_type', 'button_link',
        'status'
    ];

    protected $casts = [
        'date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
