<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'content', 'image', 'category_id'];

    //One To Many (Inverse)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
