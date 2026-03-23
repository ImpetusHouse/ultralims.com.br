<?php

namespace App\Models\UltraLims;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Call_User extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_call_clicks';

    protected $fillable = [
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(UL_User::class, 'user_id');
    }
}
