<?php

namespace App\Models\General\Portfolios;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Category extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'portfolio_categories';

    protected $fillable = ['title', 'display_order'];

    public function portfolios(){
        return $this->belongsToMany(Portfolio::class, 'portfolios_categories_pivot', 'category_id', 'portfolio_id')
            ->withTimestamps()
            ->withPivot('display_order')
            ->orderBy('portfolios_categories_pivot.display_order', 'asc');
    }
}
