<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Category;

class Post extends Model
{
    /**
     * Show the Page Belongs To User.
     *
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    /**
     * Show the Page Belongs To Category.
     *
     * @return App\Category
     */
    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->with('user')->first();
    }
}
