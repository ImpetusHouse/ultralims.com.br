<?php

namespace App\Models\General\Cards;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'cards';

    protected $fillable = ['category_id', 'subcategory_id', 'order', 'page_id', 'title', 'description', 'modal_description', 'type', 'link', 'file', 'status'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
}
