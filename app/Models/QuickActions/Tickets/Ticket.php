<?php

namespace App\Models\QuickActions\Tickets;

use App\Models\User;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id', 'client_id', 'refusal_id',
        'opened_by', 'closed_by', 'contact_by', 'old_user_id',
        'type', 'title', 'description', 'status',
        'utm_source', 'utm_medium', 'utm_campaign'
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function openedBy(){
        return $this->belongsTo(User::class, 'opened_by', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'tickets_users_pivot', 'ticket_id', 'user_id');
    }

    public function awnsers(){
        return $this->hasMany(Awnser::class);
    }

    public function files(){
        return $this->hasMany(File::class);
    }

    public function closedBy(){
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function getFirstAwnser(){
        return $this->awnsers()->orderBy('id', 'asc')->first() ?? null;
    }

}
