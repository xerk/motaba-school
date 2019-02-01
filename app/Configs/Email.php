<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails';
    
    protected $fillable = ['email', 'school_config_id'];

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
