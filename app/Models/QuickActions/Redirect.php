<?php

namespace App\Models\QuickActions;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Redirect extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'redirects';

    protected $fillable = ['from', 'to', 'status'];
}
