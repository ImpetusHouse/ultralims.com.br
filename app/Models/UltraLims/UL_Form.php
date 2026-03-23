<?php

namespace App\Models\UltraLims;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Form extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_forms';

    protected $fillable = [
        'idLaboratorio', 'idUser',
        'company', 'cnpj', 'state', 'city', 'neighborhood', 'street', 'number', 'complement',
        'name', 'office', 'email', 'phone', 'notify_on'
    ];
}
