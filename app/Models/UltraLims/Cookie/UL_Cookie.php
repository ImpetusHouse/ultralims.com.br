<?php

namespace App\Models\UltraLims\Cookie;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Cookie extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_cookies';

    protected $fillable = ['title', 'content', 'priority', 'start', 'end', 'status'];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function ulCookieUsers(){
        return $this->hasMany(UL_Cookie_User::class, 'cookie_id', 'id');
    }
}
