<?php

namespace App\Models\QuickActions\Tickets;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomaticMessages extends Model
{
    use HasFactory, Hashid;
    protected $fillable = ['to', 'message', 'active'];
}
