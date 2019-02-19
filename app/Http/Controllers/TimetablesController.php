<?php

namespace App\Http\Controllers;

use App\Timetable;
use App\Configs\Subject;
use App\Configs\ClassRoom;
use Illuminate\Http\Request;

class TimetablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $timetables = Timetable::with('subject')->where('class_room_id', $request->classroom)->get();
        $classRoom = ClassRoom::with('classEdu')->where('id', $request->classroom)->first();
        $subjects = Subject::where('class_edu_id', $request->classEdu)->get();
        return [
            'timetables' => $timetables,
            'classRoom' => $classRoom,
            'subjects' => $subjects
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $timetable = Timetable::find($request->id);
        $timetable->subject_id = $request->subject;
        $timetable->save();

        return response(__('Timetable has been updated'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
