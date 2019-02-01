<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $table = 'social_media';
    
    protected $fillable = ['name'];

    /**
     * Show the SocialMedia Belongs To Many SchoolConfig.
     *
     * @return App\Configs\SchoolConfig
     * @return App\SocialMediaSchools
     */
    public function schoolConfigs()
    {
        return $this->belongsToMany('App\Configs\SchoolConfig', 'social_media_schools', 'social_id', 'school_config_id');
    }
}
