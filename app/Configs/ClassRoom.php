<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $table = 'class_rooms';
    
    protected $fillable = ['name', 'class_edu_id'];
    

    /**
     * Show the ClassRoom Belongs To ClassEdu.
     *
     * @return App\Configs\ClassEdu
     */
    public function classEdu()
    {
        return $this->belongsTo('App\Configs\ClassEdu');
    }

    /**
     * Show the ClassRoom Has Many LinkTeacher.
     *
     * @return App\LinkTeacher
     */
    public function linkTeacher()
    {
        return $this->hasMany('App\LinkTeacher', 'classroom_id', 'id');
    } 

    /**
     * Show the ClassRoom Has Many LinkTeacher.
     *
     * @return App\LinkTeacher
     */
    public function timetables()
    {
        return $this->hasMany('App\Timetable', 'class_room_id');
    }
    
    /**
     * Show the ClassRoom Has Many Users.
     *
     * @return App\User
     */
    public function users()
    {
        return $this->hasMany('App\User', 'classroom_id');
    } 
}
