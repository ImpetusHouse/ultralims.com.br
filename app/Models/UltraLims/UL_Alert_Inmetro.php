<?php

namespace App\Models\UltraLims;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Alert_Inmetro extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_alerts_inmetro';

    protected $fillable = ['alert', 'link'];

    /**
     * Relacionamento com a model UL_User (Muitos para Muitos).
     * Inclui o campo `read_at` da tabela pivot.
     */
    public function users()
    {
        return $this->belongsToMany(
            UL_User::class,
            'ultralims_alerts_inmetro_users_pivot',
            'alert_id',
            'user_id'
        )->withPivot('read_at')->withTimestamps();
    }
}
