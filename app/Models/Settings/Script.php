<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Script extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'scripts';

    protected $fillable = ['title', 'position', 'show_mobile', 'script'];
}
