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
    
}
