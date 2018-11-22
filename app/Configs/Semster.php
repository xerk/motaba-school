<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class Semster extends Model
{
    protected $table = 'semsters';
    
    protected $fillable = ['name', 'school_year_id'];
    

    /**
     * Show the Semster Belongs To SchoolYear.
     *
     * @return App\Configs\SchoolYear
     */
    public function schoolYear()
    {
        return $this->belongsTo('App\Configs\SchoolYear');
    } 
}
