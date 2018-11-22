<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    protected $table = 'telephones';
    
    protected $fillable = ['tel', 'school_config_id'];

    /**
     * Show the Telephone Belongs To SchoolConfig.
     *
     * @return App\Configs\SchoolConfig
     */
    public function schoolConfig()
    {
        return $this->belongsTo('App\Configs\SchoolConfig');
    } 
}
