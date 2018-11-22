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
        if($request->stage) {
            foreach ($request->stage as $key => $item) {
                if(isset($item['id'])) {
                    StageEdu::where('id', $item['id'])->delete();
                }
                StageEdu::create([
                    'name'   => $item['name'],
                    'description'   => $item['description'],
                ]);
            }
            return response('Item\'s has been Add', 200);
        }

        if($request->class) {
            foreach ($request->class as $key => $item) {
                if(isset($item['id'])) {
                    ClassEdu::where('id', $item['id'])->delete();
                }
                ClassEdu::create([
                    'name'   => $item['name'],
                    'stage_edu_id'   => $item['stage_edu_id'],
                    'egy_edu_system_id'   => $item['egy_edu_system_id'],
                ]);
            }
            return response('Item\'s has been Add', 200);
        }

        if($request->classRoom) {
            foreach ($request->classRoom as $key => $item) {
                if(isset($item['id'])) {
                    ClassRoom::where('id', $item['id'])->delete();
                }
                ClassRoom::create([
                    'name'   => $item['name'],
                    'class_edu_id'   => $item['class_edu_id'],
                ]);
            }
            return response('Item\'s has been Add', 200);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function show(StageEdu $stageEdu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function edit(StageEdu $stageEdu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StageEdu  $stageEdu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StageEdu $stageEdu)
    {
        //
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
    
            $classRoomEduPerm = ClassRoom::whereHas('linkTeacher', function($query) {
                $query->where('user_id', '=', Auth()->id());
            })->get();
        } else {
            $stageEduPerm = StageEdu::all();
            $classEduPerm = ClassEdu::with('stageEdu', 'egyEduSystem')->get();
            $classRoomEduPerm = ClassRoom::with('classEdu')->get();
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
            'stageEdu' => $stageEdu,
            'classEdu' => $classEdu,
            'classRoom' => $classRoom,
            'eduSystem' => $eduSystem,
            'supsubjects'  => $supsubjects,
            'exams'  => $exams,
            'typeExams'  => $typeExams,
        ];
    }
}
