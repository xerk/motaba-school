<?php

namespace App\Http\Controllers;

use App\User;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Html\Builder;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class EmpReportController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $browes = Voyager::canOrFail('browse_employee_reports');
        return view('vendor.voyager.reports.employee');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(Request $request)
    {
            $users = User::where(function ($query) use ($request) {
                $query->where('job', '=', 0);
            });

        return Datatables::of($users)->toJson();
    }
}
