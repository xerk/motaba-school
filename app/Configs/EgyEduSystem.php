<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class EgyEduSystem extends Model
{
    protected $table = 'egy_edu_systems';
    
    protected $fillable = ['name'];
    

    /**
     * Show the StageEdu Has Many ClassEdu.
     *
     * @return App\Configs\ClassEdu
     */
    public function classEdu()
    {
        return $this->hasMany('App\Configs\ClassEdu');
    }
}
