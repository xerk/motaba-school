<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use App\User;
use App\LinkTeacher;
use App\Configs\StageEdu;
use App\Configs\ClassEdu;
use App\Configs\ClassRoom;
use App\Configs\Subject;


class LinkTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_link_teachers');
        return view('vendor.voyager.links.link-teachers');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')) {
            LinkTeacher::create([
                'user_id' => $request->user_id,
                'subject_id' => $request->model['subjectSelect'],
                'stage_id' => $request->model['stageSelect'],
                'class_id' => $request->model['classSelect'],
                'classroom_id' => $request->model['classRoomSelect'],
                'supervision' => $request->model['supervision'],
            ]);
            return response('Item has been added!', 200);

        } else {
            return response('You are not a method post!', 200);
        }
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
        if($request->isMethod('post')) {
            $linkTeacher = LinkTeacher::find($request->model['id']);
            $linkTeacher->user_id           = $request->model['user_id'];
            $linkTeacher->subject_id        = $request->model['subject_id'];
            $linkTeacher->stage_id          = $request->model['stage_id'];
            $linkTeacher->class_id          = $request->model['class_id'];
            $linkTeacher->classroom_id      = $request->model['classroom_id'];
            $linkTeacher->supervision      = $request->model['supervision'];
            $linkTeacher->save();

            return response('Item has been updated!', 200);
        } else {
            return response('You are not a method post!', 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LinkTeacher::where('id', $id)->delete();

        return response('Link a Teacher has beend deleted.', 200);
    }

    public function getTeachers() {
        $users = User::withCount('linkTeachers')->where('job', 0)->get();

        return [
            'users' => $users
        ];
    }

    public function getTeacher(Request $request) {
        $user = User::where(function ($query) use ($request) {
            $query->where('job', '=', 0)->where('id', $request->id);
        })->first();

        $linkTeachers = LinkTeacher::where('user_id', $request->id)->with('stageEdu', 'classEdu', 'classRoom', 'user', 'subject')->get();

        $stageEdu = StageEdu::all();
        $classEdu = ClassEdu::with('stageEdu')->get();
        $classRoom = ClassRoom::with('classEdu')->get();
        $subjects = Subject::all();

        return [
            'user' => $user,
            'linkTeachers' => $linkTeachers,
            'stageEdu' => $stageEdu,
            'classEdu' => $classEdu,
            'classRoom' => $classRoom,
            'subjects' => $subjects,
        ];
    }
}
