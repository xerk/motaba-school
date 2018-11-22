<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    
    protected $fillable = ['name', 'class_edu_id', 'super_degree', 'failure_degree'];

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
     * Show the SchoolYear Has Many Semster.
     *
     * @return App\Configs\Semster
     */
    public function supSubjects()
    {
        return $this->hasMany('App\Configs\SupSubject');
    } 
}
