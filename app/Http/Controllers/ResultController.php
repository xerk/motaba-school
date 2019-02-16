<?php

namespace App\Http\Controllers;

use App\Result;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use App\Configs\TypeExam;
use App\Configs\SupSubject;


class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_results');
        return view('vendor.voyager.results.results');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::inser('INSERT INTO motaba.results
                        (user_id, sup_subject_id, exam_id, exam1)
                        SELECT
                            users.id, subjects_d.id, subjects_d.exam_id, 0

                        FROM
                            ((SELECT * FROM users WHERE job = 1 AND users.class_id = 36) as users
                        CROSS JOIN
                            (SELECT sup_subjects.id, sup_subjects.subject_id, sup_subjects.exam_id, subjects.name, subjects.class_edu_id FROM motaba.sup_subjects
                                INNER JOIN subjects ON subjects.id = sup_subjects.subject_id
                                    WHERE subjects.class_edu_id = 36) as subjects_d)
                            ON
                DUPLICATE
                KEY UPDATE
                                user_id=users.id, sup_subject_id=subjects_d.id, exam_id=subjects_d.exam_id');
        return 'Successfully Added';
    }

    public function getResults(Request $request)
    {
        $typeExams = TypeExam::find($request->type);
        $supSubject = SupSubject::with('subjects')->find($request->subject);

        return [
            'typeExams' => $typeExams,
            'supSubject' => $supSubject,
        ];
    }
}
