<?php

namespace App\Http\Controllers;

use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Carbon;
use App\Configs\ClassEdu;

class GenderReportController extends Controller
{
     /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $browes = Voyager::canOrFail('browse_gender_reports');
        return view('vendor.voyager.reports.genders');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(Request $request)
    {   
        $users = ClassEdu::withCount(['users as maleStudents' => function ($query) use ($request) {
            $query->where('job', '=', 1)->where('gender', '=', 1);
        }])->withCount(['users as femaleStudents' => function ($query) use ($request) {
            $query->where('job', '=', 1)->where('gender', '=', 0);
        }])->withCount('classRoom as classRoomCount')->get();

        return Datatables::of($users)->toJson();
    }
}
