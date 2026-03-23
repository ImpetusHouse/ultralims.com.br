<?php

namespace App\Models\UltraLims;

use App\Models\General\Products\Product;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Company_Chat extends Model implements AuthenticatableContract
{
    use HasFactory, Hashid, SoftDeletes, Authenticatable;

    protected $table = 'ultralims_companies_chat';

    protected $fillable = [
        'idLaboratorio', 'title', 'status'
    ];
}
