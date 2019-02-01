<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class EduManag extends Model
{
    protected $table = 'edu_manags';
    
    protected $fillable = ['name', 'government_id'];
    

    /**
     * Show the EduManag Belongs To government.
     *
     * @return App\Configs\Government
     */
    public function government()
    {
        return $this->belongsTo('App\Configs\Government');
    }

    /**
     * Show the EduManag Has Many School Config.
     *
     * @return App\Configs\SchoolConfig
     */
    public function schoolConfigs()
    {
        return $this->hasMany('App\Configs\SchoolConfig');
    } 
}
