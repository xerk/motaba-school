<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $table = 'school_years';
    
    protected $fillable = ['name'];
    

    /**
     * Show the SchoolYear Has Many Semster.
     *
     * @return App\Configs\Semster
     */
    public function semster()
    {
        return $this->hasMany('App\Configs\Semster');
    } 
}
