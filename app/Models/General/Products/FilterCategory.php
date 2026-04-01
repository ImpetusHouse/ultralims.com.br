<?php

namespace App\Models\General\Products;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilterCategory extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'products_filter_categories';

    protected $fillable = ['display_order', 'title'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_filter_categories_pivot', 'filter_category_id', 'product_id')
            ->withTimestamps();
    }
}
