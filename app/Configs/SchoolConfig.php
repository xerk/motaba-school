<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class SchoolConfig extends Model
{
    protected $table = 'school_configs';
    
    protected $fillable = [
        'school_name',
        'edu_system_id', // Belongs To EduSystem
        'government_id', // Belongs To Government
        'edu_manag_id', // Belongs To EduManag
        'address', 
        'school_manager',
        'follow_manager',
        'website',
        'license_number',
        'school_logo',
        'school_cover',
        'footer',
    ];
    
    ######################## Belongs To ###################

    /**
     * Show the SchoolConfig Belongs To EduSystem.
     *
     * @return App\Configs\EduSystem
     */
    public function eduSystem()
    {
        return $this->belongsTo('App\Configs\EduSystem');
    }

    /**
     * Show the SchoolConfig Belongs To government.
     *
     * @return App\Configs\Government
     */
    public function government()
    {
        return $this->belongsTo('App\Configs\Government');
    }

    /**
     * Show the SchoolConfig Belongs To EduManag.
     *
     * @return App\Configs\EduManag
     */
    public function eduManag()
    {
        return $this->belongsTo('App\Configs\EduManag');
    }

    ################# Has Many #####################

    /**
     * Show the School Config Has Many Telephone.
     *
     * @return App\Configs\Telephone
     */
    public function telephones()
    {
        return $this->hasMany('App\Configs\Telephone');
    }
    
    /**
     * Show the School Config Has Many Mobile.
     *
     * @return App\Configs\Mobile
     */
    public function mobiles()
    {
        return $this->hasMany('App\Configs\Mobile');
    }

    /**
     * Show the School Config Has Many Fax.
     *
     * @return App\Configs\Fax
     */
    public function faxes()
    {
        return $this->hasMany('App\Configs\Fax');
    }

    /**
     * Show the School Config Has Many Email.
     *
     * @return App\Configs\Email
     */
    public function emails()
    {
        return $this->hasMany('App\Configs\Email');
    }

    ############### BelongsToMany ###################

    /**
     * Show the School Config Belongs To Many SocialMedia.
     *
     * @return App\Configs\SocialMedia
     * @return App\SocialMediaSchools
     */
    public function socialMedia()
    {
        return $this->belongsToMany('App\Configs\SocialMedia', 'social_media_schools', 'school_config_id', 'social_id');
    }
}
