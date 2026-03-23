<?php

namespace App\Models\General\Testimonials;

use App\Models\General\Courses\Course;
use App\Models\General\Testimonials\Testimonial;
use App\Models\Settings\MegaMenu\MegaMenu;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'testimonials_categories';

    protected $fillable = ['title'];

    public function testimonials()
    {
        return $this->belongsToMany(Testimonial::class, 'testimonials_categories_pivot', 'category_id', 'testimonial_id');
    }
}
