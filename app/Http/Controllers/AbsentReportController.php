<?php

namespace App\Http\Controllers;

use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Carbon;
use App\Attendance;

class AbsentReportController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $browes = Voyager::canOrFail('browse_absent_students');
        return view('vendor.voyager.reports.absent-students');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(Request $request)
    {
        // dd($request->all());
        $date = Carbon::now()->addDays($request->day);
        $dateString = $date->toDateString();
        $attendances = Attendance::where(function ($query) use ($date, $request) {
            $query->where('attend_date', '=', $date->toDateString())->where('status', 3)->whereHas('users' , function ($query) use ($request) {
                $query->where('classroom_id', '=', $request->classroom)->where('job', '=', 1);
            });
        })->with('users')->get();

        return Datatables::of($attendances)->toJson();
    }

    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndexEmp()
    {
        $browes = Voyager::canOrFail('browse_absent_employees');
        return view('vendor.voyager.reports.absent-emp');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyDataEmp(Request $request)
    {
        // dd($request->all());
        $date = Carbon::now()->addDays($request->day);
        $dateString = $date->toDateString();
        $attendances = Attendance::where(function ($query) use ($date, $request) {
            $query->where('attend_date', '=', $date->toDateString())->where('status', 3)->whereHas('users' , function ($query) use ($request) {
                $query->where('job', '=', 0);
            });
        })->with('users')->get();

        return Datatables::of($attendances)->toJson();
    }
}
