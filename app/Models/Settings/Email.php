<?php

namespace App\Models\Settings;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'emails';

    protected $fillable = ['layout', 'title', 'subject', 'content', 'status'];
}
