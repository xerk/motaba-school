<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Expense extends Model
{
    protected $table = 'expenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'cost', 'pay', 'discount',
    ];


     /**
     * Show the Expense Belongs To User.
     *
     * @return App\User
     */
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
