<?php

namespace App\Models\General\Topics;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'topics_categories';

    protected $fillable = ['display_order', 'title', 'display'];

    public function topics()
    {
        return $this->hasMany(Topic::class, 'category_id', 'id');
    }
}
