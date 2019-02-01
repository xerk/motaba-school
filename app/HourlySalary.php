<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HourlySalary extends Model
{
    protected $table = 'hourly_salaries';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grade', 'rate', 'hours_per_month', 'day_absence',
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
}
