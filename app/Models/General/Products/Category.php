<?php

namespace App\Models\General\Products;

use App\Models\General\Portfolios\Portfolio;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Category extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'products_categories';

    protected $fillable = ['display_order', 'title'];

    public function products(){
        return $this->belongsToMany(Product::class, 'products_categories_pivot', 'category_id', 'product_id')
            ->withTimestamps()
            ->withPivot('display_order')
            ->orderBy('products_categories_pivot.display_order', 'asc');
    }
}
