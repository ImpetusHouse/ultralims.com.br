<?php

namespace App\Models\QuickActions\Tickets;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonsRefusal extends Model
{
    use HasFactory, Hashid;
    protected $fillable = ['reason', 'only_adm', 'show_to', 'is_operator'];

}
