<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'class_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
    
    /**
     * Show the User Has Many Expenses.
     *
     * @return App\Expense
     */
    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }

    /**
     * Show the User Has Many LinkTeacher.
     *
     * @return App\LinkTeacher
     */
    public function linkTeachers()
    {
        return $this->hasMany('App\LinkTeacher');
    }

    /**
     * Show the User Has Many Attention.
     *
     * @return App\Attention
     */
    public function attentions()
    {
        return $this->hasMany('App\Attention');
    } 

    /**
     * Get the setting number record associated with the user.
     * 
     * @return App\SettingNumber
     */
    public function settingNumber()
    {
        return $this->hasOne('App\SettingNumber');
    }

    /**
     * Get the secret number record associated with the user.
     * 
     * @return App\SecretNumber
     */
    public function secretNumber()
    {
        return $this->hasOne('App\SecretNumber');
    }

    /**
     * Get the committee record associated with the user.
     * 
     * @return App\SecretNumber
     */
    public function committee()
    {
        return $this->hasOne('App\Committee');
    }

    /**
     * Show the User Belongs To StageEdu.
     *
     * @return App\ClassEdu
     */
    public function stageEdu()
    {
        return $this->belongsTo('App\Configs\StageEdu', 'stage_id', 'id');
    }

    /**
     * Show the User Belongs To ClassEdu.
     *
     * @return App\ClassEdu
     */
    public function classEdu()
    {
        return $this->belongsTo('App\Configs\ClassEdu', 'class_id', 'id');
    }

    /**
     * Show the User Belongs To ClassEdu.
     *
     * @return App\ClassEdu
     */
    public function classRoom()
    {
        return $this->belongsTo('App\Configs\ClassRoom', 'classroom_id', 'id');
    }
}
