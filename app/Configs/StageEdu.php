<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class StageEdu extends Model
{
    protected $table = 'stage_edus';
    
    protected $fillable = ['name', 'description'];
    

    /**
     * Show the StageEdu Has Many ClassEdu.
     *
     * @return App\Configs\ClassEdu
     */
    public function classEdu()
    {
        return $this->hasMany('App\Configs\ClassEdu');
    } 

    /**
     * Show the StageEdu Has Many LinkTeacher.
     *
     * @return App\LinkTeacher
     */
    public function linkTeacher()
    {
        return $this->hasMany('App\LinkTeacher', 'stage_id', 'id');
    } 
    
    public static function boot() {
        parent::boot();

        static::deleting(function($stageEdu) { // before delete() method call this
             $stageEdu->classEdu()->delete();
             // do the rest of the cleanup...
        });
    }

}
