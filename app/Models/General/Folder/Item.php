<?php

namespace App\Models\General\Folder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'folders_items';

    protected $fillable = ['folder_id', 'title', 'path', 'size', 'extension'];

    public function folder(){
        return $this->belongsTo(Folder::class);
    }
}
