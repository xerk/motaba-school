<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    protected $table = 'governments';
    
    protected $fillable = ['name', 'description'];
    

    /**
     * Show the Governments Has Many School Config.
     *
     * @return App\Configs\SchoolConfig
     */
    public function schoolConfigs()
    {
        return $this->hasMany('App\Configs\SchoolConfig');
    } 

    /**
     * Show the Governments Has Many EduManag.
     *
     * @return App\Configs\EduManag
     */
    public function eduManags()
    {
        return $this->hasMany('App\Configs\EduManag');
    } 
}
