<?php

namespace App\Models\Pages\IA;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prompt extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'prompts';

    protected $fillable = ['title', 'prompt'];
}
