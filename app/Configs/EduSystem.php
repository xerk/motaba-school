<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class EduSystem extends Model
{
    protected $table = 'edu_systems';
    
    protected $fillable = ['name', 'description'];
    

    /**
     * Show the EduSystem Has Many School Config.
     *
     * @return App\Configs\SchoolConfig
     */

    public function schoolConfigs()
    {
        return $this->hasMany('App\Configs\SchoolConfig');
    }   

}
