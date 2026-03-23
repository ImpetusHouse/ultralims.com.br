<?php

namespace App\Models\UltraLims;

use App\Models\General\Products\Product;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Product_User extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_products_users';

    protected $fillable = [
        'product_id', 'user_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(UL_User::class, 'user_id');
    }
}
