<?php

namespace App\Models\General\Products;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'products';

    protected $fillable = ['display_order', 'photo', 'title', 'description', 'benefits', 'slug', 'status'];

    public function categories(){
        return $this->belongsToMany(Category::class, 'products_categories_pivot', 'product_id', 'category_id')->withTimestamps();
    }
}
