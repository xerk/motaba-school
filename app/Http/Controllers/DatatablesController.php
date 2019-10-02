<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Yajra\Datatables\Html\Builder;
use Yajra\DataTables\Facades\DataTables;
use App\StatusStudent;

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
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndexClassList()
    {
        $browes = Voyager::canOrFail('browse_class_list_reports');
        return view('vendor.voyager.reports.class-list');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(Request $request)
    {   
        if ($request->classroom != '') {
            $users = User::with('statusStudents')->where(function ($query) use ($request) {
                $query->where('classroom_id', '=', $request->classroom)->where('job', '=', 1);
            });
        } elseif ($request->class != '') {
            $users = User::with('statusStudents')->where(function ($query) use ($request) {
                $query->where('class_id', '=', $request->class)->where('job', '=', 1);
            });
        } else {
            $users = User::with('statusStudents')->where('job', 1);
        }
        return DataTables::eloquent($users)
        ->addColumn('statusStudents', function (User $user) {
            return $user->statusStudents;
        })
                ->make(true);
    }
}
