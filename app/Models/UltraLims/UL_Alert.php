<?php

namespace App\Models\UltraLims;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Alert extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_alerts';

    protected $fillable = [
       'idUser', 'idLaboratorio', 'photo', 'title', 'slug', 'content', 'start_date', 'end_date'
    ];

    protected $casts = ['start_date' => 'datetime', 'end_date' => 'datetime'];
}
