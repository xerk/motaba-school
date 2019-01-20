<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class ClassEdu extends Model
{
    protected $table = 'class_edus';
    
    protected $fillable = ['name', 'stage_edu_id', 'egy_edu_system_id'];
    

    /**
     * Show the ClassEdu Belongs To StageEdu.
     *
     * @return App\Configs\StageEdu
     */
    public function stageEdu()
    {
        return $this->belongsTo('App\Configs\StageEdu');
    }

    /**
     * Show the ClassEdu Belongs To EgyEduSystem.
     *
     * @return App\Configs\EgyEduSystem
     */
    public function egyEduSystem()
    {
        return $this->belongsTo('App\Configs\EgyEduSystem');
    }

    /**
     * Show the ClassEdu Has Many LinkTeacher.
     *
     * @return App\LinkTeacher
     */
    public function linkTeacher()
    {
        return $this->hasMany('App\LinkTeacher', 'class_id', 'id');
    } 

    /**
     * Show the ClassEdu Has Many Users.
     *
     * @return App\LinkTeacher
     */
    public function users()
    {
        return $this->hasMany('App\User', 'class_id', 'id');
    } 

    /**
     * Show the StageEdu Has Many ClassEdu.
     *
     * @return App\Configs\ClassEdu
     */
    public function classRoom()
    {
        return $this->hasMany('App\Configs\ClassRoom');
    } 

    public static function boot() {
        parent::boot();

        static::deleting(function($classEdu) { // before delete() method call this
             $classEdu->classEdu()->delete();
             // do the rest of the cleanup...
        });
    }
}
