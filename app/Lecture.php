<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table = 'lectures';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start_in', 'end_in',
    ];

    /**
     * Show the Attendance Has Many Lecture.
     *
     * @return App\Attendance
     */
    public function attendance()
    {
        return $this->hasMany('App\Attendance');
    } 
}
