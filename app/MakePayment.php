<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MakePayment extends Model
{
    protected $table = 'make_payments';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'payment_method', 'net_salary', 'payment_amount', 'comment',
    ];

    /**
     * Show the Attendance Has Many Lecture.
     *
     * @return App\Attendance
     */
    public function users()
    {
        return $this->belongsTo('App\User');
    } 
}
