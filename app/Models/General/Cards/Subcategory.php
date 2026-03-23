<?php

namespace App\Models\General\Cards;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cards_subcategories';

    protected $fillable = ['category_id', 'order', 'title'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function cards(){
        return $this->hasMany(Card::class);
    }
}
