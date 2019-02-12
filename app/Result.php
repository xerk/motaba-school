<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sup_subject_id', 'exam_id', 'exam1',
    ];

    /**
     * Show the Result Belongs To User.
     *
     * @return App\ClassEdu
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Show the Result Belongs To SupSubject.
     *
     * @return App\ClassEdu
     */
    public function supSubject()
    {
        return $this->belongsTo('App\Configs\SupSubject', 'sup_subject_id');
    }

    /**
     * Show the Result Belongs To Exam.
     *
     * @return App\ClassEdu
     */
    public function exam()
    {
        return $this->belongsTo('App\Configs\Exam', 'exam_id');
    }
}
