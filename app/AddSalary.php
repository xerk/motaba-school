<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AddSalary extends Model
{
    protected $table = 'add_salaries';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cost', 'absent_day',
    ];

    /**
     * Show the Attendance Has Many Lecture.
     *
     * @return App\Attendance
     */
    // public function attendance()
    // {
    //     return $this->hasMany('App\Attendance');
    // } 
}
