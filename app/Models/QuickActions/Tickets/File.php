<?php

namespace App\Models\QuickActions\Tickets;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory, Hashid;
    protected $table = 'tickets_files';
    protected $fillable = ['path', 'name', 'extension', 'size', 'from', 'ticket_id', 'awnser_id', 'user_id', 'client_id'];
}
