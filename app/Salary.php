<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salaries';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grade', 'basic', 'overtime', 'day_absence',
    ];

    /**
     * Show the Deduction Has Many Salary.
     *
     * @return App\Deduction
     */
    public function deduction()
    {
        return $this->hasMany('App\Deduction');
    } 

    /**
     * Show the Allowance Has Many Salary.
     *
     * @return App\Allowance
     */
    public function allowance()
    {
        return $this->hasMany('App\Allowance');
    } 
}
