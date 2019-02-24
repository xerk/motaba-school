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
        'user_id', 'cost', 'pay', 'discount', 'serial_number', 'serial_number', 'bus_expenses', 'indebtedness', 'comment', 'pay_date',
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
