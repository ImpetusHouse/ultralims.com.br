<?php

namespace App\Models\UltraLims\Cookie;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Cookie_User extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_cookies_users';

    protected $fillable = ['cookie_id', 'user_id'];

    public function ulCookie(){
        return $this->belongsTo(UL_Cookie::class);
    }
}
