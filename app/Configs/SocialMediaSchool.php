<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class SocialMediaSchool extends Model
{
    protected $table = 'social_media_schools';
    
    protected $fillable = ['link', 'social_id', 'school_config_id'];
}
