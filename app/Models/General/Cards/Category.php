<?php

namespace App\Models\General\Cards;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cards_categories';

    protected $fillable = ['title'];

    public function cards(){
        return $this->hasMany(Card::class);
    }

    public function subcategories(){
        return $this->hasMany(Subcategory::class)->orderBy('order');
    }
}
