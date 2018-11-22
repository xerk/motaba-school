<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttentionType extends Model
{
    protected $table = 'attention_types';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'body',
    ];

    /**
     * Show the Attention Has Many AttentionType.
     *
     * @return App\Attention
     */
    public function attention()
    {
        return $this->hasMany('App\Attention');
    } 

}
