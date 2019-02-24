<?php

namespace App\Http\Controllers\ConfigSchool;

use App\Http\Controllers\Controller;
use TCG\Voyager\Facades\Voyager;
use App\Configs\StageEdu;
use App\Configs\EgyEduSystem;
use App\Configs\ClassEdu;
use App\Configs\ClassRoom;
use Illuminate\Http\Request;
use App\Configs\Subject;
use App\Configs\Exam;
use App\Configs\TypeExam;
use App\Configs\SupSubject;
use App\LinkTeacher;
use Illuminate\Support\Facades\Auth;

class StageEduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_system_configs');
        return view('vendor.voyager.configs.systemConfigs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if($request->stage) {
                StageEdu::create([
                    'name'   => $request->stage['name'],
                    'description'   => $request->stage['description'],
                ]);
            return response('Item\'s has been Add', 200);
        }

        if($request->class) {
            ClassEdu::create([
                'name'   => $request->class['name'],
                'stage_edu_id'   => $request->class['stage_edu_id'],
                'egy_edu_system_id'   => $request->class['egy_edu_system_id'],
            ]);
            return response($request->class['name'] .' has been Add', 200);
        }

        if($request->classRoom) {
            ClassRoom::create([
                'name'   => $request->classRoom['name'],
                'class_edu_id'   => $request->classRoom['class_edu_id'],
            ]);
            return response($request->classRoom['name'] .' has been Add', 200);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $stageEdu = StageEdu::find($request->model['id']);
        $stageEdu->name = $request->model['name'];
        $stageEdu->description = $request->model['description'];
        $stageEdu->save();

        return response('Stage '.$request->model['name'].' has been updated!', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function updateClass(Request $request)
    {
        $classEdu = ClassEdu::find($request->model['id']);
        $classEdu->name = $request->model['name'];
        $classEdu->stage_edu_id = $request->model['stage_edu_id'];
        $classEdu->egy_edu_system_id = $request->model['egy_edu_system_id'];
        $classEdu->save();

        return response('Class '.$request->model['name'].' has been updated!', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function updateClassRoom(Request $request)
    {
        $classRoomEdu = ClassRoom::find($request->model['id']);
        $classRoomEdu->name = $request->model['name'];
        $classRoomEdu->class_edu_id = $request->model['class_edu_id'];
        $classRoomEdu->save();

        return response('Class Room '.$request->model['name'].' has been updated!', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StageEdu::where('id', $id)->delete();

        return response('Item has beend deleted.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function destroyClass($id)
    {
        ClassEdu::where('id', $id)->delete();

        return response('Item has beend deleted.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function destroyClassRoom($id)
    {
        ClassRoom::where('id', $id)->delete();

        return response('Item has beend deleted.', 200);
    }

    public function getSystemConfig(Request $request)
    {
        $link = LinkTeacher::where('user_id', Auth()->id())->get();

        if (!$link->isEmpty()) {
            $stageEduPerm = StageEdu::whereHas('linkTeacher', function($query) {
                $query->where('user_id', '=', Auth()->id());
            })->get();

            $classEduPerm = ClassEdu::whereHas('linkTeacher', function($query) {
                $query->where('user_id', '=', Auth()->id());
            })->get();

            $classEduEmpty = StageEdu::whereHas('linkTeacher', function($query) {
                $query->where('user_id', '=', Auth()->id())->where('class_id', null);
            })->with('classEdu')->get();

            $classRoomEduPerm = ClassRoom::whereHas('linkTeacher', function($query) {
                $query->where('user_id', '=', Auth()->id());
            })->get();

            $classRoomEmpty = ClassEdu::whereHas('linkTeacher', function($query) {
                $query->where('user_id', '=', Auth()->id())->where('classroom_id', null);
            })->with('classRoom')->get();

            // $subjects = Subject::whereHas('linkTeachers', function($query) {
            //     $query->where('user_id', '=', Auth()->id());
            // })->with('supSubjects')->get();

        } else {
            $stageEduPerm = StageEdu::all();
            $classEduPerm = ClassEdu::with('stageEdu', 'egyEduSystem')->get();
            $classRoomEduPerm = ClassRoom::with('classEdu')->get();
            $classEduEmpty = collect([]);
            $classRoomEmpty = collect([]);
        }


        $eduSystem = EgyEduSystem::all();
        $stageEdu = StageEdu::all();
        $classEdu = ClassEdu::with('stageEdu', 'egyEduSystem')->get();
        $classRoom = ClassRoom::with('classEdu')->get();
        $supsubjects = SupSubject::with('subjects')->get();
        $exams = Exam::all();
        $typeExams = TypeExam::all();

        return [
            'stageEduPerm' => $stageEduPerm,
            'classEduPerm' => $classEduPerm,
            'classRoomEduPerm' => $classRoomEduPerm,
            'classEduEmpty' => $classEduEmpty,
            'classRoomEmpty' => $classRoomEmpty,
            'stageEdu' => $stageEdu,
            'classEdu' => $classEdu,
            'classRoom' => $classRoom,
            'eduSystem' => $eduSystem,
            'supsubjects'  => $supsubjects,
            // 'subjects'  => $subjects,
            'exams'  => $exams,
            'typeExams'  => $typeExams,
        ];
    }
}
