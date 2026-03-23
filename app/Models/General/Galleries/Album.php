<?php

namespace App\Models\General\Galleries;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'albums';

    protected $fillable = ['title', 'photographer', 'event_date', 'hide'];
}
