<?php

namespace App\Models\General\Alerts;

use App\Models\General\Galleries\Gallery;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'alerts';

    protected $fillable = ['display_order', 'photo', 'title', 'slug', 'description', 'status'];

    public function galleries(){
        return $this->belongsToMany(Gallery::class, 'alerts_galleries_pivot', 'alert_id', 'gallery_id')->withTimestamps();
    }
}
