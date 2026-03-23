<?php

namespace App\Models\UltraLims\Articles;

use App\Models\UltraLims\Banner;
use App\Models\UltraLims\UL_User;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UL_Article_User extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'ultralims_article_clicks';

    protected $fillable = [
        'article_id', 'user_id',
    ];

    public function article(){
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function user(){
        return $this->belongsTo(UL_User::class, 'user_id');
    }
}
