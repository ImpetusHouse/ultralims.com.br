<?php

namespace App\Models\General\Portfolios;

use App\Models\Pages\Page;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'portfolios';

    protected $fillable = ['display_order', 'page_id', 'photo','title', 'tag', 'description', 'status'];

    public function page(){
        return $this->belongsTo(Page::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'portfolios_categories_pivot', 'portfolio_id', 'category_id')->withTimestamps();
    }
}
