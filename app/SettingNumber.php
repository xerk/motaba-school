<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingNumber extends Model
{

    protected $table = 'setting_numbers';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting_number',
    ];

    /**
     * Get the user that owns the setting number.
     * 
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
