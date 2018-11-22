<?php

namespace App\Http\Controllers;

use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use TCG\Voyager\Facades\Voyager;

class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $browes = Voyager::canOrFail('browse_student_reports');
        return view('vendor.voyager.reports.students');
    }

    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndexParent()
    {
        $browes = Voyager::canOrFail('browse_parent_reports');
        return view('vendor.voyager.reports.parents');
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
                $query->where('classroom_id', '=', $request->classroom)->where('job', '=', 1);
            });
        } elseif ($request->class != '') {
            $users = User::where(function ($query) use ($request) {
                $query->where('class_id', '=', $request->class)->where('job', '=', 1);
            });
        } else {
            $users = User::where('job', 1);
        }
        return Datatables::of($users)->make(true);
    }
}
