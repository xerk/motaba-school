<?php

namespace App\Http\Controllers;

use App\User;
use App\Attendance;
use App\EmployeeSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TCG\Voyager\Facades\Voyager;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Html\Builder;
use App\Http\Controllers\Controller;

class SalaryReportController extends Controller
{
        /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $browes = Voyager::canOrFail('browse_salary_reports');
        return view('vendor.voyager.reports.salary-monthely');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(Request $request)
    {   
        $users = User::with('addSalary')->whereHas('addSalary')->withCount(['attendance as sum_discount' => function($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])
                ->select(DB::raw('sum(discount + loan + penalty)'));
        }])->withCount(['attendance as count_late' => function($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])
                ->where('status', '4');
        }])->withCount(['attendance as count_absent' => function($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])
                ->where('status', '3');
        }])
            ->where('job', 0);
        
        return Datatables::of($users)->toJson();
    }
}
