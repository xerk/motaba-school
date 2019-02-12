<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Timetable extends Model
{
    protected $table = 'timetables';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_id', 'order', 'order', 'day_name', 'start_at', 'end_at', 'class_room_id'
    ];

    /**
     * Show the Timetable Belongs To ClassRoom.
     *
     * @return App\ClassEdu
     */
    public function classRoom()
    {
        return $this->belongsTo('App\Configs\ClassRoom', 'class_room_id');
    }

    /**
     * Show the Timetable Belongs To Subject.
     *
     * @return App\ClassEdu
     */
    public function subject()
    {
        return $this->belongsTo('App\Configs\Subject', 'subject_id');
    }
}
