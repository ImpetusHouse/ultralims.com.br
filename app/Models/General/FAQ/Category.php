<?php

namespace App\Models\General\FAQ;

use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Hashid, SoftDeletes;

    protected $table = 'faq_categories';

    protected $fillable = ['display_order', 'title', 'display'];

    public function frequentlyQuestion()
    {
        return $this->hasMany(FAQ::class, 'category_id', 'id');
    }
}
