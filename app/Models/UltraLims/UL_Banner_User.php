<?php

namespace App\Models\UltraLims;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Banner_User extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_banner_clicks';

    protected $fillable = [
        'banner_id', 'user_id',
    ];

    public function banner(){
        return $this->belongsTo(Banner::class);
    }

    public function user(){
        return $this->belongsTo(UL_User::class, 'user_id');
    }
}
