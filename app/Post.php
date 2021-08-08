<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;
use App\Tag;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'content', 'image', 'category_id'];

    //One To Many (Inverse , Post -> Category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    // many to many (Post -> Tag)
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * get tags by id
     *
     * @param [type] $tagId
     * @return boolean
     */
    public function hasTag($tagId)
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
        // return $this->tags->pluck('id')->toArray(); // get id tags and in array
    }

}
