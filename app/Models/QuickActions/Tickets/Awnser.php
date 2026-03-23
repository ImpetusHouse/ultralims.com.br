<?php

namespace App\Models\QuickActions\Tickets;

use App\Models\User;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Awnser extends Model
{
    use HasFactory, Hashid, SoftDeletes;
    protected $table = 'tickets_awnsers';
    protected $fillable = ['user_id', 'client_id', 'ticket_id', 'message', 'from', 'type'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function attach(){
        return $this->hasMany(File::class, 'awnser_id', 'id');
    }
}
