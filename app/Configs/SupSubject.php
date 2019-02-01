<?php

namespace App\Configs;

use Illuminate\Database\Eloquent\Model;

class SupSubject extends Model
{
    protected $table = 'sup_subjects';
    
    protected $fillable = ['status', 'subject_id', 'exam_id', 'type_exam_id', 'degree'];

    /**
     * Show the SupSubject Belongs To Subject.
     *
     * @return App\Configs\Subject
     */
    public function subjects()
    {
        return $this->belongsTo('App\Configs\Subject', 'subject_id', 'id');
    }

    /**
     * Show the SupSubject Belongs To ClassEdu.
     *
     * @return App\Configs\TypeExam
     */
    public function typeExams()
    {
        return $this->belongsTo('App\Configs\TypeExam');
    }
}
