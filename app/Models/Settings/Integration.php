<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Integration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'integrations';

    protected $fillable = [
        'title', 'documentation',
        'url', 'key', 'secret', 'token',
        'model', 'temperature', 'tokens',
        'status'
    ];
}
