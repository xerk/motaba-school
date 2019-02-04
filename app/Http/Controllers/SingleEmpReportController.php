<?php

namespace App\Http\Controllers;

use App\User;
use App\AddSalary;
use App\Attendance;
use App\MakePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\DB;

class SingleEmpReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_single_emp_report');
        return view('vendor.voyager.reports.single-emp-report');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $date = Carbon::now()->addMonth($request->month)->toDateString();
        $user = User::with('attendance')->whereHas('attendance', function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->where('id', $request->id)
        ->withCount(['attendance as count_attend' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 1);
        }])
        ->withCount(['attendance as count_holiday' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 2);
        }])
        ->withCount(['attendance as count_absent' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 3);
        }])
        ->withCount(['attendance as count_late' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 4);
        }])
        ->first();

        $attendance = User::with(['attendance' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->whereIn('status', [3, 4]);
        }])->whereHas('attendance', function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->whereIn('status', [3, 4]);
        })->where('id', $request->id)->first();


        return [
            'user' => $user,
            'date' => $date,
            'attendance' => $attendance,
        ];
    }

    public function getEmployeeDetails(Request $request) {
        $now = Carbon::now();
        $date = Carbon::now()->addMonth($request->month)->toDateString();

        $user = User::where(function($query) use ($request, $now) {
            $query->where('id', '=', $request->id)
                ->where('job', '=', 0);
        })->with(['attendance' => function($query) use ($request, $now) {
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        }])->first();
        
        $attendCount = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->where('status', 1)->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->count(); 

        $holidayCount = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->where('status', 2)->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->count(); 

        $absentCount = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();            
            $query->where('status', 3)->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->count();
        
        $lateCount = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->where('status', 4)->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->count();

        $allowances = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->sum(DB::raw('additional + bonus + incentive + reward + allowance'));

        $deductions = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->sum(DB::raw('discount + penalty + loan'));

        $addSalary = AddSalary::where('user_id', $request->id)->first();
        $makePayments = MakePayment::where('user_id', $request->id)->get();

        return [
            'userTwo' => $user,
            'attendCount' => $attendCount,
            'holidayCount' => $holidayCount,
            'absentCount' => $absentCount,
            'lateCount' => $lateCount,
            'addSalary' => $addSalary,
            'date' => $date,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'makePayments' => $makePayments,
        ];
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStudent()
    {
        $users = User::with('classEdu')->where('job', 0)->get();

        return [
            'users' => $users,
        ];
    }
    

}
