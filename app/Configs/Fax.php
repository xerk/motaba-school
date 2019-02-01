<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class Fax extends Model
{
    protected $table = 'faxes';
    
    protected $fillable = ['fax', 'school_config_id'];

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
