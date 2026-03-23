<?php

namespace App\Models\General\Topics;

use App\Models\Pages\Page;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'topics';

    protected $fillable = ['category_id', 'page_id', 'display_order', 'path', 'title', 'description', 'status'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function page(){
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
