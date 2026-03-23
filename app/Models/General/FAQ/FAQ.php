<?php

namespace App\Models\General\FAQ;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQ extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'faq';

    protected $fillable = ['category_id', 'display_order_category', 'display_order', 'title', 'description'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
