<?php

namespace App\Models\Settings\LGPD;

use App\Models\Pages\Page;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lgpd extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'lgpd';

    protected $fillable = [
        'page_id', 'type', 'accept',
        'name', 'phone', 'email',
        'ip'
    ];

    public function page(){
        return $this->belongsTo(Page::class);
    }
}
