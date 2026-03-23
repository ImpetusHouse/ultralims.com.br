<?php

namespace App\Models\General\Magazines;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Magazine extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'magazines';

    protected $fillable = ['photo', 'title', 'pdf', 'status'];
}
