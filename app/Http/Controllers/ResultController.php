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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }

    public function getResults(Request $request)
    {
        $typeExams = TypeExam::find($request->type);
        $supSubject = SupSubject::find($request->subject);

        return [
            'typeExams' => $typeExams,
            'supSubject' => $supSubject,
        ];
    }
}
