<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class LinkTeacher extends Model
{
    protected $table = 'link_teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'subject_id', 'stage_id', 'class_id', 'classroom_id', 'supervision',
    ];

    /**
     * Show the LinkTeacher Has Many User.
     *
     * @return App\Attendance
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Show the LinkTeacher Has Many Subject.
     *
     * @return App\Attendance
     */
    public function subject()
    {
        return $this->belongsTo('App\Configs\Subject', 'subject_id', 'id');
    }

    /**
     * Show the LinkTeacher Belongs To StageEdu.
     *
     * @return App\ClassEdu
     */
    public function stageEdu()
    {
        return $this->belongsTo('App\Configs\StageEdu', 'stage_id', 'id');
    }

    /**
     * Show the LinkTeacher Belongs To ClassEdu.
     *
     * @return App\ClassEdu
     */
    public function classEdu()
    {
        return $this->belongsTo('App\Configs\ClassEdu', 'class_id', 'id');
    }

    /**
     * Show the LinkTeacher Belongs To ClassEdu.
     *
     * @return App\ClassEdu
     */
    public function classRoom()
    {
        return $this->belongsTo('App\Configs\ClassRoom', 'classroom_id', 'id');
    }
}
