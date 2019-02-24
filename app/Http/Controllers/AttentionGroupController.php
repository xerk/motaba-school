<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;
use App\AttentionGroupType;
use App\AttentionGroup;
use App\Configs\StageEdu;
use App\Configs\ClassEdu;
use App\Configs\ClassRoom;

class AttentionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_gattentions');
        return view('vendor.voyager.attentions.gattentions');
    }

    /**
     * Create resource to send api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $types = AttentionGroupType::all();
        if ($request->stageEdu == null) {
            $attentions = collect([]);
        } else if ($request->classEdu == null) {
            $attentions = AttentionGroup::where('stage_id', $request->stageEdu)
            ->with('stageEdu', 'classEdu', 'classRoom', 'attentionType', 'author')
            ->get();
        } else if ($request->classRoom == null) {
            $attentions = AttentionGroup::where('stage_id', $request->stageEdu)
            ->where('class_id', $request->classEdu)
            ->with('stageEdu', 'classEdu', 'classRoom', 'attentionType', 'author')
            ->get();
        } else {
            $attentions = AttentionGroup::where('stage_id', $request->stageEdu)
            ->where('class_id', $request->classEdu)
            ->where('classroom_id', $request->classRoom)
            ->with('stageEdu', 'classEdu','classRoom', 'attentionType', 'author')
            ->get();
        }

        $stageEduShow = StageEdu::where('id', $request->stageEdu)->first();
        $classEduShow = ClassEdu::where('id', $request->classEdu)->first();
        $classRoomShow = ClassRoom::where('id', $request->classRoom)->first();

        if ($request->stageEdu == null) {
            $StudentCount = collect([]);
        } else if ($request->classEdu == null) {
            $StudentCount = User::where('stage_id', $request->stageEdu)
            ->where('job', 1)
            ->count();
        } else if ($request->classRoom == null) {
            $StudentCount = User::where('stage_id', $request->stageEdu)
            ->where('class_id', $request->classEdu)
            ->where('job', 1)
            ->count();
        } else {
            $StudentCount = User::where('stage_id', $request->stageEdu)
            ->where('class_id', $request->classEdu)
            ->where('classroom_id', $request->classRoom)
            ->where('job', 1)
            ->count();
        }

        return [
            'types' => $types,
            'attentions' => $attentions,
            'stageEduShow' => $stageEduShow,
            'classEduShow' => $classEduShow,
            'classRoomShow' => $classRoomShow,
            'StudentCount' => $StudentCount,
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
        if($request->isMethod('post')) {
            AttentionGroup::create([
                'stage_id' => $request->stage_id,
                'class_id' => $request->class_id,
                'classroom_id' => $request->classroom_id,
                'attention_group_type_id' => $request->type,
                'author_id' => Auth::id(),
                'end_date' => $request->end_date,
                'body' => $request->body,
                'amount' => $request->amount,
            ]);
            return response()->json('Attention Group has been Add', 200);
        } else {
            return response('You are not a method post!', 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $types = AttentionGroupType::all();
        $attention = AttentionGroup::with('stageEdu', 'classEdu', 'classRoom', 'attentionType', 'author')->find($request->edit);

        $stageEduShow = StageEdu::where('id', $request->stageEdu)->first();
        $classEduShow = ClassEdu::where('id', $request->classEdu)->first();
        $classRoomShow = ClassRoom::where('id', $request->classRoom)->first();

        if ($request->stageEdu == null) {
            $StudentCount = User::where('job', 1)->count();
        } else if ($request->classEdu == null) {
            $StudentCount = User::where('stage_id', $request->stageEdu)
            ->where('job', 1)
            ->count();
        } else if ($request->classRoom == null) {
            $StudentCount = User::where('stage_id', $request->stageEdu)
            ->where('class_id', $request->classEdu)
            ->where('job', 1)
            ->count();
        } else {
            $StudentCount = User::where('stage_id', $request->stageEdu)
            ->where('class_id', $request->classEdu)
            ->where('classroom_id', $request->classRoom)
            ->where('job', 1)
            ->count();
        }

        return [
            'types' => $types,
            'attention' => $attention,
            'stageEduShow' => $stageEduShow,
            'classEduShow' => $classEduShow,
            'classRoomShow' => $classRoomShow,
            'StudentCount' => $StudentCount,
        ];
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
        $attention = AttentionGroup::find($request->id);
        $attention->stage_id = $request->stage_id;
        $attention->class_id = $request->class_id;
        $attention->classroom_id = $request->classroom_id;
        $attention->author_id = Auth::id();
        $attention->end_date = $request->end_date;
        $attention->attention_group_type_id = $request->type;
        $attention->body = $request->body;
        $attention->amount = $request->amount;
        $attention->save();

        return response('Attention has been updated!', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AttentionGroup::where('id', $id)->delete();

        return response('Attention Group has beend deleted.', 200);
    }
}
