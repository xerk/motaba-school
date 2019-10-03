<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TCG\Voyager\Facades\Voyager;
use Yajra\Datatables\Html\Builder;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class NewStatusReportController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $browes = Voyager::canOrFail('browse_new_status_reports');
        return view('vendor.voyager.reports.new-status');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(Request $request)
    {   
        
        if ($request->status != 'all') {
            $users = User::with('statusStudents', 'stageEdu', 'classEdu')->where('job', 1)->where('status_id', $request->status);
        } else {
            $users = User::with('statusStudents', 'stageEdu', 'classEdu')->where('job', 1);
        }
        if ($request->classroom != '') {
            $users->where('classroom_id', '=', $request->classroom);
        } elseif ($request->class != '') {
            $users->where('class_id', '=', $request->class);
        }
        return DataTables::eloquent($users)
                    ->addColumn('statusStudents', function (User $user) {
                        return $user->statusStudents;
                    })
                    ->make(true);
    }
}
