<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $table = 'attendances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status', 'attend_date', 'additional', 'bonus', 'incentive', 'reward', 'discount', 'allowance', 'loan', 'penalty', 'sms_status', 'comment'
    ];

    /**
     * Show the Attendance Belongs To Lecture.
     *
     * @return App\Lecture
     */
    public function lectures()
    {
        return $this->belongsTo('App\Lecture', 'lecture_id', 'id');
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

}
