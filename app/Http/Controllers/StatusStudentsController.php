<?php

namespace App\Http\Controllers;

use App\User;
use App\StatusStudent;
use App\Configs\ClassEdu;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;

class StatusStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_distribution_status_students');
        return view('vendor.voyager.status-students.status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statusData(Request $request)
    {
        $statusStudents = StatusStudent::with(['users' => function($q) use($request) {
            $q->where('class_id', $request->id);
        }])->get();
        $classEdus = ClassEdu::with(['users' => function ($q) {
            $q->whereNull('status_id');
        }])->where('id', $request->id)->first();

        return response()->json([
            'statusStudents' => $statusStudents,
            'classEdus' => $classEdus
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateEmptyStatus(Request $request)
    {   
        foreach ($request->users as $user) {
            User::where('id', $user['id'])->update(['status_id' => null]);
        }
        return response()->json('نجحة العملية');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAddToStatus(Request $request)
    {   
        // $result = '';
        foreach ($request->users as $user) {
            User::where('id', $user['id'])->update(['status_id' => $request->id]);
        }
        return response()->json('نجحة العملية');
    }
}
