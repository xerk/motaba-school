<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attention extends Model
{
    protected $table = 'attentions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'attention_type_id', 'author_id', 'end_date', 'body'
    ];

    /**
     * Show the Attention Belongs To AttentionType.
     *
     * @return App\AttentionType
     */
    public function attentionTypes()
    {
        return $this->belongsTo('App\AttentionType', 'attention_type_id', 'id');
    }

     /**
     * Show the Attendance Belongs To User.
     *
     * @return App\User
     */
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Show the Attendance Belongs To User.
     *
     * @return App\User
     */
    public function authors()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }
}
