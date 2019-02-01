<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
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

    
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->with('user')->first();
    }

    
}
