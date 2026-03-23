<?php

namespace App\Models\QuickActions\Tickets;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, Hashid, SoftDeletes;
    protected $table = 'tickets_clients';
    protected $fillable = ['cpf_cnpj', 'name', 'email', 'phone', 'is_member', 'member_number', 'office', 'company_name', 'quantity', 'state', 'city'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'client_id', 'id');
    }
}
