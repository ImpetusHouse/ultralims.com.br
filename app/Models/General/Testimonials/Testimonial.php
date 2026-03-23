<?php

namespace App\Models\General\Testimonials;

use App\Models\General\Testimonials\Category;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    protected $table = 'testimonials';

    use HasFactory, SoftDeletes, Hashid;

    protected $fillable = [
        'path', 'client', 'description_client', 'description',
        'link', 'thumb',
        'status'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'testimonials_categories_pivot', 'testimonial_id', 'category_id');
    }
}
