<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    protected $table = 'mobiles';
    
    protected $fillable = ['mobile', 'school_config_id'];

    /**
     * Show the Mobile Belongs To SchoolConfig.
     *
     * @return App\Configs\SchoolConfig
     */
    public function schoolConfig()
    {
        return $this->belongsTo('App\Configs\SchoolConfig');
    }
}
