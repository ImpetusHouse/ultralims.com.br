<?php

namespace App\Models\Settings;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Font extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'fonts';

    protected $fillable = [
        'profile', 'default',
        'desktop', 'mobile',
        'is_bold', 'line_spacing',
        'type',
    ];
}
