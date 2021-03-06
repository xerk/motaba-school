<?php

namespace App\Http\Controllers;

use App\User;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Html\Builder;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class NewcomerReportController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $browes = Voyager::canOrFail('browse_newcomer_reports');
        return view('vendor.voyager.reports.newcomer');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(Request $request)
    {   
        if ($request->classroom != '') {
            $users = User::where(function ($query) use ($request) {
                $query->where('classroom_id', '=', $request->classroom)->where('job', '=', 1)->where('status', '=', 3);
            })->with('stageEdu', 'classEdu');
        } elseif ($request->class != '') {
            $users = User::where(function ($query) use ($request) {
                $query->where('class_id', '=', $request->class)->where('job', '=', 1)->where('status', '=', 3);
            })->with('stageEdu', 'classEdu');
        } else {
            $users = User::where(function ($query) use ($request) {
                $query->where('job', '=', 1)->where('status', '=', 3);
            })->with('stageEdu', 'classEdu');
        }
        return Datatables::of($users)->toJson();
    }
}
