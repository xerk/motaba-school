<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecretNumber extends Model
{
    protected $table = 'setting_numbers';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'secret_number',
    ];

    /**
     * Get the user that owns the secret number.
     * 
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
