<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class StatusStudent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Show the Attendance Has Many Lecture.
     *
     * @return App\Attendance
     */
    public function users()
    {
        return $this->hasMany('App\User', 'status_id');
    }
}
