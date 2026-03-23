<?php

namespace App\Models\UltraLims;

use App\Models\General\Products\Product;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_User extends Model implements AuthenticatableContract
{
    use HasFactory, Hashid, SoftDeletes, Authenticatable;

    protected $table = 'ultralims_users';

    protected $fillable = [
        'idUser', 'user', 'email', 'tipoUser',
        'idLaboratorio', 'laboratorio',
        'urlRedirect', 'chat'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Relacionamento com a model UL_Alert_Inmetro (Muitos para Muitos).
     * Inclui o campo `read_at` da tabela pivot.
     */
    public function alerts()
    {
        return $this->belongsToMany(
            UL_Alert_Inmetro::class,
            'ultralims_alerts_inmetro_users_pivot',
            'user_id',
            'alert_id'
        )->withPivot('read_at')->withTimestamps();
    }

    public function unreadAlerts()
    {
        return $this->alerts()->wherePivotNull('read_at');
    }
}
