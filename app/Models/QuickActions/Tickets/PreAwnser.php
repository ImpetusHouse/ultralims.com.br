<?php

namespace App\Models\QuickActions\Tickets;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreAwnser extends Model
{
    use HasFactory, SoftDeletes, Hashid;
    protected $fillable = ['title', 'awnser'];
}
